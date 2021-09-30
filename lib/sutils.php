<?php
// Text lib

if (function_exists('mb_internal_encoding'))
	mb_internal_encoding("UTF-8");
if (function_exists('mb_regex_encoding'))
	mb_regex_encoding("UTF-8");
//setlocale(LC_ALL, 'ru_RU.UTF-8');

function sEmpty($s) 
{
	return ('' === trim($s));
}

function mTrim(&$s) 
{
	if (!is_array($s)) 
		$s = trim($s);
	else 
		foreach ($s as $i => $v) 
			mTrim($s[$i]);
}

function valueIf($cond, $v1, $v2 = '')
{
	return ($cond ? $v1 : $v2);
}

function exValue($v1, $v2)
{
	return ($v2 ? $v2 : $v1);
}

function firstNotEmpty($a)
{
	if (is_array($a))
		foreach ($a as $s)
			if (!sEmpty($s))
				return $s;
	return '';
}

function textLen($s)
{
	return strlen($s);
}

function textPos($ss, $text, $reg = true)
{
	$reg ? $p = strpos($text, $ss) : $p = stripos($text, $ss);
	if ($p === false) 
		return -1;
	else
		return $p;
}

function textRPos($ss, $text, $reg = true)
{
	$reg ? $p = strrpos($text, $ss) : $p = strripos($text, $ss);
	if ($p === false) 
		return -1;
	else
		return $p;
}

function textSubStr($txt, $from, $cnt)
{
	return substr($txt, $from, $cnt);
}

function textLeft($txt, $cnt = 1)
{
	return substr($txt, 0, $cnt);
}

function textRight($txt, $cnt = 1)
{
	return substr($txt, -$cnt);
}

function textReplace($in_txt, $old_txt, $new_txt)
{
	return str_replace($old_txt, $new_txt, $in_txt);
//	return ereg_replace($old_txt, $new_txt, $in_txt);
}

function textUp($txt)
{
	return strtoupper($txt);
}

function textLow($txt)
{
	return strtolower($txt);
}

function cutElemL(&$txt, $sep, $reg = true) 
{
	$p = textPos($sep, $txt, $reg);
	if ($p < 0) 
	{
		$s = $txt;
		$txt = '';
	} 
	else 
	{
		$s = textLeft($txt, $p);
		$txt = ltrim(substr($txt, $p + textLen($sep)));
	}
	return trim($s);
}

function cutElemR(&$txt, $sep, $reg = true) 
{
	$p = textRPos($sep, $txt, $reg);
	if ($p < 0) 
	{
		$s = $txt;
		$txt = '';
	} 
	else 
	{
		$s = substr($txt, $p + textLen($sep));
		$txt = rtrim(textLeft($txt, $p));
	}
	return trim($s);
}

function get1ElemL($txt, $sep)
{
	$a = explode($sep, $txt, 2);
	return trim(reset($a));
}

function textLangFilter($text, $lng = '', $lt = '{!', $rt = '!}', $langs = array())
{
	$lng = textLow($lng);
	if ($langs and !in_array($lng, $langs)) 
		$lng = reset($langs);
	$t = '';
	$clng = ''; // current lang
	$nlng = ''; // new lang
	$i = 0;
	$i1 = $i;
	while ($i < textLen($text))
	{
		$i2 = strpos($text, $lt, $i);
		if ($i2 !== false)
		{
			if ($text{$i2 - 1} != '/')
			{
				$j = strpos($text, $rt, $i2);
				if ($j !== false)
				{
					$nlng = trim(textSubStr($text, $i2 + textLen($lt), $j - $i2 - textLen($lt)));
					if ($nlng{0} == '/')
						$nlng = '';
					$i = $j + 2;
				} 
				else
				{
					$nlng = '';
					$i = textLen($text);
				}
			}
			else
			{
				$i = $i2 + 1;
				continue;
			}
		} 
		else
		{
			$i2 = textLen($text);
			$i = $i2;
		}
		if (('' === $clng) or ($clng == $lng))
			$t .= textSubStr($text, $i1, $i2 - $i1);
		$clng = $nlng;
		$i1 = $i;
	}
	return $t;
}

function textVarReplace($text, $consts)
{
	foreach ($consts as $k => $v)
		$text = preg_replace("~#$k#~", $v, $text);
	return $text;
}

function textRandom($text)
{
	function _parse($t, &$p)
	{
		$s = '';
		for ($i = $p; $i < textLen($t); $i++)
			if ($t{$i} == '{') 
			{
				$i++;
				$s .= _parse($t, $i);
			} 
			elseif ($t{$i} == '}') 
			{
				$p = $i;
				break;
			} 
			else 
				$s .= $t{$i};
		$s = explode('|', $s);
		return $s[array_rand($s)];
	}
	$i = 0;
	return _parse($text, $i);
}

function toTranslitURL($str)
{
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    $str = strtr($str, $converter);
    $str = strtolower($str);
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    return trim($str, "-");	
//	return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $str)
}

?>
