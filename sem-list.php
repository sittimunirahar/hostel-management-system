<?php

require 'database/credentials.php';

$sem_list = array();

$sql = "SELECT 
sem_list.sem_id, sem_list.semester, sem_list.session, sem_list.status, sem_duration.dur_id,MONTHNAME(STR_TO_DATE(sem_duration.month, '%m')) 
as month, sem_duration.year, hostel_list.hos_name,
fees_setting.month as fm, fees_setting.year as fy, fees_setting.description, fees_setting.fees_per_month as amount
FROM 
sem_list LEFT JOIN sem_duration ON sem_list.sem_id=sem_duration.sem_id JOIN hostel_list LEFT JOIN
fees_setting ON fees_setting.month=sem_duration.month 
AND fees_setting.description=hostel_list.hos_name";

if (!mysqli_query($link, $sql)) {

  die('Error: ' . mysqli_error($link));
} else {
  $result = mysqli_query($link, $sql);
  while ($row = mysqli_fetch_row($result)) {

    $row_data = array(

      'sem_id' => $row[0],
      'semester' => $row[1],
      'session' => $row[2],
      'status' => $row[3],
      'dur_id' => $row[4],
      'month' => $row[5],
      'year' => $row[6],
      'hos_name' => $row[7],
      'fm'  => $row[8],
      'fy'  => $row[9],
      'description' => $row[10],
      'amount' => $row[11]

    );

    array_push($sem_list, $row_data);
  }
}

mysqli_close($link);
echo json_encode($sem_list);
