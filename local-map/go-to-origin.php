<?php
include "../db_access/db.php";
validate();

$conn = connect();

$query="SELECT row,col from tk16_megaevent.grid WHERE occupied='".$_SESSION["tek_emailid"]."' AND fortification=-9;";
$res = mysqli_query($conn,$query);
$res = mysqli_fetch_assoc($res);
//echo($res["row"]." ");
//echo($res["col"]);
$row_send = $res["row"]-4;
$col_send = $res["col"]-4;
$_SESSION["coordn"]="".($row_send).",".($col_send)."";
redirect("../transfer.php");
?>
