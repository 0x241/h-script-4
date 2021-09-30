{strip}
{include file='admin/admin/header.tpl' title=$_AT['Settings']}

{if $_cfg.Cron_Enabled}

	<p class="info">
		{$_AT['The scheduler is called <b>at the opening of each page</b>,<br>but can not occur more than once per <b>1 minute</b>']|html_entity_decode}
	</p>
	<p class="info">
		{$_AT['In order for the scheduler was called <b>standalone</b>,<br>it is necessary to register the call in hosting panel (cron jobs)</b>']|html_entity_decode}
		:<br>
		<br>
			<i>wget -q -O /dev/null "{fullURL(moduleToLink('cron'))}" > /dev/null</i>
		<br>
			<i>curl "{fullURL(moduleToLink('cron'))}"</i>
		<br><br>{$_AT['or(depends on hosting settings) there is can be variants']|html_entity_decode}:<br><br>
			<i>/usr/bin/fetch -q -O /dev/null "{fullURL(moduleToLink('cron'))}" > /dev/null</i>
		<br>
			<i>/usr/bin/php -q {$cronpath} /dev/null</i>
		<br>
			<i>/usr/local/bin/php -q $HOME/cron.php /dev/null</i>
	</p>

	<a href="{fullURL(moduleToLink('cron'))}" target="_blank" class="button-blue">{$_AT['Call manually']}</a><br><br>

{/if}

{$f = [
	'Enabled'=>['C', $_AT['Enabled']],
	'ByHost'=>['C', $_AT['Called standalone']]
]}
{if $cfg.Enabled and $cronlist}
	{$f[] = $_AT['Last calls']}
	{foreach $cronlist as $m => $s}
		{$f[$m] = ['X', $_AT['Module']|cat:" $m", 'comment'=> valueIf($s < 1440, "$s min. ago")]}
	{/foreach}
{/if}

{include file='edit_admin.tpl'
	values=$cfg
	fields=$f
}

{include file='admin/admin/footer.tpl'}
{/strip}