<?php
/*
 * Allotting system
 * 
 * -> First player (for either faction) is assigned a completely random slot
 * 
 * 1) Generate 1st random number b/w 1-10 (inclusive) :: this is "dist"
 * 2) Generate 2nd random number b/w 0-7 (inclussive) :: this is "dir"
 */

include "../db_access/db.php";

function allot()
{
	$dist = rand(1,10);
	$dir = rand(0,7);
	
	connect();
	setTable("map_res");
	
	$query="SELECT row_tail,col_tail FROM map_res WHERE faction=".$_SESSION["faction"].";";
	
}


?>
