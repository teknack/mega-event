<?php
function dispArr($arr)
{
	for($j=0;$j<count($arr);$j++)
	{
		echo "[".$j."]=".$arr[$j]."<br>";	
	}
}
function condenseArray($arr)
{
	$ar=array();
	$ar[0]=$arr[0];
	$j=1;
	for($i=1;$i<count($arr);$i++)
	{
		//$ar[$j]=$arr[$i];
		//unset($arr[$i]);
		if(array_search($arr[$i],$ar) ===false)
		{
			$ar[$j]=$arr[$i];
			$j++;
		}
	}
	return $ar;
}
$a=array(1,2,3,4,4,4,5,6,6,7);
$a=condenseArray($a);
dispArr($a);
?>