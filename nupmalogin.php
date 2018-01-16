<?php

require_once('nuconfig.php');

$page = 'nuphpmyadmin/index.php?server=1&db='.$nuConfigDBName;
header("Location: $page")
?>

