<?php
	include "./db_access/db.php";
	
	if (isset($_POST) && !empty($_POST))
	{
		$username = testVar($_POST["username"]);
		$password = testVar($_POST["password"]);
		
		if ($username === "Nischal" || $username === "Jacques" || $username === "Siddhant")
		{
			if ($password === "ThreeGandus")
			{
				alert("yo, ".$username);
				$_SESSION["admin"] = true;
				redirect("./admin-main.php");
			}
		} 
	}
?>
<html>
	<head>
		<title>:: MEGA ADMIN :: Login</title>
	</head>
	
	<body>
		<center><h1>:: MEGA ADMIN LOGIN ::</h1></center>
			<center>
				<form action="" method="POST">
					<input type="text" name="username" placeholder="Username"/>
					<input type="password" name="password" placeholder="Password"/>
					<button type="submit">Login</button>
				</form>
			</center>
	</body>
</html>
