<?php

// MySQL access lib v.2

require_once('lib/main.php');

define('HS2_DB_DEF_ID_FIELD', '_ID_');

class HS2_DB
{
    var $link;
	var $char_set;
	
	var $last_query;
	
	var $params;
	
	function lastError() {
		if (!$this->link)
			return "MySQL error: Connection not opened";
		return 'MySQL error: (' . mysql_errno($this->link) . ') ' . mysql_error($this->link) . 
			($this->last_query ? HS2_NL . 'Query: ' . $this->last_query : '');
	}
	
	function checkLink()
	{
		if ($this->link) 
			return true;
		xSysError($this->lastError());
	}

	function open($host, $db, $login, $pass, $char_set = 'utf8')
	{
		try 
		{
			$this->link = @mysql_connect($host, $login, $pass, true);
			$this->checkLink();
			if (!@mysql_select_db($db, $this->link))
				xSysError($this->lastError());
			$this->char_set = $char_set;
			return ($char_set ? $this->query('SET NAMES ?', $char_set) : true);
		}
		catch (Exception $e)
		{
		}
		return false;
   	}
	
	function close()
	{
		if ($this->link)
		{
			@mysql_close($this->link);
			unset($this->link);
		}
	}

	function _doQuery($query)
	{
		$this->last_query = $query;
		$t = time();
		$res = @mysql_query($query, $this->link); // ??? mysql_unbuffered_query()
		if (($t = abs(time() - $t)) >= 3)
			xAddToLog("$t: $query", 'db');
		return $res;
	}

	function _freeQuery($qr)
	{
		if (is_resource($qr))
			@mysql_free_result($qr);
	}
	
	function affCount()
	{
		$this->checkLink();
		return @mysql_affected_rows($this->link); // '-1' if error / '2' if replace
	}

	function rowCount()
	{
		$this->checkLink();
		return @mysql_num_rows($this->link); // 'false' if error
	}

	function colCount()
	{
		$this->checkLink();
		return @mysql_num_fields($this->link); // 'false' if error
	}

	function newID()
	{
		$this->checkLink();
		return @mysql_insert_id($this->link); // 'false' if error
	}
	
	function _filter($values, $fields = '') // empty fields = no filter
	{
		if (!is_array($values) or !$fields)
			return $values;
		$fields = asArray($fields);
		$v = array();
		foreach ($fields as $f)
			$v[$f] = $values[$f];
		return $v;
	}
	
	function _escape($value, $fields = '', $as_array = false)
	{
		$this->checkLink();
//		if ($value === null)
//			return 'NULL';
		if (!$as_array or !is_array($value))
			return "'" . mysql_real_escape_string(strval($value), $this->link) . "'";
		$a = array();
		foreach ($this->_filter($value, $fields) as $f => $v)
		{
			if (substr($f, -1) === '=')
				$f = trim(substr($f, 0, -1));
			else
				$v = $this->_escape($v);
			if (!is_int($f))
				$f = $this->field($f);
			$a[$f] = $v;
		}
		return $a;
	}

	function value($value, $fields = '', $as_array = false)
	{
		$value = $this->_escape($value, $fields, $as_array);
		if (!$as_array or !is_array($value))
			return $value;
		$a = array();
		foreach ($value as $f => $v)
			if (!is_int($f))
				$a[] = "$f=$v";
			else
				$a[] = $v;
		return implode(',', $a);
	}
	
	function field($name)
	{
		if (!is_array($name))
			return "`" . str_replace('`', '``', $name) . "`";
		$a = array();
		foreach ($name as $n)
			$a[] = $this->field($n);
		return implode(',', $a);
	}
	
	function query($query, $ph_values = null)
	{
		$this->checkLink();
//		if ($ph_values !== null) 
//		{
			$this->params = array_reverse(asArray($ph_values));
			$p = '{(\?)([\?\#dfail%]?)|(\#)(\#|\!|[\w_]+)}';
			$query = preg_replace_callback($p, array(&$this, '_parseParamCallback'), $query);
//		}
        $qr = $this->_doQuery($query);
		if ($qr === false)
			xSysError($this->lastError());
		if (is_resource($qr))
			return $qr;
		if (preg_match('/^\s*INSERT\s+/six', $query))
			return $this->newID();
		return $this->affCount();
	}
	
