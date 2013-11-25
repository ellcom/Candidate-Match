<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession()){
	echo "Hello and Welcome <code style='background:#0099ff;padding:2px 5px;color:white;border-radius:2px'>".$_SESSION['username']."</code> you lucky logged in person - <a href='/logout.php'>Logout</a>";
} else{ 
	echo "Go Away Now!";
}


?>