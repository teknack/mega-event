<?php
include "../db_access/db.php";

if (isset($_POST) && !empty($_POST))
{
	$tlc = $_SESSION["coord"];
	
	if (isset($_POST["world-map"]))
	{
		redirect("../world-map/canvas1.html");
	}
	else if (isset($_POST["up"]))
	{
		if ($tlc[0] == 0)
		{
			alert("Can't go any further up...");
			redirect("index.php");
		}
		else
		{
			$_SESSION["coordn"]="".($tlc[0]-1).",".$tlc[1]."";
			redirect("../transfer.php");
		}
	}
	else if (isset($_POST["down"]))
	{
		if ($tlc[0] == 99)
		{
			alert("Can't go any further down...");
			redirect("index.php");
		}
		else
		{
			$_SESSION["coordn"]="".($tlc[0]+1).",".$tlc[1]."";
			redirect("../transfer.php");
		}
	}
	else if (isset($_POST["left"]))
	{
		if ($tlc[1] == 0)
		{
			alert("Can't go any further left...");
			redirect("index.php");
		}
		else
		{
			$_SESSION["coordn"]="".($tlc[0]).",".($tlc[1]-1)."";
			redirect("../transfer.php");
		}
	}
	else if (isset($_POST["right"]))
	{
		if ($tlc[1] == 99)
		{
			alert("Can't go any further right...");
			redirect("index.php");
		}
		else
		{
			$_SESSION["coordn"]="".($tlc[0]).",".($tlc[1]+1)."";
			redirect("../transfer.php");
		}
	}
}
?>
