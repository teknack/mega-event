<?php
	session_start();
	$servername="localhost";
	$username="root";
	$password="swSlus7I63";
	$db="tk16_megaevent";
	$player=$_SESSION['tek_emailid'];
	$conn=new mysqli($servername,$username,$password,$db);
	if($conn->connect_error)
	{
		die("connection error".$conn->connect_error);
	}
	$sql="SELECT faction FROM player WHERE tek_emailid='$player';";
	$res=$conn->query($sql);
	$row=$res->fetch_assoc();
	$faction=$row['faction'];
	$sql="SELECT row,col,occupied,faction FROM grid";
	$res= $conn->query($sql);
	$troops=0;
	$output="[";                                        //stores JSON string format [{occupied:"value",faction:"value"},
	if($res->num_rows > 0)                              //                           {occupied:"value",faction:"value"}]
	{
		while($row = $res->fetch_assoc())
		{
			if($row['occupied']==0)
			{
				$r=$row['row'];
				$c=$row['col'];
				$sql="SELECT quantity FROM troops WHERE row=$r and col=$c and playerid='$player';";
				$res1=$conn->query($sql);
				$r1=$res1->fetch_assoc();
				if($r1['quantity']>0)
					$troops=1;
				else 
					$troops=0;
			}
			else
				$troops=0;
			$output=$output.'{"occupied":"'.$row["occupied"].'","faction":"'.$row["faction"].'","troops":"'.$troops.'"},';
		}
		$output=$output.'{"player":"'.$player.'","faction":"'.$faction.'"}]';
	}
	echo $output;
	$conn->close();
?>
