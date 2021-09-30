<?php

if ($_cfg['News_InBlock'] > 0)
{
	useLib('news');
	setPage('leftnews', newsGetBlock(), 1);
}

?>