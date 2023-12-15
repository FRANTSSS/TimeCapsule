<?php session_start();
if(!array_key_exists("user", $_SESSION)){
    $_SESSION["user"] = "user";
}
if($_SESSION["user"] !== "admin"){
    var_dump(http_response_code(403));
    include("err403.html");
    return;
}

$admin_panel = include "panel.php";

include("config.php");


function exec_sql_request($query){
    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

//function get_all_events(){
//    $query = <<<SQL
//        SELECT "id", "name" FROM "event";
//SQL;
//    return exec_sql_request($query);
//}
//
//function update_date($result){
//    $db_result = [];
//
//    $query_delete = sprintf("DELETE FROM \"dates_events\" WHERE \"dates_events\".date = '%s';", $result["date"]);
//    $db_result_delete_event = exec_sql_request($query_delete);
//    $db_result.array_push($db_result_delete_event);
//
//    foreach($result["event_ids"] as $event_id){
//        $query_add = sprintf("INSERT INTO \"dates_events\" (\"EventId\", \"date\") VALUES ('%s', '%s');", $event_id, $result["date"]);
//        $db_result_add_event = exec_sql_request($query_add);
//        $db_result . array_push($db_result_add_event);
//    }
//    return $db_result;
//}
//
//function delete_date($date){
//    $query = "DELETE FROM \"dates_events\" WHERE \"dates_events\".date = '" . $date ."';";
//    $db_result = exec_sql_request($query);
//    return $db_result;
//}

//if($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER["REQUEST_URI"], "get_all_events")){
//    echo json_encode(get_all_events(), JSON_UNESCAPED_UNICODE);
//    return;
//}
//
//if($_SERVER['REQUEST_METHOD'] === 'PUT'){
//    $result = json_decode(file_get_contents("php://input"), true);
//    echo json_encode(update_date($result), JSON_UNESCAPED_UNICODE);
//    return;
//}
//
//if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
//    echo json_encode(delete_date($_GET["id"]), JSON_UNESCAPED_UNICODE);
//    return;
//}

//function get_date($id){
//    $query = <<<SQL
//        SELECT  "date" as date_event,
//            array_agg("event"."id") as event_ids,
//            array_agg("event"."name") as event_list
//        FROM "dates_events"
//            JOIN "event" ON "dates_events"."EventId" = "event".id
//            WHERE "dates_events".date = '${id}'
//        GROUP BY "dates_events"."date";
//SQL;
//    return exec_sql_request($query);
//}
//
//$db_response = get_date($_GET["id"]);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Almanac Events | Даты | Создать</title>
    <link rel="stylesheet" href="public/dates.css">
    <link rel="shortcut icon" href="public/icon.png">
</head>
<body>
<div id="app" class="main">
    <div class="page__panel"><?php echo $admin_panel?></div>
    <div class="page__main_text_almanac_events__">
        <div class="page__text_almanac"> ALMANAC </div>
        <div class="page__text_events"> EVENTS </div>
    </div>
    <div id="tittle_groups_page">
        Даты
    </div>
    <table contenteditable="true">
        <tbody>
        <tr>
            <th>date</th>
            <th>event_ids</th>
            <th>event_list</th>
        </tr>
        <tr>
            <td id="date_event"><?php echo date('Y-m-d')?></td>
            <td id="event_ids"></td>
            <td id="event_list"><div class="multiselect">
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select>
                            <option>Создать событие</option>
                        </select>
                        <div class="overSelect"></div>
                    </div>
                    <div id="checkboxes">
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <button id="create__date" style="cursor: pointer;">Создать</button>
    <script type="text/javascript" src="public/script/date_crud_handler.js"></script>
</div>
</body>
</html>
<!--onclick="document.location='./groups.php'"-->