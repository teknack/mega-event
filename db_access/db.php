<?php
/*
 * Function list: (code is too much, needs this now XD)
 * - connect()
 * --> Establishes connection to db, sets the dbconn variable
 * 
 * - disconnect()
 * --> Closes the connection used in dbconn variable 
 * 
 * - setTable(<table_name>)
 * --> Sets the dbtable variable to <table_name>
 * 
 * - checkPlayerExists($player,$table)
 * --> Checks if $player exists in the $table table
 * 
 * - insert($columns,$values)
 * --> Inserts values as per the usual SQL insertion syntax. 
 * --> $columns should be a string consisting of the list of columns to be inserted into.
 * --> $values should be a string consisting of the corresponding values to be inserted.
 * 
 * - update($column,$value,$condition)
 * --> updates a single row which satisfies the $condition
 * --> $columns should be a string consisting of the list of columns to be inserted into.
 * --> $values should be a string consisting of the corresponding values to be inserted. 
 * 
 * - checkLogin($inid="",$password="") -----> ignore this fnction for teknack
 * --> checks if the given $inid and $password combination are present in the... 
 */
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

function checkPlayerExists($player,$table)
{
	global $dbconn;
	
	$query = "SELECT tek_emailid FROM ".$table." WHERE tek_emailid='".$player."';";
	//var_dump($query);
	$res = mysqli_query($dbconn,$query);
	//var_dump($res);
	if (mysqli_num_rows($res) === 1)
	{
		return(True);
	}
	else
	{
		return(False);
	}
}

function insert($columns,$values)
{
	global $dbtable,$dbconn;
	
	$query = "INSERT INTO ".$dbtable." (".$columns.") VALUES (".$values.");";
	//var_dump($query);echo("<br>");
	$op = mysqli_query($dbconn,$query);
	//var_dump($op);echo("<br>");
	if (!$op || $op === false)
	{
		echo(mysqli_error($dbconn)."<br>");
		//var_dump($query);
		echo("<br>");
		//var_dump($op);
		echo("<br>");
		return(false);
	}
	
	mysqli_commit($dbconn);
	return(true);	
}

function update($column,$value,$condition)
{
	global $dbtable,$dbconn;
	
	$query = "UPDATE ".$dbtable." SET ".$column."=".$value." WHERE ".$condition.";";
	
	$op = mysqli_query($dbconn,$query);
	
	if (!$op || $op === false)
	{
		echo(mysqli_error($dbconn)."<br>");
		//var_dump($query);
		echo("<br>");
		var_dump($op);
		//echo("<br>");
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
	//var_dump($x);	
	$query = "SELECT occupied,fortification,troops,faction FROM grid WHERE row=".$x." AND col=".$y.";";
	$res = mysqli_query($dbconn,$query);
	//alert($res);
	$res = mysqli_fetch_assoc($res);
	return($res);
}
function getSlotTroops($x,$y)
{
	global $dbconn;
	$playerid=$_SESSION['tek_emailid'];
	$query="SELECT quantity FROM troops WHERE row=$x and col=$y and playerid=$playerid";
	$res = mysqli_query($dbconn,$query);
	//alert($res);
	if(mysqli_num_rows($res)>0)
	{
		$res = mysqli_fetch_assoc($res);
		$res=$res['quantity'];
		return $res;
	}	
	else
	{
		$res = mysqli_num_rows($res);
		return $res;
	}
}
function fetch($player,$col="")
{
	global $dbconn,$dbtable;
	
	$query="SELECT ".$col." FROM ".$dbtable." WHERE tek_emailid='".$player."';";
	var_dump($query);
	$res = mysqli_query($dbconn,$query);
	$res = mysqli_fetch_assoc($res);
	return($res[$col]);
}

function fetchAll($player)
{
	global $dbconn, $dbtable;
	
	$query = "SELECT * FROM ".$dbtable." WHERE tek_emailid='".$player."';";
	
	$res = mysqli_query($dbconn,$query);
	$res = mysqli_fetch_assoc($res);
	return($res);
}

function redirect($url="index.php")
{
	echo("<script>window.location='".$url."'</script>");
}

function alert($msg="")
{
	var_dump(mysqli_fetch_assoc($msg));
	
	echo("<script>alert('".$msg."')</script>");
}

function consoleLog($msg="")
{
	echo("<script>console.log('".$msg."');</script>");
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

function gameUnset()
{
	$_SESSION["coord"] = null;
	$_SESSION["locArray"] = null;
	$_SESSION["collect_time"] = null;
}
?>
