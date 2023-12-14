<?php session_start();

if(!array_key_exists("user", $_SESSION)){
    $_SESSION["user"] = "user";
}

include("config.php");

function main()
{
    $query = 'SELECT * FROM "group"';
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    $query1 = 'SELECT * FROM "theme"';
    $result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());

    $query2 = 'SELECT * FROM "tag"';
    $result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());

    $resultArray = array();

    while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
        $resultArray["group"][] = $row;
    }
    while ($row = pg_fetch_array($result1, null, PGSQL_ASSOC)) {
        $resultArray["theme"][] = $row;
    }
    while ($row = pg_fetch_array($result2, null, PGSQL_ASSOC)) {
        $resultArray["tag"][] = $row;
    }

    header("Content-Type: application/json");
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
    pg_free_result($result);
}

main();