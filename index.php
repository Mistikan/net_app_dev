<?php

$core = "/core/core.php";
$root = ".";
while (!is_file($root.$core)) {
	$root .= "/..";
}
include($root.$core);

?>