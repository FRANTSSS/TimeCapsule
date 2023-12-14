<?php session_start();
if(array_key_exists("user", $_SESSION)){
    $_SESSION["user"] = "user";
}
if($_SESSION["user"] !== "admin"){
    var_dump(http_response_code(403));
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

function get_all_themes(){
    $query = "SELECT * from \"theme\";";
    return exec_sql_request($query);
}

function get_all_groups(){
    $query = "SELECT * from \"group\";";
    return exec_sql_request($query);
}

function get_all_tags(){
    $query = "SELECT * from \"tag\";";
    return exec_sql_request($query);
}

function get_hook_param($param){
    if($param === null){
        $null_param = "NULL";
    }
    else{
        $null_param = "'" . $param . "'";
    }
    return $null_param;
}

function update_event($result){
    $description = get_hook_param($result["description"]);
    $theme_id = get_hook_param($result["theme_id"]);
    $query = <<<SQL
    UPDATE "event" SET 
        "name"='${result["name"]}',
        "description"=${description},
        "ThemeId"=${theme_id},
        "GroupId"='${result["group_id"]}'
    WHERE "id"='${result["id"]}';
SQL;
    $db_result = [];
    $db_result_update_event = exec_sql_request($query);
    $db_result.array_push($db_result_update_event);
//    if()
    $query_delete_tags = "DELETE FROM \"tags_events\" WHERE tags_events.\"EventId\"='" . $result["id"] . "';";
    $db_result2_delete_tag_event = exec_sql_request($query_delete_tags);
    $db_result.array_push($db_result2_delete_tag_event);

    foreach($result["tag_ids"] as $tag_id){
        $query_add_tags = "INSERT INTO \"tags_events\" (\"TagId\", \"EventId\") VALUES ('" . $tag_id ."', '" . $result["id"] . "');";
        $db_result_add_tag = exec_sql_request($query_add_tags);
        $db_result.array_push($db_result_add_tag);
    }

    return $db_result;
}

function delete_event($id){
    $db_result = [];

    $query_dates = "DELETE FROM \"dates_events\" WHERE dates_events.\"EventId\"='" . $id . "';";
    $db_result_dates = exec_sql_request($query_dates);
    $db_result.array_push($db_result_dates);

    $query_tags = "DELETE FROM \"tags_events\" WHERE tags_events.\"EventId\"='" . $id . "';";
    $db_result_tags = exec_sql_request($query_tags);
    $db_result.array_push($db_result_tags);

    $query_events = "DELETE FROM \"event\" WHERE id='" . $id . "';";
    $db_result_event = exec_sql_request($query_events);
    $db_result.array_push($db_result_event);
    return $db_result;
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER["REQUEST_URI"], "get_all_themes")){
    echo json_encode(get_all_themes(), JSON_UNESCAPED_UNICODE);
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER["REQUEST_URI"], "get_all_groups")){
    echo json_encode(get_all_groups(), JSON_UNESCAPED_UNICODE);
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER["REQUEST_URI"], "get_all_tags")){
    echo json_encode(get_all_tags(), JSON_UNESCAPED_UNICODE);
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $result = json_decode(file_get_contents("php://input"), true);
    echo json_encode(update_event($result), JSON_UNESCAPED_UNICODE);
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    echo json_encode(delete_event($_GET["id"]), JSON_UNESCAPED_UNICODE);
    return;
}

function get_event($id){
    $query = <<<SQL
        SELECT "event".id, "event".name, "event".description,
           "event"."ThemeId" as theme_id,
           (array_agg("theme".name))[1] as theme_name,
           "event"."GroupId" as group_id,
           (array_agg("group".name))[1] as group_name,
           array_agg("tag".id) as tag_ids,
           array_agg("tag".name) as tag_names
                from "event"
        LEFT JOIN "theme" ON "event"."ThemeId" = "theme".id
        LEFT JOIN "group" ON "event"."GroupId" = "group".id
        LEFT JOIN "tags_events" ON "event".id = "tags_events"."EventId"
        LEFT JOIN "tag" ON "tag".id = "tags_events"."TagId"
        WHERE "event".id = '$id'
        GROUP BY "event".id;
SQL;
    return exec_sql_request($query);
}

$db_response = get_event($_GET["id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Almanac Events | События</title>
    <link rel="stylesheet" href="public/events.css">
    <link rel="shortcut icon" href="public/icon.png">
</head>
<body>
    <div id="app" class="main">
        <div class="page__panel"><?php echo $admin_panel?></div>
        <div class="page__main_text_almanac_events__">
            <div class="page__text_almanac"> ALMANAC EVENTS</div>
        </div>
        <div id="tittle_groups_page">
            События
        </div>
        <table contenteditable="true">
            <tbody>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>description</th>
                <th>theme_id</th>
                <th>theme_name</th>
                <th>group_id</th>
                <th>group_name</th>
                <th>tag_ids</th>
                <th>tag_names</th>
            </tr>
            <tr>
                <td id="event_id"><?php echo $db_response[0]["id"]?></td>
                <td id="event_name"><?php echo $db_response[0]["name"]?></td>
                <td id="event_description">
                    <?php echo $db_response[0]["description"]?>
                </td>
                <td id="theme_id"><?php echo $db_response[0]["theme_id"]?></td>
                <td id="theme_name"></td>
                <td id="group_id"><?php echo $db_response[0]["group_id"]?></td>
                <td id="group_name"></td>
                <td id="tag_ids"><?php echo $db_response[0]["tag_ids"]?></td>
                <td id="tag_names"></td>
            </tr>
            </tbody>
        </table>

        <button id="change__event" style="cursor: pointer;">Обновить</button>
        <script type="text/javascript" src="public/script/event_crud_handler.js"></script>

<!--        <script type="module">-->
<!--            import {add_handler_change_button} from "./public/script/group_crud_handler.js";-->
<!--            add_handler_change_button();-->
<!--        </script>-->
    </div>
</body>
</html>
<!--onclick="document.location='./groups.php'"-->