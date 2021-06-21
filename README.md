# Campervan case study

## Requirements
* Symfony 5.3
* PHP 7.2.5 minimum
* MariaDB 10.4

## Docker setup

* Follow instructions from docker-setup.md
* Docker initial run installs symfony vendors + executes initial data migrations

## Campervan case study

* Generate random orders with symfony console command. It can be executed as many times as wanted.
  Each run will truncate all related tables before inserting new orders:
```
php bin/console campervan:orders-generate -vvv
```

* Orders generator will place 4 orders for every existing campervan (200 campervans are in test db).

* Open http://localhost to verify dashboard
* Open http://localhost/api/demands to verify json response for REST API

### About the solution

* I prefixed all db tables as "cv" (shortcut to campervan) to prevent naming conflicts with reserved keywords.
This approach also groups all application specific tables in adminer or other DB UI tool for better visual understanding.

* Without orders there are no demands nor surplus in system.
  My starting point was that demand arises when first order is placed
  as it was not said otherwise in initial task description.

* "Demands" calculation (DemandDetector object) is executed during orders generating command and cached into cv_station_equipment_demand table.
This makes it easier to serve data later. No "on the fly" complicated calculations are made. 

* I used bootstrap for UX.

* Demands listing (timeline) excludes days where no order is having start nor end.
This way we can prevent data where "booked count"=0 and "available count"=0 which are redundant.

* REST API endpoint uses same pagination and filtering params as UX solution. Note:
  I did not use some heavy third-party REST API component as this was not the purpose of current task.
  In real-life scenario where application contains tens or hundreds of API endpoints, third party component might be reasonable choice.