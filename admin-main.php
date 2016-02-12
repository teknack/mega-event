<?php
/*
 * Admin page!
 * Used by us to mess around and see stats
 */
include "./db_access/db.php";
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != true)
{
	header("location: http://teknack.in");
}

//gameUnset();

if (isset($_POST) && !empty($_POST))
{
	connect();

	if (!isset($_SESSION["in_game"]))
	{
		if (checkPlayerExists($_POST["username"],"player"))
		{
			alert("welcome back ".$_POST["username"]."");
			$_SESSION["tek_emailid"] = $_POST["username"];
			$_SESSION["faction"] = fetch($_SESSION["tek_emailid"],"faction");
			disconnect();
			$_SESSION["admin"] = null;
			header("location:landing/index.html");
		}
		else
		{
			//alert("Setting you up!");
			$_SESSION["tek_emailid"] = $_POST["username"];
			var_dump($_SESSION);
			//alert("hold");
			disconnect();
			$_SESSION["admin"] = null;
			redirect("./setup.php");
		}
	}
	else if (isset($_SESSION["in_game"]))
	{
		var_dump($_SESSION);
		alert("welcome back ".$_POST["username"]."");
		disconnect();
		$_SESSION["admin"] = null;
		redirect("./world-map/canvas1.html");
	}
}

?>
<html>

	<head>
		<title>ADMIN</title>
		<script>
			function getValues()
			{
				var xhttp;
				
				xhttp = new XMLHttpRequest();
				
				xhttp.onreadystatechange = function()
				{
					if (xhttp.readyState == 4 && xhttp.status == 200)
					{
						var values = xhttp.responseText.split(",");
						document.getElementById("wood").innerHTML = values[0];
						document.getElementById("food").innerHTML = values[1];
						document.getElementById("water").innerHTML = values[2];
						document.getElementById("power").innerHTML = values[3];
						document.getElementById("metal").innerHTML = values[4];
					}
				}
				
				xhttp.open("GET","getRes.php",true);
				xhttp.send();
			}
		</script>
	</head>

	<body>
		<form action="" method="POST">
			<input type="text" name="username" placeholder="tek_emailid"/>
			<button type="submit">Submit</button>
		</form>
		<hr>
		<?php var_dump($_SESSION);?>
		<hr>
		<h2>Market Exchange rates</h2>
		<table border=1>
			<tr>
				<th>wood</th>
				<th>food</th>
				<th>water</th>
				<th>power</th>
				<th>metal</th>
			</tr>
			<tr>
				<td id="wood">0</td>
				<td id="food">0</td>
				<td id="water">0</td>
				<td id="power">0</td>
				<td id="metal">0</td>
			</tr>
		</table>
		<button onclick="getValues()">refresh</button>
	</body>
</html>
