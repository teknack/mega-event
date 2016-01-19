<?php
session_start();

//validate(); //VALIDATION CHECK

$dbusername="root";
$dbpassword="";
$dbname="Mega";
$dbtable="grid";
$dbconn="";
$dbservername="localhost";

$id="";

function connect()
{
	global $dbusername,$dbpassword,$dbconn,$dbname,$dbservername;
	
	$dbconn = mysqli_connect($dbservername,$dbusername,$dbpassword,$dbname);
	
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
}

function setTable($table)
{
	global $dbtable;
	
	$dbtable = $table;
}

function insert($columns,$values)
{
	global $dbtable,$dbconn;
	
	$query = "INSERT INTO ".$dbtable." (".$columns.") VALUES (".$values.");";
	
	$op = mysqli_query($dbconn,$query);
	
	if (!$op || $op === false)
	{
		echo(mysqli_error($dbconn)."<br>");
		var_dump($query);
		echo("<br>");
		var_dump($op);
		echo("<br>");
		return(false);
	}
	
	mysqli_commit($dbconn);
	return(true);	
}

function update($columns,$values,$condition)
{
	global $dbtable,$dbconn;
	
	$query = "UPDATE ".$dbtable." SET ".$columns."=".$values." WHERE ".$condition.";";
	
	$op = mysqli_query($dbconn,$query);
	
	if (!$op || $op === false)
	{
		echo(mysqli_error($dbconn)."<br>");
		var_dump($query);
		echo("<br>");
		var_dump($op);
		echo("<br>");
		return(false);
	}
	
	mysqli_commit($dbconn);
	return(true);
}

function disconnect()
{
	global $dbconn;
	
	mysqli_close($dbconn);
}

function checkLogin($inid="",$password="")
{
	global $dbconn, $id;
	
	$query="SELECT * FROM Users WHERE id='".$inid."' && password='".$password."';"; 
	
	$res = mysqli_query($dbconn,$query);
	//var_dump($res);
		if(mysqli_num_rows($res) === 1)
		{
			$id=$inid;
			return(true);
		}
		else
		{
			return(false);
		}
}


function getID()
{
	global $id;
	return($id);
}

function getSlot($x,$y)
{
	global $dbconn;
	
	$query = "SELECT occupied,fortification,troops,faction FROM grid WHERE row=".$x." AND col=".$y.";";
	$res = mysqli_query($dbconn,$query);
	//alert($res);
	$res = mysqli_fetch_assoc($res);
	return($res);
}

function fetch($col="")
{
	global $dbconn, $email;
	
	$query="SELECT ".$col." FROM Users WHERE email='".$email."';";
	$res = mysqli_query($dbconn,$query);
	$res = mysqli_fetch_assoc($res);
	return($res[$col]);
}

function redirect($url="index.php")
{
	echo("<script>window.location='".$url."'</script>");
}

function alert($msg="")
{
	echo("<script>alert('".$msg."')</script>");
}

function testVar($input="")
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);

	return ($input);
}

function validate()
{
	if (!isset($_SESSION["tek_emailid"]))
	{
		alert("Well, someone is feeling adventurous... Go log in and come back :P");
		redirect("www.teknack.in");
	} 
}
?>
