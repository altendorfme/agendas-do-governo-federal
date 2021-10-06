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

function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function get_events_by_date($date, $schedule, $url) {
    $week_day = date('w', strtotime($date));
    echo '---'.PHP_EOL;
    echo 'Date: '.$date.' ('.week_day_name($week_day).')'.PHP_EOL;

    if(get_http_response_code($url.$date) == '200'){
        $source = file_get_contents($url.$date);

        $dom = new DOMDocument();
        libxml_use_internal_errors(TRUE);
        $dom->loadHTML($source);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $rows = $xpath->query('//li[@class="item-compromisso-wrapper"]');

        $events = [];

        $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        $mysqli->set_charset("utf8");

        $i = 1;
        foreach($rows as $data) {
            $title = $xpath->query('.//h4[contains(@class, "compromisso-titulo")]', $data)[0]->nodeValue;
            if( trim($title) == 'Sem compromisso oficial' ) {
                echo 'Sem compromisso oficial'.PHP_EOL;
                continue;
            }
            if( isset($xpath->query('.//div[contains(@class, "compromisso-participantes")]', $data)[0]) ) {
                $participants = trim($xpath->query('.//div[contains(@class, "compromisso-participantes")]//ul', $data)[0]->nodeValue);

                $title = $title.'; '.$participants;
            }
            $title = preg_replace('/\s+/', ' ', $title);

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

            if( isset($xpath->query('.//div[@class="compromisso-local"]', $data)[0]) ) {
                $place = $xpath->query('.//div[@class="compromisso-local"]', $data)[0]->nodeValue;
            } else {
                $place = null;
            }

			$event = "SELECT * FROM `events` WHERE `date` = '".$date."' AND `week_day` = ".$week_day." AND `hour_start` = '".$hour_start."' AND `hour_end` = '".$hour_end."' AND `interval` = '".$interval."' AND `title` = '".$title."' AND `place` = '".$place."' AND `schedule_id` = '".$schedule."' LIMIT 1;";
			$event_query = mysqli_query($mysqli, $event);
			if (mysqli_num_rows($event_query) > 0) {
				echo '= Event already registered'.PHP_EOL;
			} else {
				echo '+ Insert event'.PHP_EOL;
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

            echo '['.$i.']: '.$title.PHP_EOL;
            echo 'Hours: '.$hour_start.' ~ '.$hour_end.PHP_EOL;
            echo 'Interval: '.$interval.' minutes'.PHP_EOL;
            echo 'Place: '.$place.PHP_EOL;

            $i++;
        }
    } else {
        echo 'Invalid source'.PHP_EOL;
    }
}

function query_schedule($schedule = null) {
	$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
	$mysqli->set_charset("utf8");

	$array = [];

	$events = "SELECT * FROM `events` WHERE `schedule_id` = '".$schedule."'";
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

	$json = json_encode($array, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents(dirname(__FILE__).'/api/'.$schedule.'.json', $json);

    $push = fopen(dirname(__FILE__).'/api/'.$schedule.'.csv', 'w');
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
}