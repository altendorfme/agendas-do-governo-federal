<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/functions.php');

if( PHP_SAPI !== 'cli' ) {
    http_response_code(401);
    exit;
}

echo '[Date]'.PHP_EOL;

$shortopts  = "";
$shortopts .= "k:";
$shortopts .= "d:";
$shortopts .= "s:";
$longopts  = array(
    "secret_key:",
    "date:",
    "schedule:"
);
$getopt = getopt($shortopts, $longopts);

if( (!empty($getopt['date'])) && (!empty($getopt['schedule'])) ) {
    $date = $getopt['date'];
    $schedule_id = $getopt['schedule'];

    echo 'Date: '.$date.PHP_EOL;
    echo 'Schedule ID: '.$schedule_id.PHP_EOL;
    
    $mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
    $mysqli->set_charset("utf8");
    
    $schedule = "SELECT * FROM `schedule` WHERE `id` = ".$schedule_id;
    $schedule_query = mysqli_query($mysqli, $schedule);
    while($data = mysqli_fetch_array($schedule_query)) {
        $id = $data['id'];
        $name = $data['name'];
        $url = $data['url'];
    
        echo '==='.PHP_EOL;
    
        echo '['.$id.']: '.$name.PHP_EOL;
        echo $url.PHP_EOL;
    
        get_events_by_date($date, $id, $url);
    }
} else {
    echo 'Empty parameters'.PHP_EOL;
}