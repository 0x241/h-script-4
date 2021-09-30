{strip}
{*
	table_class: class for table
	fields: array(
		[row_class] class for table row
	)
	values:
*}

{foreach from=$fields key=f item=v}
	{if is_array($v) and !$v.skip and ($v[0] == 'Y')}
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		{break}
	{/if}
{/foreach}

	{foreach from=$fields key=f item=v}
	{if is_int($f)} 			
    			{*** SECTION ***}
		<div class="form_block_el cfix">
				<hr>
				<a name="{$v}"></a>
				{if $v}- {$v} -{/if}
		</div>
	{elseif !(is_array($v) and $v.skip)}
		{$vv = _arr_val($values, $f)}
		{if is_array($v) and $v[0]}				{*** VISIBLE ***}
			<div class="form_block_el cfix">
				{include file='edit_admin.row.tpl'}
			</div>
		{else}									{*** HIDDEN ***}
			<input name="{$f}" id="{$edit_form_name}_{$f}" value="{if is_array($v)}{$vv}{else}{$v}{/if}" type="hidden">
		{/if}
	{/if}
	{/foreach}

{/strip}