# Agendas do Governo Federal

## Crawler (CLI)

Para baixar o histórico desde 01-01-2019 de todas as agendas é utilizado o **history.php**, está disponivel o parâmetro *--schedule={id}* para baixar tudo de uma agenda especifica.

O crawler diário é o **daily.php**, que irá baixar todos os dados do dia atual de todas as agendas, deve ser agendado como um cron às 00:00 (GMT -3).

**date.php**, deve ser utilizado para forçar o download de uma data e agenda especifico com os parametros *--schedule={id}* e *--date=ANO-MES-DIA*.

## API

**api/schedule.php** - lista todos as agendas registradas no banco de dados com id, nome e url.
parâmetros disponível:
- format={csv|json}

**api/index.php** - lista todos as agendas registradas no banco de dados com id, nome e url.
parâmetros disponível:
- format={csv|json}
- year={ano-especifico}
- schedule={id}

## SQL
> database/sample.sql

### events:

> **date** = data do evento
> **week_day** = dia da semana, sendo 0 = domingo  
> **hour_start** = horário do inicio do evento  
> **hour_end** =  horário do encerramento do evento  
> **interval** = tempo total do evento  
> **title** = nome do evento  
> **place** = local do evento  
> **schedule_id** = id do agenda

### schedule:

> **id** = id  
> **name** = nome da agenda
> **url** = url da agenda
> **active** = se a agenda especifica está ativa para o crawler, sendo 1 = ativo

Quando é trocado algum ministro a agenda mantem a mesma url, mas é zerada, o recomendado é cria um novo schedule.

## Configuração
Renomear *config.sample.php* para *config.php* e preencher as credenciais do banco de dados.