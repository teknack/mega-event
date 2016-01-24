<?php
function getActions($row,$col)  //AJAX FUNCTION!!! **maybe will add action cost with actions**
{
	$sql="SELECT * FROM grid WHERE row=$row and col=$col;";
	$res=$conn->query($sql);
	$sql1="SELECT playerid FROM troops WHERE row=$row and col=$col and playerid=$playerid;";
	$res1=$conn->query($sql1);
	$fortification=0;
	$occupant="0";
	$faction="1";
	$output="[";
	if($res->num_rows>0)
	{
		while($row = $res->fetch_assoc())
		{
			if($row['faction']!=$faction)  //enemy faction
			{
				$output=$output.'{"action":"scout"},{"action":"attack"}]';
			}
			else if($row['faction']==$faction) //allied faction
			{
				if($row['occupant']==$playerid) //player occupied 
				{
					$output=$output.'{"action":"fortify"},{"action":"select troops"}]';		
				}
				else
				{
					if($res1->num_rows>0) //player troops stationed
					{
						$output=$output.'{"action":"settle"},{"action":"select troops"}]'		
					}
					else
						$output=$output.'{"action":"scout"}]';
				}
			}
		}
	}
	echo $output;
}
$c=$_REQUEST['coord']
$c=split(",", $c);
$row=$c[0];
$col=$c[1];
getActions($row,$col);
?>