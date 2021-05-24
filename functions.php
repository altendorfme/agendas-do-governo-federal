<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

function week_day_name($i) {
    switch ($i) {
        case 0:
            $push = "Domingo";
            break;
        case 1:
            $push = "Segunda-feira";
            break;
        case 2:
            $push = "Terça-feira";
            break;
        case 3:
            $push = "Quarta-feira";
            break;
        case 4:
            $push = "Quinta-feira";
            break;
        case 5:
            $push = "Sexta-feira";
            break;
        case 6:
            $push = "Sábado";
            break;
    }
    return $push;
}

function utils_days($date_start, $date_end, $holydays = []) {
    $start = strtotime($date_start);
    $end = strtotime($date_end);

    $days_quantity = 0;
    while ($start <= $end) {
        $day_weekend = (date('D', $start) === 'Sat' || date('D', $start) === 'Sun');
        $day_holyday = (count($holydays) && in_array(date('Y-m-d', $start), $holydays));

        $start += 86400; // 86400 quantidade de segundos em um dia

        if ($day_weekend || $day_holyday) {
            continue;
        }

        $days_quantity++;
    }

    return $days_quantity;
}

function minutes_to_readable($minutes) {
    $zero    = new DateTime('@0');
    $offset  = new DateTime('@' . $minutes * 60);
    $diff    = $zero->diff($offset);

    $hour = $diff->format('%h');
    $minute = $diff->format('%i');

    $readable_hour  = ($hour > 1) ? 'horas' : 'hora';
    $readable_minute = ($minute > 1) ? 'minutos' : 'minuto';

    $push = (($hour >= 1) ? $hour.' '.$readable_hour.(($minute >= 1) ? ' e ' : '') : '').(($minute >= 1) ? $minute.' '.$readable_minute : '');

    return $push;
}

function get_events_by_date($date, $schedule, $url) {
    $source = file_get_contents($url.$date);

    $dom = new DOMDocument();
    libxml_use_internal_errors(TRUE);
    $dom->loadHTML($source);
    libxml_clear_errors();
    $xpath = new DOMXPath($dom);

    $rows = $xpath->query('//li[@class="item-compromisso-wrapper"]');

    $events = [];

    $mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
    $mysqli->set_charset("utf8");

    foreach($rows as $data) {
        $title = $xpath->query('.//h4[contains(@class, "compromisso-titulo")]', $data)[0]->nodeValue;
        if( trim($title) == 'Sem compromisso oficial' ) {
            continue;
        }
        if( isset($xpath->query('.//div[contains(@class, "compromisso-participantes")]', $data)[0]) ) {
            $participants = trim($xpath->query('.//div[contains(@class, "compromisso-participantes")]//ul', $data)[0]->nodeValue);

            $title = $title.'; '.$participants;
        }

        $hours = $xpath->query('.//div[@class="horario"]', $data)[0]->nodeValue;
        $hours = explode('-', $hours);
        $hour_start = trim(str_replace('h',':',$hours[0])).':00';
       
        if( !isset($hours[1]) ) {
            $hour_end = '00:00:00';
            $interval = 0;
        } else {
            $hour_end = trim(str_replace('h',':',$hours[1])).':00';
            $time1 = new DateTime($hour_start);
            $time2 = new DateTime($hour_end);
            $diff = $time1->diff($time2);
            $interval = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
        }

        $week_day = date('w', strtotime($date));
        $place = $xpath->query('.//div[@class="compromisso-local"]', $data)[0]->nodeValue;

        echo '---'.PHP_EOL;

        echo 'Date: '.$date.' ('.week_day_name($week_day).')'.PHP_EOL;
        echo 'Hours: '.$hour_start.' ~ '.$hour_end.PHP_EOL;
        echo 'Interval: '.$interval.' minutes'.PHP_EOL;
        echo 'Title: '.$title.PHP_EOL;
        echo 'Place: '.$place.PHP_EOL;

        $query = "INSERT INTO `events` (
            `date`,
            `week_day`,
            `hour_start`,
            `hour_end`,
            `interval`,
            `title`,
            `place`,
            `schedule_id`
        ) VALUES (
            '".$date."',
            ".$week_day.",
            '".$hour_start."',
            '".$hour_end."',
            '".$interval."',
            '".$title."',
            '".$place."',
            '".$schedule."'
        );";
        mysqli_query($mysqli, $query);
    }
}