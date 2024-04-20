# Roster - Crew Connex
The business logic which parsing the relevant data from the raw roster.

## Stack version
1. PHP 8.2
2. Laravel 10.x
3. Docker

## Install / run
1. git clone https://github.com/morrasan/roster.git
2. docker compose up 
3. open terminal on the `roster-app` container and run commands:
   - composer install
   - php artisan migrate
   - php artisan optimize 

## Environment
1. `date_init` = `14 january 2022` \\ current date set to 14 Jan 2022
2. `activity_table_id` = `ctl00_Main_activityGrid` \\ ID tag of table to import from the roster html file
3. http://localhost:8000 - REST Api 

## Endpoints
1. `/api/activities` method POST with param `roster` - file `Roster - CrewConnect.html` - Upload file
2. `/api/activities` method GET with query params `date_start` and `date_end` - Give all events between date x and y
3. `/api/activities/next-week` method GET - Give all flights for the next week
4. `/api/activities/standby-next-week` method GET - Give all standby for the next week
5. `/api/api/activities/from/{location}` method GET - Give all flights that start on the given location

