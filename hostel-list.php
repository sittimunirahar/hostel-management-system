<?php
require 'database/credentials.php';

$hos_list = array();

$sql = "SELECT hos_name FROM hostel_details WHERE hos_managed_by='IIC'";

if (!mysqli_query($link, $sql)) {

  die('Error: ' . mysqli_error($link));
} else {
  $result = mysqli_query($link, $sql);
  while ($row = mysqli_fetch_row($result)) {

    $row_data = array(

      'hos_name' => $row[0]

    );

    array_push($hos_list, $row_data);
  }
}

mysqli_close($link);
echo json_encode($hos_list);
