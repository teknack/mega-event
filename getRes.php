<?php
/*
 * ajax code for admin-main.php :: do not mess with this code please
 */

include "./db_access/db.php";

$conn = connect();
setTable("market");
$query = "SELECT * FROM market WHERE id=1;";
$res = mysqli_query($conn,$query);
$res = mysqli_fetch_assoc($res);
disconnect();

echo("".$res['wood_demand'].",".$res['food_demand'].",".$res['water_demand'].",".$res['power_demand'].",".$res['metal_demand']."");

?>
