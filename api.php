<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/functions.php');

if( PHP_SAPI !== 'cli' ) {
    http_response_code(401);
    exit;
}

echo '[API]'.PHP_EOL;

$shortopts  = "";
$shortopts .= "s::";
$longopts  = array(
    "schedule::",
);
$getopt = getopt($shortopts, $longopts);

$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
$mysqli->set_charset("utf8");

if( empty($getopt['schedule']) ) {
    $schedule = "SELECT * FROM `schedule`";    
} else {
    $schedule = "SELECT * FROM `schedule` WHERE `id` = ".$getopt['schedule'];
}
$schedule_query = mysqli_query($mysqli, $schedule);
while($data = mysqli_fetch_array($schedule_query)) {
    $id = $data['id'];

    query_schedule($id);
}