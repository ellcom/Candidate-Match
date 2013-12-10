<?php 

require_once('config.php');
$smarty->display('votersHeader.tpl');
require_once('question.php');
$smarty->display('votersFooter.tpl');

?>