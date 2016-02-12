<?php
	session_start();


	/* 
0-mud  -- +2 water
1-grass -- +1 food ; +1 water
2-sand -- +1 power ; -1 water
3-water -- no bonus
4-mountain -- +1 metal ; +1 wood
	
	*/
?>

<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">  
	<link type="text/css" rel="stylesheet" href="../../maincss/mainstyle.css"> 
	<link type="text/css" rel="stylesheet" href="../css/regen.css">
</head>
<body>
	<h2>Distribute Statistics</h2>


	<span id="max" style="display: none"></span><br>

	<?php
		$var = $_SESSION['regen_points'];
		echo '<script type="text/javascript">document.getElementById("max").value='.$var.' </script>';
		unset($_SESSION['regen_points']);
	?>

	<p>Max points: <span id="disp">0</span></p>

	Food:
	<div class="linear">
		<table>
			<tr>
				<td><button type="submit" name="food" onclick='down("fooddiv")'>Minus</button></td>
				<td><div id="fooddiv">0</div></td>
				<td><button type="submit" name="food" onclick='up("fooddiv")'>Plus</button> </td>
			</tr>
		</table>
	</div> <br>
	Water:
	<div class="linear">
		<table>
			<tr>
				<td><button type="submit" name="water" onclick='down("waterdiv")'>Minus</button></td>
				<td><div id="waterdiv">0</div></td>
				<td><button type="submit" name="water"  onclick='up("waterdiv")'>Plus</button> </td>
			</tr>
		</table>
	</div> <br>
	Power:
	<div class="linear">
		<table>
			<tr>
				<td><button type="submit" name="power" onclick='down("powerdiv")'>Minus</button></td>
				<td><div id="powerdiv">0</div></td>
				<td><button type="submit" name="power"  onclick='up("powerdiv")'>Plus</button> </td>
			</tr>
		</table>
	</div> <br>
	Metal:
	<div class="linear">
		<table>
			<tr>
				<td><button type="submit" name="metal" onclick='down("metaldiv")'>Minus</button></td>
				<td><div id="metaldiv">0</div></td>
				<td><button type="submit" name="metal"  onclick='up("metaldiv")'>Plus</button> </td>
			</tr>
		</table>
	</div> <br>
	Wood:
	<div class="linear">
		<table>
			<tr>
				<td><button type="submit" name="wood" onclick='down("wooddiv")'>Minus</button></td>
				<td><div id="wooddiv">0</div></td>
				<td><button type="submit" name="wood"  onclick='up("wooddiv")'>Plus</button> </td>
			</tr>
		</table>
	</div> <br>

	<button type="submit" name="resourceregen" onclick='sendback(<?php $_SESSION['bonus'] ?>)'>Confirm</button>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="./modify.js"></script>
</body>
</html>
