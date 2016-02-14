<?php
	session_start();
	if(isset($_SESSION['playerLevel']) && isset($_SESSION['baseLevel']) && isset($_SESSION['troopType']))
	{
		$playerlevel = $_SESSION['playerLevel'];
		$difficulty = $_SESSION['baseLevel'];
		$playerclass = $_SESSION['troopType'];
		$goto="<script>window.location.href='http://teknack.in/bucket/mega-event/local-map/player.php';</script>";
		//try without absolute path
		if($GLOBALS['attackdone'] != 1){ //or(isset($GLOBALS['attackdone']))
			$GLOBALS['attackdone'] = 0;
		}
	}
	else
	{
		$goto="<script>window.location.href='http://teknack.in/bucket/mega-event/tutorial/index.php';</script>";
		$difficulty = 1;
		$playerlevel = 1;
		$playerclass = 1;
		if($GLOBALS['attackdone'] != 1){ //or(isset($GLOBALS['attackdone']))
			$GLOBALS['attackdone'] = 0;
		}
	}
	if($GLOBALS['attackdone'] == 1){
		unset($GLOBALS['attackdone']);
		echo $goto;
	}
	//the page will reload after every 5 secs
	//if attackdone is true it will close the mini-game tab and redirect to localmap or tutorial
	//so game will run in iframe only
?>
<html class="full">
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Mega Event</title>
        <link href="style.css" rel="stylesheet">
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript">
        	function refresh(){
        		setInterval(function(){
        			window.location.reload(true);
        		}, 5000);
        	}
        </script>
	</head>
	<body onload="refresh();">
		<div style="width:80%; margin:0 auto;">
			<div class="objective">
				<img src="website_images/objective.png" width="45%" height="15%" style="margin-top:4%; margin-left:28%;"></img>
				<?php if($difficulty == 1 || $difficulty == 2) { ?>
					<img src="website_images/obj1.png" width="45%" height="15%" style="margin-top:1%; margin-left:28%;"></img>
				<?php } else if($difficulty == 3 || $difficulty == 4) { ?>
					<img src="website_images/obj2.png" width="45%" height="15%" style="margin-top:1%; margin-left:28%;"></img>
				<?php } else if($difficulty == 5 || $difficulty == 6) { ?>
					<img src="website_images/obj3.png" width="45%" height="15%" style="margin-top:1%; margin-left:28%;"></img>
				<?php } else { ?>
					<img src="website_images/obj4.png" width="45%" height="17%" style="margin-top:1%; margin-left:28%;"></img>
				<?php } ?>
			</div>
			<div class="enterbutton">
				<a href="#"><img src="website_images/enter-button.png"></img></a>
			</div>
			<div class="instruction">
				<?php if($difficulty <= 4) { ?>
					<img src="website_images/attackinstructions.png" width="32%" height="26%" style="margin-top:4%; margin-left:15%;"></img>
					<img src="website_images/moveinstructions.png" width="32%" height="25%" style="margin-top:4%; margin-left:5%;"></img>
				<?php } else { ?>
					<img src="website_images/moveinstructions2.png" width="32%" height="26%" style="margin-top:4%; margin-left:18%;"></img>
					<img src="website_images/attackinstructions2.png" width="32%" height="25%" style="margin-top:4%; margin-left:5%;"></img>
				<?php } ?>
			</div>
		</div>
		<script type="text/javascript">
			var plevel = <?php echo $playerlevel; ?>;
			var blevel = <?php echo $difficulty; ?>;
			var pclass = <?php echo $playerclass; ?>;
			var formdata = "index.html?def="+blevel+"&plvl="+plevel+"&pcls="+pclass;
			//alert(formdata);
			$('a[href="#"]').click(function(){
  				//window.location.href = formdata;
  				var win = window.open(formdata, '_blank');
				if(win){
				    //Browser has allowed it to be opened
				    win.focus();
				}else{
				    //Broswer has blocked it
				    alert('Please allow popups for this site');
				}
			});
		</script>
	</body>
</html>