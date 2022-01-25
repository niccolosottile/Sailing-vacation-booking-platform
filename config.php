<?php
/* Database credentials.*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'zt45incd_edenj');
define('DB_PASSWORD', 'bowdu7-mopvav-tiwjUf');
define('DB_NAME', 'zt45incd_edenjsailadventures');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>