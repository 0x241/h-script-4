// Ajax support

function getModuleBlock($module, $block, &$params)
{
	if (!$block) 
		return "Block not defined";

	foreach ($params as $f => $v)
		setPage($f, $v, 0);
	showPage($block, $module, false);
}

function getModuleData($module, &$params)
{
	global $_GS;
	if (!$module)
		$module = $_GS['module'];
	$params['module'] = $module;
	return file_get_contents(fullURL('ajax') . 
		'?' . http_build_query($params, '', '&'));
}

// Smarty ext

function get_module_block($params)
{
	return getModuleBlock($params['module'], $params['block'], $params);
}

function get_module_data($params)
{
	return getModuleData($params['module'], $params);
}

$tpl_page->registerPlugin('function', '_getBlock', 'get_module_block');
$tpl_page->registerPlugin('function', '_getData', 'get_module_data');
