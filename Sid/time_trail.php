<?php
	$servername="localhost";
	$username="root";
	$password="";
	$db="test";
	$conn=new mysqli($servername,$username,$password,$db);
	if($conn->connect_error)
	{
		die("connection error".$conn->connect_error);
	}
	$sql="SELECT current FROM time WHERE 1";
	//$sql="SELECT COUNT(current) FROM time WHERE 1";
	$x=$conn->query($sql);
	while($row=$x->fetch_assoc())
	{
		$old=$row['current'];
		print_r($row);
	}
	function timeDiff($start_date,$end_date="now"){
	    $time_diff = (new Datetime($start_date))->diff(new Datetime($end_date));
	    $time_diff_minute = $time_diff->days * 24 * 60;
	    $time_diff_minute += $time_diff->h * 60;
	    $time_diff_minute += $time_diff->i;
	    return $time_diff_minute;
	}
	$diff=timeDiff($old);
	echo $diff;
	
	$conn->close();
?>
