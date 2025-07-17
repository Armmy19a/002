<?php

$con = mysqli_connect("localhost","root","rootroot","durable");
$con->set_charset("utf8");

//$con->query("SET NAMES utf8");

if($_REQUEST["load"]=="product"){
	
	$result = $con->query("select * from equipments where equipments_id ='{$_GET["pro_id"]}'");

	$array = array();
	while($row = $result->fetch_object()){
		
		array_push($array, $row);
	}
	echo json_encode($array);
}

?>



