<?php
//Database connection, for saving Raw iCal feeds
$host = "localhost";
$user = "raw_user";
$password = "raw_pass";
$database = "raw_database";

$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//Database connection, for saving Fieldmapped events
$khost = "localhost";
$kuser = "mapped_user";
$kpassword = "mapped_pass";
$kdatabase = "mapped_database";

$kmysqli = new mysqli($khost, $kuser, $kpassword, $kdatabase);
if ($kmysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $kmysqli->connect_errno . ") " . $kmysqli->connect_error;
}