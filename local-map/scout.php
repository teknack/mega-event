<?php

function scout($row,$col) //Used to check the details of the column at $row,$col
{
	connect();
	
	setTable("grid");
	
	$slot=getSlot($row,$col);
	
	return($slot);
}

?>
