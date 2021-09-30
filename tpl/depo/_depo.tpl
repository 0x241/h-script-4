{strip}

{include file='depo/_statuses.tpl'}

{$chg=(($el.dState == 1) and ($el.pCompndMax > 0) and ($el.pCompndMin < $el.pCompndMax))}
{$modbuttons=[] scope='global'}
{if $chg}
	{$modbuttons['chg']='Change compaund' scope='global'}
{/if}

{$add=$el.pEnAdd}
{$sub=(($el.pClComis < 100) and ($el.dNPer >= $el.pMPer))}
{$modform=[] scope='global'}
{if ($el.dState == 1) and ($add or $sub)}
	{$modform=[
		1=>'',
		'Sum'=>
			[
				'$',
				'Сумма изменения!!',
				[
					'sum_empty'=>'укажите сумму',
					'sum_wrong'=>'неверная сумма',
					'low_bal1'=>'недостаточно средств',
					'cant_add'=>'невозможно довложить',
					'cant_sub'=>'невозможно снять',
					'plan_not_found'=>'нет подходящего плана'
				],
				'comment'=>" <i><small>{$el.cCurr}</small></i>",
				'default'=>0
			]
	] scope='global'}
	{if $add}
		{$modbuttons['add']='Add' scope='global'}
	{/if}
	{if $sub}
		{$modbuttons['sub']='Sub' scope='global'}
	{/if}
{/if}


<div class="block_form">
    {if $tpl_errors['depo/depo_frm']|count}
        <ul class="error_message">
            {$_TRANS['Please fix the following errors']}:<br/>
            {if $tpl_errors['depo/depo_frm'][0]=='compnd_wrong'}<li>{$_TRANS['Wrong value']}</li>{/if}
            {if $tpl_errors['depo/depo_frm'][0]=='sum_empty'}<li>{$_TRANS['Input amount']}</li>{/if}
            {if $tpl_errors['depo/depo_frm'][0]=='sum_wrong'}<li>{$_TRANS['Wrong amount']}</li>{/if}
            {if $tpl_errors['depo/depo_frm'][0]=='low_bal1'}<li>{$_TRANS['Insufficient funds']}</li>{/if}
            {if $tpl_errors['depo/depo_frm'][0]=='cant_add'}<li>{$_TRANS['Can`t add']}</li>{/if}
            {if $tpl_errors['depo/depo_frm'][0]=='cant_sub'}<li>{$_TRANS['Can`t sub']}</li>{/if}
            {if $tpl_errors['depo/depo_frm'][0]=='plan_not_found'}<li>{$_TRANS['No suitable plan']}</li>{/if}
            {if $tpl_errors['depo/depo_frm'][0]=='oper_disabled'}<li>{$_TRANS['Operation disabled']}</li>{/if}
        </ul>
    {/if}

    <form method="post" name="depo/depo_frm">
        <input name="dID" id="depo/depo_frm_dID" value="{$el.dID}" type="hidden">
        <input name="duID" id="depo/depo_frm_duID" value="{$el.duID}" type="hidden">
        <input name="dcCurrID" id="depo/depo_frm_dcID" value="{$el.dcCurrID}" type="hidden">

        <div class="block_form_el text_type cfix">
            <label>{$_TRANS['Status']}</label>
            <div class="block_form_el_right"><i>
                <b>{$ststrs[$el.dState]}</b>
            </i></div>
        </div>
        <div class="block_form_el text_type cfix">
            <label>{$_TRANS['Created']}</label>
            <div class="block_form_el_right"><i>{$el.dCTS}</i></div>
        </div>
        {if $from_admin}
            <div class="block_form_el text_type cfix">
                <label>{$_TRANS['User']}</label>
                <div class="block_form_el_right"><i><a href="{_link module='account/admin/user'}?id={$el.uID}">{$el.uLogin}</a></i></div>
            </div>
        {/if}
        {if $from_admin}
            <div class="block_form_el text_type cfix">
                {include file='balance/bal.tpl'}
            </div>
        {/if}
        <div class="block_form_el text_type cfix">
            <label>{$_TRANS['Curr']}</label>
            <div class="block_form_el_right"><i>{$el.dcCurrID}</i></div>
        </div>
        <div class="block_form_el text_type cfix">
            <label>{$_TRANS['Amount']}</label>
            <div class="block_form_el_right"><i>{_z($el.dZD, $el.dcCurrID, 1)}</i></div>
        </div>
        <div class="block_form_el text_type cfix">
            <label>{$_TRANS['Plan']}</label>
            <div class="block_form_el_right"><i>{valueIf($from_admin, "<a href=\"{_link module='depo/admin/plan'}?id={$el.dpID}\" target=\"_blank\">{$el.pName}</a>", $el.pName)}</i></div>
        </div>
        <div class="block_form_el text_type cfix">
            <label>{$_TRANS['Accruals']}</label>
            <div class="block_form_el_right"><i>{$el.dNPer} {$_TRANS['from']} {$el.pNPer}</i></div>
        </div>
        <div class="block_form_el text_type cfix">
            <label>{$_TRANS['Last accrual']}</label>
            <div class="block_form_el_right"><i>{$el.dLTS}</i></div>
        </div>
        <div class="block_form_el text_type cfix">
            <label>{$_TRANS['Next accrual']}</label>
            <div class="block_form_el_right"><i>{$el.dNTS}</i></div>
        </div>
        {if !$chg}
            <div class="block_form_el text_type cfix">
                <label>{$_TRANS['Compaund']}</label>
                <div class="block_form_el_right"><i>{$el.dCompnd}</i></div>
            </div>
        {/if}
        {if $chg}
            <div class="block_form_el text_type cfix">
                <label>{$_TRANS['Compaund']}</label>
                <div class="block_form_el_right">
                    <input name="Compnd" id="depo/depo_frm_Compnd" value="{if $el.Compaund}{$el.Compaund}{else}{$el.dCompnd}{/if}" type="text" >
                </div>
            </div>
        {/if}
        {if $el.dState <= 1}
            <div class="block_form_el text_type cfix">
                <label>{$_TRANS['Premature withdrawal']}</label>
                <div class="block_form_el_right">
                    {valueIf($el.pClComis >= 100, $_TRANS['Disabled'],  valueIf($el.dNPer >= $el.pMPer, $_TRANS['Enabled'], $_TRANS['Remaining accruals']|cat:($el.pMPer - $el.dNPer)))}
                </div>
            </div>
        {/if}
        {if isset($modform)}
        <div class="block_form_el cfix">
            <label>{$_TRANS['Amount of change']}</label>
            <div class="block_form_el_right"><input name="Sum" id="depo/depo_frm_Sum" value="0" type="text" style="display:inline-block;"> <i><small>{$el.cCurr}</small></i></div>
        </div>
        {/if}

        {_getFormSecurity form='depo/depo_frm'}

        {foreach from=$modbuttons item=b key=k}
            <input name="depo/depo_frm_btn{$k}" value="{$_TRANS[$b]}" onclick="return confirm('{$_TRANS['Confirm operation']}');" type="submit" class="button-green">
        {/foreach}
    </form>
