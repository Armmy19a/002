<?php

$connect = new PDO('mysql:host=localhost;dbname=builds', 'root', '');

$data = array();

$users_id = $_GET["users_id"];
$query = "SELECT * FROM salaries WHERE users_id = '".$users_id."' ORDER BY id DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
	$arrDate = explode("-", $row["salary_date"]);
	$arrDate[0] = $arrDate[0] - 543;
	$convert_date_use = $arrDate[0].'-'.$arrDate[1].'-'.$arrDate[2];
	//$cAppointment_Time = substr($row["salary_time"], 0,5);
	$amountSalary = number_format($row["salary_amount"]);
	

 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["salary_detail"]."\n".$amountSalary." บาท",
  'start'   => $convert_date_use,
  'end'   => $convert_date_use
 );
}

echo json_encode($data);

?>