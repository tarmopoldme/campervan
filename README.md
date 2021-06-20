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

* Orders generator will place one order for every existing campervan (100 campervans are in db).

* Open http://localhost or http://campervan.local to verify dashboard

### Some words about the solution

* I prefixed all db tables as "cv" (shortcut to campervan) to prevent naming conflicts with reserved keywords.
This also groups all application specific tables as one listing in adminer or other DB UI tool.

* Without orders there are no demands nor surplus in system.
  My starting point was that demand arises when first order is placed
  as it was not said otherwise in initial task description.

* "Demands" calculation is executed during orders generating command and cached to cv_station_equipment_demand table.
This makes it easier to serve data later. No "on the fly" complicated calculations are made.

* I used bootstrap for UX.

* Demands listing does not include days which does not contain any order start day nor end day in system.
This way we can prevent data where "booked count"=0 and "available count"=0 which are redundant.
