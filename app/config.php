<?php

$DB_HOST = "localhost";
$DB_PORT = "5432";
$DB_USER = "postgres";
$DB_PASSWD = "1805";
$DB_NAME = "almanac_events";

$CONNECTION = pg_connect(
    "host=$DB_HOST
    port=$DB_PORT
    dbname=$DB_NAME
    user=$DB_USER
    password=$DB_PASSWD"
);
