<!DOCTYPE html>
<html>
    <head>
        <title>Page</title>
    </head>

<body>
<?php
$host= 'localhost';
$dbUser= 'root';
$dbPass= '';
$dbName= 'avtomobili';
if (!$dbConn=mysqli_connect($host, $dbUser, $dbPass))
 {
 die('Не може да се осъществи връзка със сървъра.');
}
 if (!mysqli_select_db($dbConn,$dbName))
 {
 die('Не може да се селектира базата от данни.');
 }
 mysqli_query($dbConn,"SET NAMES 'UTF8'");

?>
</body>
</html>