	function _parseParamCallback($m)
	{
		if ($m[2] == $m[1]) 
			return $m[1];
		switch ($m[1])
		{
		case '#':
			if ($m[2] == '!')
				return ' AS ' . HS2_DB_DEF_ID_FIELD;
			else
				return $this->field($m[2]);
		case '?':
			$v = array_pop($this->params);
			switch ($m[2])
			{
				case '#':
					return $this->field($v);
				case 'd':
					return intval($v);
				case 'f':
					return str_replace(',', '.', floatval($v));
				case 'a':
					return $this->value($v, '', true);
				case 'i':
					if (is_array($v) and (count($v) > 0))
						return 'IN (' . $this->value($v, '', true) . ')';
					else
						return 'IS NULL';
				case 'l':
				case '%':
					if (!is_string($v) or ($v === ''))
						return 'NOT IS NULL';
					if ($m[2] == '%')
						$v = '%' . $v . '%';
					return 'LIKE ' . $this->value($v);
			}
			return $this->value($v);
		}
	}

	function beginJob() 
	{
		return $this->query('START TRANSACTION');
	}

	function endJob() 
	{
		return $this->query('COMMIT');
	}

	function cancelJob() 
	{
		return $this->query('ROLLBACK');
	}

	function select($table, $fields = '*', $filter = '', $ph_values = null, $order = '', $limit = '', $group = '') 
	{
		return $this->query(
			"SELECT $fields FROM $table" .
			($filter ? " WHERE $filter" : '') .
			($group ? " GROUP BY $group" : '') .
			($order ? " ORDER BY $order" : '') .
			($limit ? " LIMIT $limit" : ''), 
			$ph_values
		);
	}

	function insert($table, $fields_and_values, $fields = '', $as_replace = false) 
	{
		$fields_and_values = $this->_filter($fields_and_values, $fields);
		if (count($fields_and_values) == 0) 
			return 0;
		return $this->query(
			($as_replace ? 'REPLACE' : 'INSERT') . " INTO $table (?#) VALUES (?a)",
			array(array_keys($fields_and_values), array_values($fields_and_values))
		);
	}

	function replace($table, $fields_and_values, $fields = '') 
	{
		return $this->insert($table, $fields_and_values, $fields, true);
	}

	function update($table, $fields_and_values, $fields = '', $filter = '', $ph_values = null) 
	{
		$fields_and_values = $this->_filter($fields_and_values, $fields);
		if (count($fields_and_values) == 0) 
			return 0;
		$ph_values = asArray($ph_values);
		array_unshift($ph_values, $fields_and_values);
		return $this->query(
			"UPDATE $table SET ?a WHERE $filter", 
			$ph_values
		);
	}

	function delete($table, $filter = '', $ph_values = null, $order = '', $limit = '') 
	{
		return $this->query(
			"DELETE FROM $table" .
			($filter ? " WHERE $filter" : '') .
			($order ? " ORDER BY $order" : '') .
			($limit ? " LIMIT $limit" : ''), 
			$ph_values
		);
	}

	function count($table, $filter = '', $ph_values = null, $field = '') 
	{
		return 0 + $this->fetch1(
			$this->select($table, 'COUNT(' . ($field ? $this->field($field) : '*') . ') AS _cnt_', 
				$filter, $ph_values)
		);
	}

	function save($table, $fields_and_values, $fields = '', $id_field = HS2_DB_DEF_ID_FIELD)
	{
		$id = intval(@$fields_and_values[$id_field]);
		if ($id > 0)
		{
			$this->update($table, $fields_and_values, $fields, "$id_field=?d", array($id));
			return $id;
		} 
		else
			return $this->insert($table, $fields_and_values, $fields);
	}
	
	function fetch($qr) 
	{
		if (!is_resource($qr))
			return false;
		return @mysql_fetch_assoc($qr);
	}

	function fetch1Row($qr) 
	{
		$res = $this->fetch($qr);
		$this->_freeQuery($qr);
		return (is_array($res) ? $res : array());
	}

	function fetch1($qr) 
	{
		$res = $this->fetch1Row($qr);
		return (is_array($res) ? reset($res) : null);
	}

	function fetchRows($qr, $single_field = false)
	{
		if (!is_resource($qr))
			return false;
		$res = array();
		while ($r = $this->fetch($qr))
			if ($single_field === 1)
				$res[] = reset($r);
			elseif ($single_field)
				$res[] = $r[$single_field];
			else
				$res[] = $r;
		$this->_freeQuery($qr);
		return $res;
	}

	function fetchIDRows($qr, $single_field = false, $id_field = HS2_DB_DEF_ID_FIELD) // single_field == '2' for '[field1]' => [field2]
	{
		if (!is_resource($qr))
			return false;
		$res = array();
		while ($r = $this->fetch($qr))
			if ($single_field === 2)
				$res[reset($r)] = next($r);
			elseif ($single_field)
				$res[$r[$id_field]] = $r[$single_field];
			else
				$res[$r[$id_field]] = $r;
		$this->_freeQuery($qr);
		return $res;
	}

}

?>