<?php
require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__).'/../functions.php');

$format = isset($_GET['format']) ? $_GET['format'] : 'json';
$array = query();
if(empty($array)) {
	header('Content-Type: application/json');
	$array = ['error' => 'no data'];
	echo json_encode($array, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
} else {
	if($format == 'json') {
		header('Content-Type: application/json');
		echo json_encode($push, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
	} else if($format == 'csv') {
		header('Content-Encoding: UTF-8');
		header('Content-type: text/plain; charset=UTF-8');
		header('Pragma: no-cache');
		header('Expires: 0');

		$push = fopen('php://output', 'w');
		$header = array(
			'id',
			'name',
			'url'
		);
		fputcsv($push, $header);
		foreach($array as $data) {
			$row = array(
				$data['id'],
				$data['name'],
				$data['url'],
			);
			fputcsv($push, $row);
		}
		fclose($push);
		return $push;
	} else {
		$array = ['error' => 'invalid format'];
		http_response_code(500);
		echo json_encode($array, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
	}
}

function query() {
	$array = [];

	$mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
	$mysqli->set_charset("utf8");

	$schedules = "SELECT * FROM `schedule`";
	$schedules_query = mysqli_query($mysqli, $schedules);
	
	while($data = mysqli_fetch_array($schedules_query)) {
		$id = $data['id'];
		$name = $data['name'];
		$url = $data['url'];

		$push = array(
			'id' => $id,
			'name' => $name,
			'url' => $url
		);
		array_push($array, $push);
	}
	return $array;
}