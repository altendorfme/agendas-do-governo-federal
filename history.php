<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/functions.php');

$date = '2019-01-01';
$today = date('Y-m-d');

$mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
$mysqli->set_charset("utf8");

if( isset($_GET['appointment']) ) {
    $appointment = "SELECT * FROM `appointment` WHERE `id` = ".$_GET['appointment']." LIMIT 1";
} else {
    $appointment = "SELECT * FROM `appointment` LIMIT 0,1000";
}
$appointment_query = mysqli_query($mysqli, $appointment);
while($data = mysqli_fetch_array($appointment_query)) {
    $id = $data['id'];
    $name = $data['name'];
    $url = $data['url'];

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