<?php
require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__).'/../functions.php');

$format = isset($_GET['format']) ? $_GET['format'] : 'json';
$schedule = isset($_GET['schedule']) ? $_GET['schedule'] : null;
$year = isset($_GET['year']) ? $_GET['year'] : null;

if( ($schedule == null) && ($year = null) ) {
	header('Content-Type: application/json');
	$array = ['error' => 'empty parameters'];
	echo json_encode($array, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
} else {
	$array = query($schedule, $year);
	if(empty($array)) {
		header('Content-Type: application/json');
		$array = ['error' => 'no data'];
		echo json_encode($array, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
	} else {
		if($format == 'json') {
			header('Content-Type: application/json');
			echo json_encode($array, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		} else if($format == 'csv') {
			header('Content-Encoding: UTF-8');
			header('Content-type: text/plain; charset=UTF-8');
			header('Pragma: no-cache');
			header('Expires: 0');

			$array = query($schedule, $year);
			$push = fopen('php://output', 'w');
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
			fputcsv($push, $header);
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
				fputcsv($push, $row);
			}
			fclose($push);
			return $push;
		}
	}
}

function query($schedule = null, $year = null) {
	$mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
	$mysqli->set_charset("utf8");

	$array = [];

	if($year == null) {
		if($schedule == null) {
			$events = "SELECT * FROM `events`";
		} else {
			$events = "SELECT * FROM `events` WHERE `schedule_id` = '".$schedule."'";
		}
	} else {
		if($schedule == null) {
			$events = "SELECT * FROM `events` WHERE year(`date`) IN (".$year.") ORDER BY `date`";
		} else {
			$events = "SELECT * FROM `events` WHERE year(`date`) IN (".$year.") AND `schedule_id` = '".$schedule."' ORDER BY `date`";
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