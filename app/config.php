<?php session_start();

if(!array_key_exists("user", $_SESSION)){
    $_SESSION["user"] = "user";
}

//localhost
$DB_HOST = "postgres_almanac";
$DB_PORT = "5432";
$DB_USER = "postgres";
$DB_PASSWD = "0000";
$DB_NAME = "almanac_events";

$CONNECTION = pg_connect(
    "host=$DB_HOST
    port=$DB_PORT
    dbname=$DB_NAME
    user=$DB_USER
    password=$DB_PASSWD"
);
