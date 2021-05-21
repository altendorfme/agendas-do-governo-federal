<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/functions.php');

$date = date('Y-m-d');

get_events_by_date($date, 2, 'https://www.gov.br/saude/pt-br/acesso-a-informacao/agenda-de-autoridades/gabinete-do-ministro/ministro-de-estado-da-saude/ministro-da-saude/');