<?php  
$hostname="localhost";  
$username="root";  
$password="";  
$db = "test";  
$dbh = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);  
foreach($dbh->query('SELECT TIMESTAMPDIFF(MINUTE,"2009-05-18 11:45:42","2009-05-20 15:16:39")') as $row) {    
	echo $row['TIMESTAMPDIFF(MINUTE,"2009-05-18 11:45:42","2009-05-20 15:16:39")'];    
}  
?>