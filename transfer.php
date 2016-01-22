<?php
//session_start(); -> db.php already has a session_start()

	include "./db_access/db.php"; //To Edit
	$coords="";
	function accept($c="")
	{
		global $coords;
		
		$coords = split("," , $c);
		$_SESSION["coord"] = $coords;
	}

	function slotAllocation(){
		global $coords;
		$locArray = array("p" => "", "s" => "", "n" => "", "b" => "", "r" => "", "f1" => "", "f2" => "");
		connect();
		

		for($i=$coords[0];$i<=($coords[0]+8);$i++) //Set to table row value
		{
			for($j=$coords[1];$j<=($coords[1]+8);$j++) // Set to table column value
			{
				$arr = getSlot($i,$j);
				if($arr["occupied"] !== "0")
				{
					$locArray["p"] = $locArray["p"]."-".$i.",".$j;
					if($arr["faction"] === "1")
					{
						$locArray["f1"] = $locArray["f1"]."-".$i.",".$j;
					}
					else if($arr["faction"] === "2")
					{
						$locArray["f2"] = $locArray["f2"]."-".$i.",".$j;
					}
				}
				else
				{
					switch($arr["fortification"])
					{
						case "-1":
							$locArray["r"] = $locArray["r"]."-".$i.",".$j;
							break;
						case "-2":
							$locArray["s"] = $locArray["s"]."-".$i.",".$j;
							break;
						case "-9":
							$locArray["b"] = $locArray["b"]."-".$i.",".$j;
							break;
						case "0":
							$locArray["n"] = $locArray["n"]."-".$i.",".$j;
							break;
						default: 
							alert("Can't find what you want? You're in the wrong neighbourhood.");
					}
				}
			}
		}
		return($locArray);

	}
	
	if(isset($_REQUEST) && !empty($_REQUEST))
	{
		$ordinates = $_REQUEST["coord"];
		accept($ordinates);
		$_SESSION["locArray"] = slotAllocation();
	
		redirect("./local-map/index.php");
	}
	else if (isset($_SESSION["coordn"]) && !empty($_SESSION["coordn"]))
	{
		$ordinates = $_SESSION["coordn"];
		accept($ordinates);
		$_SESSION["locArray"] = slotAllocation();
		var_dump($_SESSION["locArray"]);
		redirect("./local-map/index.php");
	}
	else
	{
		echo('<script>alert("hello jello");</script>');
	}
?>
