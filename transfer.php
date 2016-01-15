<?php

	include "./db.php" //To Edit
	$coord;
	function accept($c=""){
		global $coord;
		$coord = split("," , $c);
	}

	function slotAllocation(){
		global $coord;
		$locArray = array("p" => "", "s" => "", "n" => "", "b" => "", "r" => "", "f1" => "", "f2" => "");
		connect();
		

		for($i=$coord[0];$i<=($coord[0]+8);$i++) //Set to table row value
		{
			for($j=$coord[1];$j<=($coord[1]+8);$j++) // Set to table column value
			{
				$arr = getSlot($i,$j);
				if($arr["occupied"] !== "0")
				{
					$locArray["p"] = $locArray["p"]."-".$x.",".$y;
				}
				switch($arr["fortification"])
				{
					case "-1":
						$locArray["r"] = $locArray["r"]."-".$x.",".$y;
						break;
					case "-2":
						$locArray["s"] = $locArray["s"]."-".$x.",".$y;
						break;
					case "-9":
						$locArray["b"] = $locArray["b"]."-".$x.",".$y;
						break;
					case "0":
						$locArray["n"] = $locArray["n"]."-".$x.",".$y;
						break;
					default: 
						alert("Can't find what you want? You're in the wrong neighbourhood.");
				}
				if($arr["faction"] === "1"){
					$locArray["f1"] = $locArray["f1"]."-".$x.",".$y;
				}
				else if($arr["faction"] === "2"){
					$locArray["f2"] = $locArray["f2"]."-".$x.",".$y;
				}
			}
		}
		return($locArray);

	}
	
	if(isset($_POST) && !empty($_POST))
	{
		accept($_POST["tl"]);
		$_POST["locArray"] = slotAllocation();

		redirect("./local-map/index.php");
	}
?>
