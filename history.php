<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/functions.php');

if( PHP_SAPI !== 'cli' ) {
    http_response_code(401);
    exit;
}

echo '[History]'.PHP_EOL;

$shortopts  = "";
$shortopts .= "k:";
$shortopts .= "s::";
$longopts  = array(
    "secret_key:",
    "schedule::"
);
$getopt = getopt($shortopts, $longopts);

$date = '2019-01-01';
$today = date('Y-m-d');
echo 'Start date: '.$date.PHP_EOL;
echo 'Today: '.$today.PHP_EOL;

$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
$mysqli->set_charset("utf8");

if( empty($getopt['schedule']) ) {
    $schedule = "SELECT * FROM `schedule`";
    echo 'Schedule ID: Empty'.PHP_EOL;
} else {
    $schedule = "SELECT * FROM `schedule` WHERE `id` = ".$getopt['schedule'];
    echo 'Schedule ID: '.$getopt['schedule'].PHP_EOL;
}
$schedule_query = mysqli_query($mysqli, $schedule);
while($data = mysqli_fetch_array($schedule_query)) {
    $id = $data['id'];
    $name = $data['name'];
    $url = $data['url'];

    echo '==='.PHP_EOL;

    echo '['.$id.']: '.$name.PHP_EOL;
    echo $url.PHP_EOL;

    for ($i = 0; ; $i++) {
        if( $date > $today ) {
            break;
        }
        if( $date <= $today ) {
            get_events_by_date($date, $id, $url);

            $date = date('Y-m-d', strtotime($date . ' +1 day'));
        }
    }
}