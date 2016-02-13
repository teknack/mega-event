<?php
	session_start();
	$servername="localhost";
	$username="root";
	$password="swSlus7I63";
	$db="tk16_megaevent";
	$conn=new mysqli($servername,$username,$password,$db);
	if($conn->connect_error)
	{
		die("connection error".$conn->connect_error);
	}
	$sql="SELECT tek_emailid,total,faction FROM player ORDER BY total DESC;";
	$res=$conn->query($sql);
	$row=$res->fetch_assoc();
	$faction=$row['faction'];
	$res= $conn->query($sql);
	$troops=0;
	$output="[";                                        //stores JSON string format [{occupied:"value",faction:"value"},
	if($res->num_rows > 0)                              //                           {occupied:"value",faction:"value"}]
	{
		$i=0;
		while($row = $res->fetch_assoc() and $i<5)
		{
			$output=$output.'{"user":"'.$row["tek_emailid"].'","faction":"'.$row["faction"].'","tiles":"'.$row['total'].'"},';
			$i++;
		}
		$output.="{}]";
	}
	echo $output;
	$conn->close();
?>
