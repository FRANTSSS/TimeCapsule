<?php session_start();
if(!array_key_exists("user", $_SESSION)){
    $_SESSION["user"] = "user";
}
if($_SESSION["user"] !== "admin"){
    var_dump(http_response_code(403));
    return;
}

include("config.php");

function exec_sql_request($query){
    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}


function get_all_events(){
    $query = "SELECT * from \"group\";";
    return exec_sql_request($query);
}

echo json_encode(get_all_events(), JSON_UNESCAPED_UNICODE);
