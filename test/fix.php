<?php
include "../db_access/db.php";

function allot($faction)
{
	$dist = rand(1,10);
	$dir = rand(0,7);
	
	$conn = connect();
	$query="SELECT row_tail,col_tail FROM map_res WHERE faction=".$faction.";";
	$op = mysqli_query($conn,$query);
	if (mysqli_num_rows($op) != 1)
	{
		$x = "";
		$y = "";
		
		if ($faction === "1")
		{
			$x = 25;
			$y = 50;
		}
		else
		{
			$x = 75;
			$y = 50;
		}
		
		$query="INSERT INTO map_res (faction,row_tail,col_tail) VALUES (".$faction.",".$x.",".$y.");";
		$op=mysqli_query($conn,$query);
		//alert($query);
		$res["row"] = $x;
		$res["col"] = $y;
		//alert(var_dump($res));
		return($res);
	}
	$op = mysqli_fetch_assoc($op);
	
	switch($dir)
	{
		case 0: //up
			$res_row = $op["row_tail"] - $dist;
			$res_col = $op["col_tail"];
		break;
		
		case 1: //up-right
			$res_row = $op["row_tail"] - floor($dist/1.4142);
			$res_col = $op["col_tail"] + floor($dist/1.4142);
		break;
		
		case 2: //right
			$res_row = $op["row_tail"];
			$res_col = $op["col_tail"] + floor($dist/1.4142);
		break;
		
		case 3: //down-right
			$res_row = $op["row_tail"] + floor($dist/1.4142);
			$res_col = $op["col_tail"] + floor($dist/1.4142);
		break;
		
		case 4: //down
			$res_row = $op["row_tail"] + $dist;
			$res_col = $op["col_tail"];
		break;
		
		case 5: //down-left
			$res_row = $op["row_tail"] + floor($dist/1.4142);
			$res_col = $op["col_tail"] - floor($dist/1.4142);
		break;
		
		case 6: //left
			$res_row = $op["row_tail"];
			$res_col = $op["col_tail"] - floor($dist/1.4142);
		break;
		
		case 7: //up-left
			
			$res_row = $op["row_tail"] + floor($dist/1.4142);
			$res_col = $op["col_tail"] - floor($dist/1.4142);
		break;
	}
	
	$res=array();
	
	if ($res_row > 99 || $res_row < 0 || $res_col > 99 || $res_col < 0 || getSlot($res_row,$res_col)["occupied"] !== "0" || getSlot($res_row,$res_col)["special"] === "3" || getSlot($res_row,$res_col)["special"] === "4")
	{
		//alert("$res_row , $res_col");
		return(false);
	}
	else
	{
		$res["row"] = $res_row;
		$res["col"] = $res_col;
		//alert(var_dump($res));
		return($res);
	}
	
	//return($res);
}

setTable("player");
$conn = connect();

$query = "SELECT * FROM player";
$res = mysqli_query($conn,$query);

while($player = mysqli_fetch_assoc($res)) //cycles through all players
{
	$tek_emailid = $player["tek_emailid"];
	
	setTable("grid");
	
	while (true)
	{
		$origin=allot($player["faction"]);
		if ($origin != false)
		{
			break;
		}
	}
	
	echo($tek_emailid." -> (".$origin["row"].",".$origin["col"].")<br>");
	
	setTable("grid");
	
	update("occupied","'".$tek_emailid."'","row = ".$origin["row"]." AND col = ".$origin["col"]."");
	update("fortification","-9","row = ".$origin["row"]." AND col = ".$origin["col"]."");
}

mysqli_close($conn);
?>
