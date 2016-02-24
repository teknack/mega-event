<?php
session_start();
	if(isset($_SESSION['playerLevel']) && isset($_SESSION['baseLevel']) && isset($_SESSION['troopType']))
	{
		$playerlevel = $_SESSION['playerLevel'];
		$difficulty = $_SESSION['baseLevel'];
		$playerclass = $_SESSION['troopType'];
		$goto="<script>window.location.href='../../local-map/player.php';</script>";
		//try without absolute path
		if($_SESSION['attackdone'] != 1){ //or(isset($_SESSION['attackdone']))
			$_SESSION['attackdone'] = 0;
		}
	}
	else
	{
		$goto="<script>window.location.href='../../tutorial/index.php';</script>";
		$difficulty = 1;
		$playerlevel = 1;
		$playerclass = 1;
		if($_SESSION['attackdone'] != 1){ //or(isset($_SESSION['attackdone']))
			$_SESSION['attackdone'] = 0;
		}
	}
		unset($_SESSION['attackdone']);
		echo $goto;
?>