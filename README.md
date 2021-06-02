# Agendas do Governo Federal

Ambiente em produção:
> https://agendas-do-governo-federal.bot.nu

## Crawler (CLI)

**history.php**: Baixar o histórico desde 01-01-2019 de todas as agendas
Parâmetros obrigatorios:
- *--secret_key={secret_key}*
Parâmetros disponíveis:
- *--schedule={id}* para baixar tudo de uma agenda especifica.

**daily.php**: Baixa todos os dados do dia atual de todas as agendas, deve ser agendado como um cron às 00:00 (GMT -3).
Parâmetros obrigatorios:
- *--secret_key={secret_key}*

**date.php**: Deve ser utilizado para forçar o download de uma data e agenda especifica.
Parâmetros obrigatorios:
- *--secret_key={secret_key}*
- *--schedule={id}*
- *--date={ANO-MES-DIA}*.

## API

**api/schedule.php** - lista todos as agendas registradas no banco de dados com id, nome e url.
Parâmetros disponíveis:
- format={csv|json}

**api/index.php** - lista todos as agendas registradas no banco de dados com id, nome e url.
Parâmetros disponíveis:
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
> **political_party** = partido politico
> **department** = área do governo ou ministério
> **initials** = iniciais da área do governo ou ministério
> **url** = url da agenda
> **dashboard** = url do dashboard
> **start_date** = data de inicio da gestão
> **active** = se a agenda especifica está ativa para o crawler, sendo 1 = ativo


Quando é trocado algum ministro a agenda mantem a mesma url, mas é zerada, o recomendado é cria um novo schedule.

## Configuração
Renomear *config.sample.php* para *config.php* e preencher as credenciais do banco de dados e o valor do *secret_key*, que deve ser chave de segurança para rodar os crawlers.