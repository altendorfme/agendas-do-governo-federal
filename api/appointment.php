<?php
require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__).'/../functions.php');

$format = isset($_GET['format']) ? $_GET['format'] : 'json';
if($format == 'json') {
	header('Content-Type: application/json');
	$push = query();
	echo json_encode($push, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
} else if($format == 'csv') {
	header('Content-Encoding: UTF-8');
	header('Content-type: text/plain; charset=UTF-8');
	header('Pragma: no-cache');
	header('Expires: 0');

	$array = query();
	$out = fopen('php://output', 'w');
	$header = array(
		'id',
		'name',
		'url'
	);
	fputcsv($out, $header);
	foreach($array as $data) {
		$row = array(
			$data['id'],
			$data['name'],
			$data['url'],
		);
		fputcsv($out, $row);
	}
	fclose($out);
	return $out;
} else {
	$push = array(
		'error' => 'invalid format'
	);
	http_response_code(500);
	echo json_encode($push, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
}

function query() {
	$array = [];

	$mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
	$mysqli->set_charset("utf8");

	$appointments = "SELECT * FROM `appointment` LIMIT 0,1000";
	$appointments_query = mysqli_query($mysqli, $appointments);
	
	while($data = mysqli_fetch_array($appointments_query)) {
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