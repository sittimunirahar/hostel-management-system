<?php
header("Access-Control-Allow-Origin: * ");
require_once 'connectdb.php';

    $username = $_GET['username'];
	
	$query = "UPDATE Admin set username = '$username' WHERE 1";
	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);

	$result = $mysqli->affected_rows;

	$json_response = json_encode($result);
