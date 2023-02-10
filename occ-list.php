<?php
require 'database/credentials.php';

$unit_list = array();

$sql = "SELECT student_list.matric, student_list.first_name, student_list.last_name, student_list.program, 
	  student_list.year,stay_latest.status, stay_latest.hos_name, check_in.unit_no, check_in.date_in
	  FROM student_list 
	  JOIN check_in ON student_list.matric=check_in.matric
	  LEFT JOIN stay_latest ON check_in.matric=stay_latest.matric";

if (!mysqli_query($link, $sql)) {

	die('Error: ' . mysqli_error($link));
} else {
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_row($result)) {

		$row_data = array(

			'matric' => $row[0],
			'first_name' => $row[1],
			'last_name' => $row[2],
			'program' => $row[3],
			'year' => $row[4],
			'status' => $row[5],
			'hos_name' => $row[6],
			'unit_no' => $row[7],
			'date_in' => $row[8]
		);

		array_push($unit_list, $row_data);
	}
}

mysqli_close($link);
echo json_encode($unit_list);
