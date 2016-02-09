<?php
/*
 * Setup.php
 * Used for newcomers only.
 * i.e. if the player doesn't exist in the "player" table, he/she isnt in the game... yet >:D
 *
 * Initial Regen values and starting values are set here
 * Faction is chosen here
 */

include "./db_access/db.php";
include "./newbies/allot.php";
//alert($_SESSION["tek_emailid"]);
//var_dump($_SESSION);
connect();
setTable("player");
if (checkPlayerExists($_SESSION["tek_emailid"],"player")) //does a check to see if player has aready picked a faction
{
	$faction = fetch($_SESSION["tek_emailid"],"faction");
	if ($faction == "1" || $faction == "2")
	{
		alert("You already exist in the game, go back and play :P");
		redirect("./index.php");
	}
}
disconnect();

if (isset($_POST) && !empty($_POST)) //creates player and sets faction before redirecting to index.php
{
	connect();
	setTable("player");

	if(isset($_POST["faction1"]))
	{
		alert("you have picked faction 1");
		insert("tek_emailid,faction,collect","'".$_SESSION["tek_emailid"]."',1,".time()); //set current time as "collect" value in db
		$_SESSION["collect_time"] = time();
		$_SESSION["faction"] = "1";

		while (true)
		{
			$origin=allot();
			if ($origin != false)
			{
				break;
			}
		}
		setTable("grid");
		update("occupied","'".$_SESSION["tek_emailid"]."'","row=".$origin["row"]." AND col=".$origin["col"]."");
		update("faction","1","row=".$origin["row"]." AND col=".$origin["col"]."");
		update("fortification","-9","row=".$origin["row"]." AND col=".$origin["col"]."");
		if (!checkPlayerExists($_SESSION["tek_emailid"],"research")) //includes player in reseach table
		{
			setTable("research");
			insert("playerid","'".$_SESSION["tek_emailid"]."'");
		}
		//alert("hold2");
		disconnect();
		$_SESSION["origin"]=null;
		redirect("world-map/canvas1.html");
	}
	else if (isset($_POST["faction2"])) //same as above
	{
		alert("you have picked faction 2");
		insert("tek_emailid,faction,collect","'".$_SESSION["tek_emailid"]."',2,".time());
		$_SESSION["collect_time"] = time();
		$_SESSION["faction"] = "2";

		while (true)
		{
			$origin=allot();
			if ($origin != false)
			{
				break;
			}
		}
		setTable("grid");
		update("occupied","'".$_SESSION["tek_emailid"]."'","row=".$origin["row"]." AND col=".$origin["col"]."");
		update("faction","2","row=".$origin["row"]." AND col=".$origin["col"]."");
		update("fortification","-9","row=".$origin["row"]." AND col=".$origin["col"]."");

		if (!checkPlayerExists($_SESSION["tek_emailid"],"research"))
		{
			setTable("research");
			insert("playerid","'".$_SESSION["tek_emailid"]."'");
		}
		//alert("hold");
		disconnect();
		redirect("world-map/canvas1.html");
	}
	else
	{
		alert("lolwut");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Factions</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width. initial scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./factionselect/faction.css">

</head>
<body>

    <nav class="navbar navbar-inverse">
		<div class="container-fluid">

			<!-- Logo -->
			<div class="navbar-header">
				<a href="#" class="navbar-brand">Default</a>
			</div>


			<!-- Menu items -->
			<div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">First</a></li>
					<li><a href="#">Second</a></li>
					<li><a href="#">Third</a></li>
				</ul>

				<!-- Menu right items -->
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Example</a></li>
					<li><p class="navbar-text">Sample nonclick text</p></li>
				</ul>
			</div>
		</div>
	</nav>


	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<button class="btn btn-block btn-button-hollow btn-lg collapsible-button-left">
					<div class="page-header"><h1>Guthix</h1></div>
				  	<div class="panel-body">
				  		<p>Decription of Faction 1</p>
				  	</div>
			  	</button>
			</div>
			<div class="col-md-6">
				<button class="btn btn-block btn-button-hollow btn-lg collapsible-button-right">
					<div class="page-header"><h1>Zaros</h1></div>
			  		<div class="panel-body">
			  			<p>Description of Faction 2</p>
			  		</div>
				</button>
			</div>
		</div>
	</div>




	<div class="description collapsible collapsible-left">
		<h3>Perks</h3>
		<p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
		<h3>Cons</h3>
		<p>I need texxt</p>

		<form action="" method="POST">
				<button type="submit" name="faction1">Faction 1</button>
			</form>
	</div>

	<!-- JQuery the height in -->
	<div class="description collapsible collapsible-right">
		<h3>Perks</h3>
		<p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
		<h3>Cons</h3>
		<p>I need texxt</p>

		<form action="" method="POST">
				<button type="submit" name="faction1">Faction 1</button>
			</form>

	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript">
	$(document).ready(function() {

	    var collapsibleLeft = $('.collapsible-left'); //collapsible element
	        var buttonEl =  $('.collapsible-button-right'); //button

	        collapsibleLeft.css({'margin-top': "-1000px"}); //on page load we'll move and hide part of elements

	    $(buttonEl).click(function()
	    {
	        var curwidth = $(collapsibleLeft).offset(); //get offset value of the parent element
	        if(curwidth.top>=0) //compare margin-left value
	        {
	            //animate margin-left value to -490px
	            $(collapsibleLeft).animate({marginTop: "-1000px"} );

	        }else{
	            //animate margin-left value 0px
	            $(collapsibleLeft).animate({marginTop: "0"});
	        }
	    });

	    var collapsibleRight = $('.collapsible-right'); //collapsible element
	        var buttonEl =  $(".collapsible-button-left"); //button inside element
	        collapsibleRight.css({'margin-top': "-1000px"}); //on page load we'll move and hide part of elements

	    $(buttonEl).click(function()
	    {
	        var curwidth = $(collapsibleRight).offset(); //get offset value of the parent element
	        if(curwidth.top>=0) //compare margin-left value
	        {
	            //animate margin-left value to -490px
	            $(collapsibleRight).animate({marginTop: "-1000px"} );
	        }else{
	            //animate margin-left value 0px
	            $(collapsibleRight).animate({marginTop: "0"});	        }
	    });
	});
	</script>

</body>
</html>
