<?php
require 'database/credentials.php';

$unit_list = array();

$sql = "SELECT unit_list.unit_no AS unitno, unit_list.hos_name AS hosname, MONTH(owner_list.expiry_date) as m, YEAR(owner_list.expiry_date) as y,
		COUNT(DISTINCT CASE WHEN stay_latest.status='CI' THEN stay_latest.matric END) AS tot_occ,
		hostel_details.unit_max_occ as umo, hostel_details.hos_gender as gender FROM unit_list
		LEFT JOIN stay_latest ON unit_list.unit_no = stay_latest.unit_no
		LEFT JOIN hostel_details ON unit_list.hos_name = hostel_details.hos_name
		LEFT JOIN owner_list ON unit_list.owner_id=owner_list.owner_id
		GROUP BY unit_list.unit_no";

if (!mysqli_query($link, $sql)) {

	die('Error: ' . mysqli_error($link));
} else {
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_row($result)) {

		$row_data = array(

			'unitno' => $row[0],
			'hosname' => $row[1],
			'm' => $row[2],
			'y' => $row[3],
			'tot_occ' => $row[4],
			'umo' => $row[5]

		);

		array_push($unit_list, $row_data);
	}
}

mysqli_close($link);
echo json_encode($unit_list);
