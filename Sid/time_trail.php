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
	$x=$conn->query($sql);
	while($row=$x->fetch_assoc())
	{
		$old=$row['current'];
		print_r($row);
	}
	//$sql="SELECT TIMESTAMPDIFF(MINUTE,'$old',NOW())";
	$sql="SELECT COUNT(current) FROM time WHERE 1";
	$y=$conn->query($sql);
	if($y===false)
	{
		echo "<br>".$conn->error."<br>";
	}
	else
	{
		if($y->num_rows>0)
		{
			while($row = $y->fetch_assoc());
			{
				print_r($row);
			}
		}
	}	
	//echo $result;
	$conn->close();
?>