<?php
require 'database/credentials.php';
$fees_list = array();

$sql = "SELECT description, year, month, fees_per_month FROM fees_setting";

if (!mysqli_query($link, $sql)) {

  die('Error: ' . mysqli_error($link));
} else {
  $result = mysqli_query($link, $sql);
  while ($row = mysqli_fetch_row($result)) {

    $row_data = array(

      'description' => $row[0],
      'year' => $row[1],
      'month' => $row[2],
      'fees_per_month' => $row[3]
    );

    array_push($fees_list, $row_data);
  }
}

mysqli_close($link);
echo json_encode($fees_list);
