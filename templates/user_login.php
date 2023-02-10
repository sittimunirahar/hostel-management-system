<?php
	 session_start();
	 $online=0;
	 
	 if(!empty($_SESSION['password'])&& !empty($_SESSION['username'])){
	 	$online=1;
		$pos=$_SESSION['position'];
		//echo $pos;
		$password=$_SESSION['password'];
		$username=$_SESSION['username'];

		$month='';
		unset($_SESSION['month']);

		$month=date('m');
		$year=date('Y');

		$date="";

		if (!empty($_GET['month'])){
		 $month=$_GET['month'];
		 $_SESSION['month']=$month;
		 $month=$_SESSION['month'];
		}

		if (!empty($_GET['year'])){
		 $year=$_GET['year'];
		 $_SESSION['year']=$year;
		 $year=$_SESSION['year'];
		 
		}

		 $query="SELECT * FROM admin_acc JOIN staff_acc ON admin_acc.username = staff_acc.id 
					LEFT JOIN uploads ON admin_acc.username=uploads.description
					WHERE admin_acc.username='$username'";
		 $record=mysqli_query($link, $query);
	}
?>