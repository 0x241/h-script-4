<?php

$t = time() + $_GS['TZ'];
setPage('clock_H', gmdate('H', $t));
setPage('clock_M', gmdate('i', $t));
setPage('clock_S', gmdate('s', $t));

?>