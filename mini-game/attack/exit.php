<?php
	session_start();
	/*if(isset($_SESSION['playerLevel']) && isset($_SESSION['baseLevel']) && isset($_SESSION['troopType']))
	{
		//$goto="location:../../local-map/index.php";
		$goto="<script>window.location.href='http://teknack.in/bucket/mega-event/local-map/player.php';</script>";
	}
	else
	{
		$goto="<script>window.location.href='http://teknack.in/bucket/mega-event/tutorial/index.php';</script>";
	}*/)
	/*$difficulty = $_SESSION['baseLevel'];
	$playerlevel = $_SESSION['playerLevel'];
	$playerclass = $_SESSION['troopType'];*/
	include('redirect.php');
	global $difficulty , $playerlevel , $playerclass;

	$enemykilled = $_SESSION['destruction'];
	$currenthealth = $_SESSION['playerhealth'];

	if($currenthealth < 0){
		$currenthealth = 0;
	}
	
	if($difficulty == 1){
		$totalenemy = 16;
		$enemykilled = $enemykilled - 2;
	}
	elseif($difficulty == 2){
		$totalenemy = 16;
		$enemykilled = $enemykilled - 2;
	}
	elseif($difficulty == 3){
		$totalenemy = 9;
		$enemykilled = $enemykilled - 2;
	}
	elseif($difficulty == 4){
		$totalenemy = 9;
		$enemykilled = $enemykilled - 2;
	}
	elseif($difficulty == 5){
		$totalenemy = 10;
		$enemykilled = $enemykilled - 1;
	}
	elseif($difficulty == 6){
		$totalenemy = 10;
		$enemykilled = $enemykilled - 1;
	}
	elseif($difficulty == 7){
		$totalenemy = 7;
		$enemykilled = $enemykilled - 1;
	}
	else{
		$totalenemy = 7;
		$enemykilled = $enemykilled - 1;
	}
	$destruction = ($enemykilled / $totalenemy)*100;

	if($playerclass == 0){
		if($playerlevel == 1){
			$maxhealth = 150;
		}
		elseif($playerlevel == 2){
			$maxhealth = 200;
		}
		elseif($playerlevel == 3){
			$maxhealth = 250;
		}
		elseif($playerlevel == 4){
			$maxhealth = 300;
		}
		elseif($playerlevel == 5){
			$maxhealth = 350;
		}
		elseif($playerlevel == 6){
			$maxhealth = 400;
		}
		elseif($playerlevel == 7){
			$maxhealth = 450;
		}
		else{
			$maxhealth = 500;
		}
	}
	else{
		if($playerlevel == 1){
			$maxhealth = 100;
		}
		elseif($playerlevel == 2){
			$maxhealth = 100;
		}
		elseif($playerlevel == 3){
			$maxhealth = 100;
		}
		elseif($playerlevel == 4){
			$maxhealth = 100;
		}
		elseif($playerlevel == 5){
			$maxhealth = 120;
		}
		elseif($playerlevel == 6){
			$maxhealth = 120;
		}
		elseif($playerlevel == 7){
			$maxhealth = 120;
		}
		else{
			$maxhealth = 120;
		}
	}

	$currenthealthpercent = ($currenthealth / $maxhealth) * 100;

	echo 'Winning Status= '.$_SESSION['iswon'].'<br>';
	echo 'Player Health= '.$currenthealthpercent.'<br>';
	echo 'Destruction= '.$destruction.'<br>';
	
	if($_SESSION['iswon'] == 1){
		$_SESSION['result'] = true;
	}
	else{
		$_SESSION['result'] = false;
	}
	$_SESSION['ppercent'] = $currenthealthpercent;
	$_SESSION['bpercent'] = $destruction;
	$GLOBALS['attackdone'] = 1;
	//header($goto);
	//echo $goto;
	echo "<script>window.close();</script>";
?>