</div>


{*include file='edit.tpl'
	title=valueIf($from_admin, 'Депозит')
	fields=[
		'dID'=>[],
		'duID'=>[],
		'dcID'=>[],
		'dState'=>
			[
				'X',
				'Статус',
				0,
				"<b>{$ststrs[$el.dState]}</b>"
			],
		'dCTS'=>
			[
				'X',
				'Создано'
			],
		'uLogin'=>
			[
				'X',
				'Пользователь',
				'skip'=>!$from_admin
			],
		'Bal'=>
			[
				'U',
				'balance/bal.tpl',
				'skip'=>!$from_admin
			],
		'cName'=>
			[
				'X',
				'Плат. система'
			],
		'dZD'=>
			[
				'X',
				'Сумма',
				0,
				_z($el.dZD, $el.dcID, 1)
			],
		'pName'=>
			[
				'X',
				'План',
				0,
				valueIf($from_admin, "<a href=\"{_link module='depo/admin/plan'}?id={$el.dpID}\" target=\"_blank\">{$el.pName}</a>")
			],
		'dN'=>
			[
				'X',
				'Начислений',
				0,
				"{$el.dNPer} из {$el.pNPer}"
			],
		'dLTS'=>
			[
				'X',
				'Последнее начисление'
			],
		'dNTS'=>
			[
				'X',
				'Следующее начисление'
			],
		'dCompnd'=>
			[
				'X',
				'Процент реинвеста <<капитализация>>',
				'skip'=>$chg
			],
		'Compnd'=>
			[
				'%',
				'Процент реинвеста <<капитализация>>',
				[
					'compnd_wrong'=>"неверное значение [$cmin..$cmax]"
				],
				'default'=>$el.dCompnd,
				'skip'=>!$chg
			],
		'dM'=>
			[
				'X',
				'Досрочное снятие',
				0,
				valueIf($el.pClComis >= 100, 'Невозможно',
					valueIf($el.dNPer >= $el.pMPer, "Возможно",
						"Осталось начислений: {$el.pMPer - $el.dNPer}")
				),
				'skip'=>($el.dState > 1)
			]
	]+$modform
	values=$el
	errors=[
		'oper_disabled'=>'операция запрещена'
	]
	btn_text=' '
	btns=$modbuttons
*}

{/strip}