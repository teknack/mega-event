<?php
	session_start();
	$_SESSION['iswon'] = $_GET['iswon'];
	$_SESSION['playerhealth'] = $_GET['playerhealth'];
	$_SESSION['destruction'] = $_GET['destruction'];
?>