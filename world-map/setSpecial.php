<?php 
set_time_limit(1000);
$servername="localhost";
$username="root";
$password="";
$db="Mega";

$conn=new mysqli($servername,$username,$password,$db);
if($conn->connect_error)
{
	die("connection error".$conn->connect_error);
}
else
{
}
$special=4;  // SET YOUR SLOT SPECIAL HERE
$trow=$_POST['row'];
$tcol=$_POST['col'];
$size=$_POST['size'];
for($i=0;$i<$size;$i++)
{
	for($j=0;$j<$size;$j++)
	{
		$row=$trow+$i;
		$col=$tcol+$j;
		$sql="UPDATE grid SET special=$special WHERE row=$row and col=$col;";
		if(!$conn->query($sql))
		{
			echo "error:".$conn->error;
			var_dump($sql);
		}
		else
			echo "added!  $row,$col";
	}
}

?>	