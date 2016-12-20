<?php
	//Destroying of sessions
	session_start();
	$_SESSION = array();
	session_destroy();
	
	header("Location: Login.php");
?>