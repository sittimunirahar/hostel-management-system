<?php
 $server = "localhost:3306";
 $username = "root";
 $password = "hostel_user@123";
 $database = "hostel";
	$link = mysqli_connect($server,$username,$password,$database);
	if(!$link){
		print "Connection is not established successfully.<br>";}
