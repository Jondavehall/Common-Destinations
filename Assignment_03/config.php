<?php

$host = "localhost"; /* Host name */
$username = "jo337229"; /* User */
$password = "Password1234!"; /* Password */
$dbname = "jo337229"; /* Database name */

$con = mysqli_connect($host, $username, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}
