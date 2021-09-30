{strip}
{assign 
	var='info_msg'
	value=
		[
			'Completed'		=>$_TRANS['*Completed'],
			'Saved'			=>$_TRANS['Saved'],
			'Canceled'		=>$_TRANS['*Canceled'],
			'Added'			=>$_TRANS['*Added'],
			'Deleted'		=>$_TRANS['Deleted'],
			'LogIn'			=>$_TRANS['LogIn'],
			'LogOut'		=>$_TRANS['LogOut'],
			'*NoSelected'	=>$_TRANS['*NoSelected'],
			'*CantComplete'	=>$_TRANS['*CantComplete'],
			'*AlreadyUsed'	=>$_TRANS['*AlreadyUsed'],
			'*Error'		=>$_TRANS['*Error'],
			'*ErrorCode'	=>$_TRANS['*ErrorCode'],
			'*NoPage'		=>$_TRANS['*NoPage'],
			'*Denied'		=>$_TRANS['*Denied']
		] 
	scope='global'
}
{/strip}