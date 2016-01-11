<?php
set_time_limit(3600);
$servername="localhost";
$username="root";
$password="";
$db="mega";

$conn=new mysqli($servername,$username,$password,$db);
if($conn->connect_error)
{
	die("connection error".$conn->connect_error);
}
else
{
	#echo("connection established<br>");
}
for($i=0;$i<100;$i++)
{
	for($j=0;$j<100;$j++)
	{
		$q="INSERT INTO grid (row,col)
		VALUES ($i,$j)";
		$conn->query($q);
	}	
}
$conn->close();
?>