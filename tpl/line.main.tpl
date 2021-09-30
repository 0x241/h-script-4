{strip}
<div class="_menuPanel">
{$smenu=[
	100=>['depo/calc', $_TRANS['Calculator']],
	['faq', $_TRANS['FAQ']],
	['depo/top', $_TRANS['Top']],
	['review', $_TRANS['Reviews']]
]}
{if _uid()}
	{include file='menu.tpl'
		class='mainMenu'
		elements=[
			['cabinet', $_TRANS['Cabinet']],
			['balance', $_TRANS['Operations'], 'count'=>$count_opers],
			['depo', $_TRANS['Deposits']],
			['message', $_TRANS['Messages'], 'count'=>$count_msg, 'skip'=>!$_cfg.Msg_Mode],
			['balance/wallets', $_TRANS['Payment details']],
			['tickets', $_TRANS['Tickets'],'count'=>$count_tickets],
			['refsys', $_TRANS['Referral system'], 'skip'=>!$_cfg.Ref_Word]
		]+$smenu
	}
{else}
	{include file='menu.tpl'
		class='mainMenu'
		elements=[
		]+$smenu
	}
{/if}
</div>
<br>
{/strip}