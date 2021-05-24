<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/functions.php');

echo '[History]'.PHP_EOL;
$date = '2019-01-01';
$today = date('Y-m-d');
echo 'Start date: '.$date.PHP_EOL;
echo 'Today: '.$today.PHP_EOL;

$mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
$mysqli->set_charset("utf8");

if( isset($_GET['schedule']) ) {
    $schedule = "SELECT * FROM `schedule` WHERE `active` = 1 AND `id` = ".$_GET['schedule'];
    echo 'Schedule ID: '.$_GET['schedule'].PHP_EOL;
} else {
    $schedule = "SELECT * FROM `schedule` WHERE `active` = 1";
    echo 'Schedule ID: Empty'.PHP_EOL;
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