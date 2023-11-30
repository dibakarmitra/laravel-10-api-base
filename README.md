PrebidAdapter_CampaignAPI
-------------------------
              

docker-compose up

docker exec -it phpdocker-laravel-mongo_php-fpm_1 bash

then execute laravel's or php required command line commands


Laravel end point :

  http://localhost:5000/

Mongo endpoint:

  http://localhost:8081/

    admin||pass [better check console]



all port & config is in

  /docker-compose.yml

  /.env

  /config/*



if anywhere permission related issue occurs give permission

chown :www-data vendor/ storage/ bootstrap/ -R

chmod 777 <folder> -R

chmod 777 <file>

