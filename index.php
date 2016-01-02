<?php
/**
 * Setup
 * 
 * Data fetched from db is stored in locArray in below format
 * 
 * assoc_array locArray
 * - "p" = player owned -> ["p"] => "x,y-...."
 * - "s" = special -> ["s"] => "x,y-...."
 * - "n" = normal -> ["n"] => "x,y-...."
 * - "b" = base -> ["b"] => "x,y-...."
 * - "r" = resources -> ["r"] => "x,y-...."
 * 
 * Data is then parsed by "populateMapArray()" which inserts the character corresponding to the type of cell
 * at ("i","j") in the 2D array "mapArray"
 * 
 * array mapArray
 * A 2D array which represents the map, contains characters corresponding to type of cell present in each cell
 * 
**/

echo("this is a test<br>");

$mapArray = array();
$locArray = array("p"=>"4,4","s"=>"1,1-2,2","n"=>"2,3","b"=>"3,2");

function populateMapArray($locArray)
{
	global $mapArray;
	
	$str_p = $locArray["p"];
	$str_s = $locArray["s"];
	$str_n = $locArray["n"];
	$str_b = $locArray["b"];
	
	$p_loc = split("-",$str_p);
	//print_r($p_loc); 
	$s_loc = split("-",$str_s);
	$n_loc = split("-",$str_n);
	$b_loc = split("-",$str_b);
	
	for ($i = 0; $i <= 8; $i++)
	{
		for($j = 0; $j <= 8; $j++)
		{
			$mapArray[$i][$j] = "--";
		}
	}
	
	foreach ($p_loc as $i)
	{
		$loc = split(",",$i);
		$mapArray[$loc[0]][$loc[1]] = "p";
	}
	
	foreach ($s_loc as $i)
	{
		$loc = split(",",$i);
		$mapArray[$loc[0]][$loc[1]] = "s";
	}
	
	foreach ($n_loc as $i)
	{
		$loc = split(",",$i);
		$mapArray[$loc[0]][$loc[1]] = "n";
	}
	
	foreach ($b_loc as $i)
	{
		$loc = split(",",$i);
		$mapArray[$loc[0]][$loc[1]] = "b";
	}
}

function genMatrix()
{
	global $mapArray;
	echo("<table border=1>");
	echo("<tr>");
	echo("<td>--</td>");
	for ($i = 0; $i <= 8; $i++)
	{
		echo("<td><b>".$i."</b></td>");
	}
	echo("</tr>");
	for ($i = 0; $i <= 8; $i++)
	{
		echo("<tr>");
		echo("<td><b>".$i."</b></td>");
		for ($j = 0; $j<= 8; $j++)
		{ 	
			echo("<td>");
			echo($mapArray[$i][$j]);
			echo("</td>");
		}
		echo("</tr>");
	}
	echo("</table>");
}

function fake_main()
{
	global $locArray;
	populateMapArray($locArray);
}
?>

<html>

<head>
	<title>Test page</title>
</head>

<body>
	<?php fake_main(); genMatrix() ?>
</body>

</html>
