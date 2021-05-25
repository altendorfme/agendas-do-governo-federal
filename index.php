
<?php
require_once(dirname(__FILE__).'/config.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendas do Governo Federal</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png">
    <link rel="manifest" href="/assets/site.webmanifest">
    <link rel="mask-icon" href="/assets/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="/assets/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <meta name="description" content="Agendas do Governo Federal">
    <meta name="image" content="https://agendas-do-governo-federal.bot.nu/assets/ogimage.png">
    <meta itemprop="name" content="Agendas do Governo Federal">
    <meta itemprop="description" content="Agendas do Governo Federal">
    <meta itemprop="image" content="https://agendas-do-governo-federal.bot.nu/assets/ogimage.png">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Agendas do Governo Federal">
    <meta name="twitter:description" content="Agendas do Governo Federal">
    <meta name="twitter:site" content="@altendorfme">
    <meta name="twitter:image:src" content="https://agendas-do-governo-federal.bot.nu/assets/ogimage.png">
    <meta name="og:title" content="Agendas do Governo Federal">
    <meta name="og:description" content="Agendas do Governo Federal">
    <meta name="og:image" content="https://agendas-do-governo-federal.bot.nu/assets/ogimage.png">
    <meta name="og:url" content="https://agendas-do-governo-federal.bot.nu">
    <meta name="og:site_name" content="Agendas do Governo Federal">
    <meta name="og:locale" content="pt_BR">
    <meta name="og:type" content="website">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #FBFBFB;
            font-family: 'Source Code Pro', monospace;
            color: #989fb1;
            padding: 1rem;
            font-size: 16px;
        }
        a {
            color: #989fb1;
        }
        a:hover {
            text-decoration: none;
        }
        h1 {
            margin: 0;
            padding-bottom: .4rem;
            color: #4876d6;
        }
        select {
            font-family: 'Source Code Pro', monospace;
            font-size: 16px;
            padding: .2rem;
            margin-bottom: .5rem;
        }
        .endpoint {
            display: none;
        }
        .endpoint p {
            margin: 0;
        }
        .endpoint a {
            color: #0c969b;
        }
    </style>
</head>
<body>
    <h1>Agendas do Governo Federal</h1>

    <select name="schedule" id="schedule">
        <option value="" selected disabled>Agendas</option>
        <?php
            $mysqli = new mysqli($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_password'], $GLOBALS['mysql_database']);
            $mysqli->set_charset("utf8");

            $schedules = "SELECT * FROM `schedule`";
            $schedules_query = mysqli_query($mysqli, $schedules);
            
            while($data = mysqli_fetch_array($schedules_query)) {
                $id = $data['id'];
                $name = $data['name'];
                $url = $data['url'];
                $active = $data['active'];
                ?>
                <option value="<?php echo $id; ?>" data-url="<?php echo $url; ?>" <?php ($active == 0) ? 'disabled' : ''; ?>><?php echo $name; ?></option>
                <?php
            }
        ?>
    </select>

    <select name="year" id="year">
        <option value="" selected disabled>Ano</option>
        <option value="">Todos</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
    </select>

    <div class="endpoint" id="endpoint">
        <p>CSV: <a href="#" target="_blank" id="csv">/api/?schedule=1&year=2021&format=csv</a></p>
        <p>JSON: <a href="#" target="_blank" id="json">/api/?schedule=1&year=2021&format=json</a></p>
        <p>Fonte: <a href="#" target="_blank" id="source">gov.br</a></a>
    </div>

    <p><a href="https://github.com/altendorfme/agendas-do-governo-federal" target="_blank"><strong>Github</strong></a> / <a href="https://twitter.com/altendorfme" target="_blank"><strong>Twitter</strong></a></p>

    <script src="//cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
    <script>
        $(function() {
            $('#schedule,#year').on('change',function(){
                var id = $('#schedule').val();
                var url = $('#schedule').find(':selected').attr('data-url');
                var year = $('#year').val();
                $('#endpoint').show();
                $('#source').attr('href', url);
                if(year == null || year == '') {
                    var csv = '/api/?schedule='+id+'&format=csv';
                    var json = '/api/?schedule='+id+'&format=json';
                    $('#csv').attr('href', csv).html(csv);
                    $('#json').attr('href', json).html(json);
                } else {
                    var csv = '/api/?schedule='+id+'&year='+year+'&format=csv';
                    var json = '/api/?schedule='+id+'&year='+year+'&format=json';
                    $('#csv').attr('href', csv).html(csv);
                    $('#json').attr('href', json).html(json);
                }
            })
        });
    </script>
</body>
</html>