{strip}
{*
	title:
	url: (* = selfurl)
	form: form name
	form_class: class for form
	fields: [name => 'text in header']
	values:
	table_class: class for table
	row_class: class for table row
	row: (* = default "row file")
	include_code:
	btns: [name => 'button caption']
*}

<script type="text/javascript" src="static/admin/js/lists.js"></script>

{if $title eq 'Операции'}
{include file='edit.begin.tpl' form='opers_filter' url='*'}

<link rel="stylesheet" type="text/css" media="all" href="{$home_site}static/admin/js/jscalendar/calendar-blue.css" title="win2k-cold-1" />
<script type="text/javascript" src="{$home_site}static/admin/js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="{$home_site}static/admin/js/jscalendar/calendar-ru.js"></script>
<script type="text/javascript" src="{$home_site}static/admin/js/jscalendar/calendar-setup.js"></script>

<table class="formatTable">
<tr>
  <td colspan="9" align="center">
    Дата &nbsp;&nbsp;
    с <input type="text" name="date_start" id="date_start" class="string_small" size="10" value="{$smarty.session[$edit_form_name].date_start}"/>&nbsp;&nbsp;
    <script type="text/javascript">
	              {literal}
                    Calendar.setup(
                     {
                            inputField  : "date_start",         // ID of the input field
                            ifFormat    : "%Y/%m/%d",    // the date format
                             button      : "date_start"       // ID of the button
                    }
                  );
                  {/literal}
                 </script>
    по <input type="text" name="date_end" id="date_end" class="string_small" size="10" value="{$smarty.session[$edit_form_name].date_end}"/>
    <script type="text/javascript">
	              {literal}
                    Calendar.setup(
                     {
                            inputField  : "date_end",         // ID of the input field
                            ifFormat    : "%Y/%m/%d",    // the date format
                             button      : "date_end"       // ID of the button
                    }
                  );
                  {/literal}
                 </script>
  </td>
</tr>
<tr>
	{include file='edit.row.tpl' f='uLogin' v=['T', 'Пользователь', 'size'=>10]
		vv=$smarty.session[$edit_form_name].uLogin l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='oOper' v=['S', 'Операция', 0, ['- все -'] + $op_names]
		vv=$smarty.session[$edit_form_name].oOper l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='ocID' v=['S', 'Плат.система', 0, ['- все -'] + $currs_list]
		vv=$smarty.session[$edit_form_name].ocID l_width='0%' r_width='0%'}
<tr>
</tr>
	{include file='edit.row.tpl' f='oBatch' v=['T', 'Batch-номер', 'size'=>10]
		vv=$smarty.session[$edit_form_name].oBatch l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='oState' v=['S', 'Статус', 0, [9=>'- все -'] + $op_statuses]
		vv=valueIf(isset($smarty.session[$edit_form_name]), $smarty.session[$edit_form_name].oState, 9) l_width='0%' r_width='0%'}
	<td>&nbsp;</td>
	{include file='edit.row.tpl' f='oMemo' v=['T', '<i>Примечание</i>', 'size'=>20]
		vv=$smarty.session[$edit_form_name].oMemo l_width='0%' r_width='0%'}
</tr>
<tr>
    {include file='edit.row.tpl' f='curr_operation' v=['S', 'Валюта счета', 0, [0=>'- все -'] + $currs_rates_list_values]
		vv=valueIf(isset($smarty.session[$edit_form_name]), $smarty.session[$edit_form_name].curr_operation, 9) l_width='0%' r_width='0%'}
</tr>

</table>
{include file='edit.end.tpl' btn_text='Отфильтровать' btns=valueIf(isset($smarty.session[$edit_form_name]), ['clear'=>'Показать все'])}
<br />
{else}
  {if $title}
  	<h2>{$title}</h2>
  {/if}
{/if}

{if count($values)}
	{if is_array($btns)}
		{$list_form_name=getFormName($form)}
		{include file='info.tpl' _info=getInfoData($list_form_name)}
		<form method="post"{if $url} action="{if $url == '*'}{$_selfLink}{else}{$url}{/if}"{/if} name="{$list_form_name}">
	{/if}
	<table class="{if $table_class}{$table_class}{else}list styleTable{/if}">
	<tr>
		{if is_array($btns)}
			<th width="20px" class="header">
				<input type="checkbox" id="swall" onclick="setchkbox('swall','b')" title="Отметить все">
			</th>
		{/if}
		{foreach from=$fields key=f item=v}
			<th class="header">
				{if $pl_params.Orders[$f]}
					{if textLeft($pl_params.Order, -1) == $f}
						{$z = 1 + textRight($pl_params.Order, 1)}
						<sup>{$z}</sup>
					{else}
						{$z = ''}
					{/if}
					<a href="{$_selfLink}?sort={$f}{$z}">
						{$v[0]}
					</a>
					{$zn}
				{else}
					{$v[0]}
				{/if}
			</th>
		{/foreach}
	</tr>
	{if $row_class}
		{$row_class = "{$row_class} "}
	{/if}
	{foreach name=list from=$values key=id item=l}
	<tr class="{$row_class}{if $id == $smarty.get.id}marked{elseif ($smarty.foreach.list.iteration % 2)}odd{else}even{/if}"{if $l._Marked} style="font-weight: bold;"{/if} align="left">
		{if is_array($btns)}
			<td align="center">
				<input name="ids[]" value="{$id}" id="b{$smarty.foreach.list.iteration}" type="checkbox">
			</td>
		{/if}
		{if $row == '*'}
			{include file="$tpl_filename.row.tpl"}
		{elseif $row}
			{include file=$row}
		{else}
			{foreach from=$fields key=f item=v}
				<td>
					{$l[$f]}
				</td>
			{/foreach}
		{/if}
	</tr>
	{/foreach}
	</table>
	{include file='pl.tpl' linkparams=$linkparams}
	{if is_array($btns)}
			{_getFormSecurity form=$list_form_name}
			<div>
				Отмеченные: {$include_code}
				{foreach from=$btns key=f item=v}
					&nbsp;<input name="{$list_form_name}_btn{$f}" value="{$v}" onClick="return confirm('Подтвердите операцию \'{$v}\'');" type="submit" class="button-red">
				{/foreach}
			</div>
		</form>
	{/if}
{else}
	- Нет записей -<br>
{/if}
<br>

{/strip}