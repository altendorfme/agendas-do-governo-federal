<?php
require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__).'/../functions.php');

$format = isset($_GET['format']) ? $_GET['format'] : 'json';
$appointment = isset($_GET['appointment']) ? $_GET['appointment'] : null;
$year = isset($_GET['year']) ? $_GET['year'] : null;

if($format == 'json') {
	header('Content-Type: application/json');
	$push = query($year);
	echo json_encode($push, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
} else if($format == 'csv') {
	header('Content-Encoding: UTF-8');
	header('Content-type: text/plain; charset=UTF-8');
	header('Pragma: no-cache');
	header('Expires: 0');

	$array = query($year);
	$out = fopen('php://output', 'w');
	$header = array(
		'date',
		'week_day',
		'week_day_readable',
		'hour_start',
		'hour_end',
		'minutes',
		'minutes_readable',
		'event_description',
		'event_local'
	);
	fputcsv($out, $header);
	foreach($array as $data) {
		$row = array(
			$data['date'],
			$data['week_day'],
			$data['week_day_readable'],
			$data['hour_start'],
			$data['hour_end'],
			$data['minutes'],
			$data['minutes_readable'],
			$data['event_description'],
			$data['event_local']
		);
		fputcsv($out, $row);
	}
	fclose($out);
	return $out;
}

function query($appointment = null, $year = null) {
	$array = [];

	$mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
	$mysqli->set_charset("utf8");

	$count = "SELECT count(*) FROM `events`";
	$count_query = mysqli_query($mysqli, $count);
	$limit = mysqli_fetch_array($count_query)[0];

	if($year == null) {
		if($appointment == null) {
			$events = "SELECT * FROM `events` LIMIT 0,".$limit;
		} else {
			$events = "SELECT * FROM `events` WHERE `appointment_id` = '".$appointment."' LIMIT 0,".$limit;
		}
	} else {
		if($appointment == null) {
			$events = "SELECT * FROM `events` WHERE `date` >= '".$year."-01-01' AND `date` <= '".$year."-12-31' ORDER BY `date` LIMIT 0,".$limit;
		} else {
			$events = "SELECT * FROM `events` WHERE `date` >= '".$year."-01-01' AND `date` <= '".$year."-12-31' AND `appointment_id` = '".$appointment."' ORDER BY `date` LIMIT 0,".$limit;
		}
	}
	$events_query = mysqli_query($mysqli, $events);
	
	while($data = mysqli_fetch_array($events_query)) {
		$date = $data['date'];
		$week_day = $data['week_day'];
		$hour_start = $data['hour_start'];
		$hour_end = $data['hour_end'];
		$interval = $data['interval'];
		$title = $data['title'];
		$place = $data['place'];

		$push = array(
			'date' => $date,
			'week_day' => $week_day,
			'week_day_readable' => week_day_name($week_day),
			'hour_start' => $hour_start,
			'hour_end' => $hour_end,
			'minutes' => $interval,
			'minutes_readable' => minutes_to_readable($interval),
			'event_description' => (empty($title)) ? null : $title,
			'event_local' => (empty($place)) ? null : $place
		);
		array_push($array, $push);
	}
	return $array;
}