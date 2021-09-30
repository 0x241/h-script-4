{strip}
{include file='admin/admin/header.tpl' title=$_AT['Interface']}

{include file='edit_admin.tpl'
	values=$cfg
	fields=[
		'_Langs'=>['A', $_AT['Interface languages'], 'size'=>4],
		'ShowIntro'=>['S', $_AT['Show']|cat:" <a href=\"{_link module='udp/intro'}\" target=\"_blank\">"|cat:$_AT['intro']|cat:"</a>", 0, [0=>$_AT['no'], 1=>$_AT['only first time'], 2=>$_AT['always']]],
		'TopPanel'=>['C', $_AT['Show top panel']],
		'LeftPanel'=>['C', $_AT['Show left panel']],
		'RightPanel'=>['C', $_AT['Show right panel']],
		'BottomPanel'=>['C', $_AT['Show bottom panel']],
		'DefaultTZ'=>['I', $_AT['Time zone by default <<in hours GMT>>']|html_entity_decode, 'comment'=>$_AT['+3 = Moscow'], 'size'=>4],
		'NumDec'=>['S', $_AT['Number of decimal places'], 0, [0=>$_AT['no decimal (only integer)'], 1=>'1 (.0)', 2=>'2 (.00)', 3=>'3 (.000)']]
	]
}

{include file='admin/admin/footer.tpl'}
{/strip}