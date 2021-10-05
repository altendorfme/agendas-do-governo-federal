<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/functions.php');

if( PHP_SAPI !== 'cli' ) {
    http_response_code(401);
    exit;
}

echo '[Daily]'.PHP_EOL;

$shortopts  = "";
$shortopts .= "k:";
$shortopts .= "s::";
$shortopts .= "i::";
$longopts  = array(
    "schedule::",
    "ignore::"
);
$getopt = getopt($shortopts, $longopts);

$date = date('Y-m-d');
echo 'Date: '.$date.PHP_EOL;

$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
$mysqli->set_charset("utf8");

if( empty($getopt['schedule']) ) {
    $schedule = "SELECT * FROM `schedule` WHERE `active` = 1";    
} else {
    $schedule = "SELECT * FROM `schedule` WHERE `id` = ".$getopt['schedule'];
}
$schedule_query = mysqli_query($mysqli, $schedule);
while($data = mysqli_fetch_array($schedule_query)) {
    $id = $data['id'];
    $name = $data['name'];
    $url = $data['url'];

    echo '==='.PHP_EOL;

    echo '['.$id.']: '.$name.PHP_EOL;
    echo $url.PHP_EOL;

    if( empty($getopt['ignore']) ) {
        get_events_by_date($date, $id, $url);
    }

    query_schedule($id);
}