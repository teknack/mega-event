<?php
	include 'connect.php';
	$sql="SELECT current FROM time WHERE 1";
	$x=$conn->query($sql);
	while($row=$x->fetch_assoc())
	{
		$old=$row['current'];
	}
	$sql="SELECT TIMESTAMPDIFF(MINUTE,'$old','NOW()')";
	$y=$conn->query($sql);
	if($res->num_rows>0)
	{
		while($row =$y->fetch_assoc());
		{
			$result=$row['TIMESTAMPDIFF'];
		}
	}
	echo $result;
	$conn->close();
?>