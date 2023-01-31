<?php
    // docker run --name mysql-db -p 3306:3306 -e MYSQL_ROOT_PASSWORD='root' -d mysql:5.7
    // use docker-machine Camagru (it has ip address of 192.168.99.100)
    // docker exec -it mysql-db /bin/bash
    // mysql -u root -p
    // in docker mysql run
    // GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

    // recent version of mysql has default plugin as caching_sha-2...
    // therefore must use earlier version or change the default plugin in .env file
    
    // I can use 127.0.0.1 as $DB_DNS if I can open mysql server on this mac.
    $DB_DNS = '192.168.99.100'; //or try 172.17.0.2
    $DB_PORT = '3306';
    $DB_USER = 'root';
    $DB_PASSWORD = 'root';
    $DB_NAME = 'Camagru';
?>
