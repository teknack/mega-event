<?php
	$servername="localhost";
	$username="root";
	$password="";
	$db="Mega";
	$player=1; // $_SESSION['tek_emailid'];
	$conn=new mysqli($servername,$username,$password,$db);
	if($conn->connect_error)
	{
		die("connection error".$conn->connect_error);
	}

	$sql="SELECT occupied,faction FROM grid";
	$res= $conn->query($sql);
	$output="[";                                                                             //stores JSON string format [{occupied:"value",faction:"value"},
	if($res->num_rows > 0)                                                                   //                           {occupied:"value",faction:"value"}]
	{
		while($row = $res->fetch_assoc())
		{
			$output=$output.'{"occupied":'.$row["occupied"].',"faction":'.$row["faction"].'},';
		}
		$output=$output.'{"player":'.$player."}]";
	}
	echo $output;
	$conn->close();
?>