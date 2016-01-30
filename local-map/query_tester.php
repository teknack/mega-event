<?php
	include "connect.php";
	$playerid=0;
	$quantity=1;
	$srcRow=0;
	$srcCol=8;
	$destRow=1;
	$destCol=9;
	$val;
	for($i=0;$i<50;$i++)
	{
		echo rand(0,100)."<br>";
	}
	/*$sql="SELECT row,col FROM grid WHERE (row=$destRow-1 or row=$destRow or row=$destRow+1) 
		           and (col=$destCol-1 or col=$destCol or col=$destCol+1) and fortification>0;";
	$res=$conn->query($sql);
	$neighbours=array();
	while($r=$res->fetch_assoc())
    {
		echo "<br>row: ".$r['row']."<br>col: ".$r['col']."<br>troops: ".$r['SUM(troops)'];    	
	}*/

?>