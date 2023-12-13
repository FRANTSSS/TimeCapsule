<?php session_start();
if($_SESSION["user"] === null){
    $_SESSION["user"] = "user";
}
include("config.php");

function get_admin_list(){
    $query = "SELECT  login, password_hash FROM users";

    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

//function check_input_admin($input_admin, $db_admin){
//
//}

function main(){
    $result = json_decode(file_get_contents("php://input"), true);
//    $_SESSION["user"] = "admin";

    $db_response = get_admin_list();

    $response = [
        "authorize" => false
    ];

    foreach($db_response as $creds){
        if($result["login"] === $creds["login"] && password_verify($result["password"], $creds["password_hash"])){
            $_SESSION["user"] = "admin";
            $response["authorize"] = true;
        }
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE );
//    echo $result;
//    echo json_encode($result, JSON_UNESCAPED_UNICODE );
//    header ('Location: index.php');  // перенаправление на нужную страницу
//    exit();
}
main();

