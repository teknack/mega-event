<?php
/*
 * Allotting system
 * 
 * -> First player (for either faction) is assigned a completely random slot
 * 
 * 1) Generate 1st random number b/w 1-10 (inclusive) :: this is "dist"
 * 2) Generate 2nd random number b/w 0-7 (inclussive) :: this is "dir"
 * 
 * notes: 
 * Root(2) -> 1.4142
 */

//include "../db_access/db.php";

function allot()
{
	$dist = rand(1,10);
	$dir = rand(0,7);
	
	$conn = connect();
	$query="SELECT row_tail,col_tail FROM map_res WHERE faction=".$_SESSION["faction"].";";
	$op = mysqli_query($conn,$query);
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
	
	if ($res_row > 99 || $res_row < 0 || $res_col > 99 || $res_col < 0 || getSlot($res_row,$res_col)["occupied"] !== "0")
	{
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
?>
