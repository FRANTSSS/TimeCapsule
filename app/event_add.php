<?php session_start();
if(!array_key_exists("user", $_SESSION)){
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

function get_hook_param($param){
    if($param === null){
        $null_param = "NULL";
    }
    else{
        $null_param = "'" . $param . "'";
    }
    return $null_param;
}

function create_event($result){
    $description = get_hook_param($result["description"]);
    $theme_id = get_hook_param($result["theme_id"]);
    $query_event = sprintf("INSERT INTO \"event\" (\"name\", \"description\", \"ThemeId\", \"GroupId\") VALUES ('%s', %s, %s, '%s') RETURNING id;", $result["name"], $description, $theme_id, $result["group_id"]);

    $db_result = [];
    $db_result_add_event = exec_sql_request($query_event);

    $db_result.array_push($db_result_add_event);

    foreach($result["tag_ids"] as $tag_id){
        $query_add_tags = sprintf("INSERT INTO \"tags_events\" (\"TagId\", \"EventId\") VALUES ('%s', '%s');", $tag_id, $db_result_add_event[0]["id"]);
        $db_result_add_tag = exec_sql_request($query_add_tags);
        $db_result.array_push($db_result_add_tag);
    }

    return $db_result;
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $result = json_decode(file_get_contents("php://input"), true);
    echo json_encode(create_event($result), JSON_UNESCAPED_UNICODE);
    return;
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Almanac Events | События | Создать</title>
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
        Новое событие
    </div>
    <table contenteditable="true">
        <tbody>
        <tr>
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
            <td id="event_name">Имя события</td>
            <td id="event_description">Описание</td>
            <td id="theme_id"></td>
            <td id="theme_name"></td>
            <td id="group_id"></td>
            <td id="group_name"></td>
            <td id="tag_ids"></td>
            <td id="tag_names"></td>
        </tr>
        </tbody>
    </table>
    <button id="create_event" style="cursor: pointer;">Создать</button>
    <script type="text/javascript" src="public/script/event_crud_handler.js"></script>
</div>
</body>
</html>
<!--onclick="document.location='./groups.php'"-->
