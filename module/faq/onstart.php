<?php

if ($_cfg['FAQ_InBlock'] > 0)
{
	useLib('faq');
	setPage('leftfaqs', faqGetBlock(), 1);
}

?>