<?php

include	"../db_access/db.php";
validate();
if ($_SESSION["claim"] !== true)
{
	echo("<script>parent.window.location='http://teknack.in';</script>");
}

$level = rand(0,4);
$target = "";

switch($level)
{
	case 0:
		$target = "indexcity.php":
	break;
	
	case 1:
		$target = "indexnature.php";
	break;
	
	case 2:
		$target = "indexdesert.php";
	break;
	
	case 3:
		$target = "indexgrass.php";
	break;
	
	case 4:
		$target = "indexsnow.php";
	break;
}

redirect("./tek1/".$target);

?>
