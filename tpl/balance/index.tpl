{strip}
{include file='header.tpl' title=$_TRANS['Balance'] class="cabinet"}

<h1>{$_TRANS['Balance']}</h1>

{if isset($smarty.get.fail)}

	<h1>{$_TRANS['Operation NOT complete!']}</h1>
	<p class="info">
		{$_TRANS['The operation was was aborted or an error occurs']}.<br>
		{$_TRANS['Try']} <a href="{$_selfLink}">{$_TRANS['again']}</a> {$_TRANS['later']}
	</p>

{else}

	{include file='balance/_bal.tpl'}
	<br><br>

	<a href="{_link module='balance/oper'}?add=CASHIN" class="button-green">{$_TRANS['Add funds']}</a>

	&nbsp;<a href="{_link module='balance/oper'}?add=CASHOUT" class="button-green">{$_TRANS['Withdraw']}</a>

	{if !$_cfg.Const_IntCurr}
		&nbsp;<a href="{_link module='balance/oper'}?add=EX" class="button-green">{$_TRANS['Exchange']}</a>
	{/if}

	&nbsp;<a href="{_link module='balance/oper'}?add=TR" class="button-green">{$_TRANS['Transfer']}</a>
	<br>

	{*{if $list}*}
        <br>
        <h1>{$_TRANS['Operations']}</h1>

		{include file='balance/_statuses.tpl'}

        <script type="text/javascript" src="static/admin/js/lists.js"></script>

        {include file='edit.begin.tpl' form='opers_filter' url='*'}

        <link rel="stylesheet" type="text/css" media="all" href="{$home_site}static/admin/js/jscalendar/calendar-blue.css" title="win2k-cold-1" />
        <script type="text/javascript" src="{$home_site}static/admin/js/jscalendar/calendar.js"></script>
        <script type="text/javascript" src="{$home_site}static/admin/js/jscalendar/calendar-ru.js"></script>
        <script type="text/javascript" src="{$home_site}static/admin/js/jscalendar/calendar-setup.js"></script>

        <table class="formatTable">
        <tr>
          <td colspan="9" align="center">
              {$_TRANS['Date']} &nbsp;&nbsp;
              {$_TRANS['from2']} <input type="text" name="date_start" id="date_start" class="string_small" size="10" value="{$smarty.session[$edit_form_name].date_start}"/>&nbsp;&nbsp;
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
              {$_TRANS['till']} <input type="text" name="date_end" id="date_end" class="string_small" size="10" value="{$smarty.session[$edit_form_name].date_end}"/>
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
            {include file='edit.row.tpl' f='oOper' v=['S', {$_TRANS['Operation']}, 0, array($_TRANS['-all-']) + $op_names]
                vv=$smarty.session[$edit_form_name].oOper l_width='0%' r_width='0%'}
            <td>&nbsp;</td>
            {include file='edit.row.tpl' f='ocID' v=['S', {$_TRANS['Payment system']}, 0, array($_TRANS['-all-']) + $currs_list]
                vv=$smarty.session[$edit_form_name].ocID l_width='0%' r_width='0%'}
            <td>&nbsp;</td>
            {include file='edit.row.tpl' f='ocCurrID' v=['S', {$_TRANS['Currency account']}, 0, [0=>$_TRANS['-all-'], 'USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB', 'BTC' => 'BTC', 'ETH' => 'ETH', 'XRP' => 'XRP']]
                vv=valueIf(isset($smarty.session[$edit_form_name]), $smarty.session[$edit_form_name].ocCurrID, 9) l_width='0%' r_width='0%'}
        <tr>
        </tr>
            {include file='edit.row.tpl' f='oBatch' v=['T', {$_TRANS['Batch-number']}, 'size'=>10]
                vv=$smarty.session[$edit_form_name].oBatch l_width='0%' r_width='0%'}
            <td>&nbsp;</td>
            {include file='edit.row.tpl' f='oState' v=['S', {$_TRANS['State']}, 0, [9=>$_TRANS['-all-']] + $op_statuses]
                vv=valueIf(isset($smarty.session[$edit_form_name]), $smarty.session[$edit_form_name].oState, 9) l_width='0%' r_width='0%'}
            <td>&nbsp;</td>
            {include file='edit.row.tpl' f='oMemo' v=['T', {$_TRANS['Memo']}, 'size'=>20]
                vv=$smarty.session[$edit_form_name].oMemo l_width='0%' r_width='0%'}
        </tr>

        </table>
        {include file='edit.end.tpl' btn_text=$_TRANS['Filter'] btns=valueIf(isset($smarty.session[$edit_form_name]), ['clear'=>$_TRANS['Show all']])}

		<table cellspacing="0" cellpadding="0" border="0" width="100%" class="styleTable">
            <tr>
            	<th>{$_TRANS['Date']}</th>
                <th>{$_TRANS['Operation']}</th>
                <th>{$_TRANS['Payment system']}</th>
                {*<th>{$_TRANS['Payment']}</th>*}
                <th>{$_TRANS['Out']}</th>
                <th>{$_TRANS['Comming to account']}</th>
                <th>{$_TRANS['Batch-number']}</th>
                <th>{$_TRANS['State']}</th>
                <th>{$_TRANS['Memo']}</th>
            </tr>
            {foreach from=$list item=l}
            	<tr>
                	<td>{$l.oCTS}</td>
                    <td><a href="{_link module='balance/oper'}?id={$l.oID}">
                    	{if $l.oNTS}
                        	{$op_names[$l.oOper]}
                        {else}
                        	{$op_names[$l.oOper]}
                        {/if}
                    </a></td>
                    <td>
			{if in_array($l.oOper, ['BONUS', 'PENALTY', 'CASHIN', 'CASHOUT', 'TR', 'TRIN'])}
				<small>{$l.cName}</small><br>
                        	{_z($l.oSum2, $l.ocID, 1)}
			{/if}
                    <td>
                    	{if in_array($l.oOper, array('PENALTY', 'CASHOUT', 'EX', 'TR', 'BUY', 'GIVE', 'CALCOUT'))}
                        	<span style="color: red;">{_z($l.oSum, $l.ocCurrID, 1)}</span>
                            {if $l.oComis != 0}
                            	<br>
                                <sup>{_z($l.oComis, $l.ocCurrID, 1)}</sup>
                            {/if}
                        {/if}
                    </td>
                    <td>
                    	{if in_array($l.oOper, array('EX'))}
				{$l.oSum = $l.oSum2}
				{$l.ocCurrID = $l.ocCurrID2}
			{/if}
                    	{if in_array($l.oOper, array('BONUS', 'CASHIN', 'EX', 'TRIN', 'SELL', 'REF', 'TAKE', 'CALCIN'))}
                        	{_z($l.oSum, $l.ocCurrID, 1)}
                            {if $l.oComis != 0}
                            	<br>
                                <sup>{_z($l.oComis, $l.ocCurrID, 1)}</sup>
                            {/if}
                        {/if}
                    </td>
                    <td>{$l.oBatch}</td>
                    <td>
                    	<a href="{_link module='balance/oper'}?id={$l.oID}">
	                        {if $l.oNTS}
	                        	{$op_statuses[$l.oState]}
	                        {else}
	                        	{$op_statuses[$l.oState]}
	                        {/if}
                    	</a>
                    </td>
                    <td>{$l.oMemo}</td>
                </tr>
            {/foreach}
        </table>
		{include file='pl.tpl' linkparams=$linkparams}

		{*include file='list.tpl'
			title='Operations'
            class_tabe='styleTable'
			url='*'
			fields=[
				'oTS'=>['Date'],
				'oOper'=>['Operation'],
				'oCID'=>['Pay.system'],
				'oSum1'=>['Payment'],
                'summ_currency_operation'=>['Comming to account'],
				'oSum2'=>['Out'],
				'oBatch'=>['Batch-number'],
				'oState'=>['State'],
				'oMemo'=>['Memo']
			]
			values=$list
			row='*'
		*}

	{*{/if}*}

{/if}

{include file='footer.tpl'  class="cabinet"}
{/strip}