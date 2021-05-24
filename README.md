# Agendas do Governo Federal

## Crawler

Para baixar o histórico de uma agenda é utilizado o **history.php**, pode ser passado o parâmetro *schedule* com id de uma agenda especifica, se não irá baixar novamente todos as agendas registradas na tabela.

O crawler diário é o **daily.php**, que irá baixar todos os dados do dia atual de todas as agendas, deve ser agendado com um crawler para as 00h

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
**week_day** = dia da semana, sendo 0 = domingo  
**hour_start** = horário do inicio do evento  
**hour_end** =  horário do encerramento do evento  
**interval** = tempo total do evento  
**title** = nome do evento  
**place** = local do evento  
**schedule_id** = id do agenda

### schedule:

> **id** = id  
**name** = nome da agenda
**url** =  url da agenda

## Configuração
Renomear *config.sample.php* para *config.php* e preencher as credenciais do banco de dados.