<?php

if ($_cfg['Review_InBlock'] > 0)
{
	useLib('review');
	setPage('leftreview', reviewGetBlock());
}

?>