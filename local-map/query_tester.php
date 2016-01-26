<?php
	include "connect.php";
	$playerid=0;
	$quantity=1;
	$srcRow=0;
	$srcCol=8;
	$destRow=0;
	$destCol=10;
	$val;
	for($i=0;$i<100);$i++)
	{
		for($j=0;$j<100;$j++)
		{
			$val=$i.",".$j;
			$sql="UPDATE grid SET root=$val WHERE row=$i and col=$j";
			/*UPDATE grid SET troops=troops-$quantity WHERE row=$srcRow and col=$srcCol;"*/;//add query
			if($conn->query($sql)===false)
				echo "no go : ".$conn->error;
			else
				echo "good to go";
		}
	}

?>