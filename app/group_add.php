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

function get_group(){
    $query = "SELECT id, name FROM \"group\" WHERE id='" . strval($_GET["id"]) . "';";
    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

function get_table($db_response){
    $html_table = '<tr>';
    foreach(array_keys($db_response[0]) as $table_title){
        $html_table .= '<th>' . $table_title . '</th>';
    }
    $html_table .= '</tr>';

    foreach($db_response as $tr_values){
        $table_entry = '<tr>';
        foreach(array_values($tr_values) as $td_value){
            $table_entry .= '<td>' . $td_value . '</td>';
        }
        $table_entry .= '</tr>';

        $html_table .= $table_entry;
    }
    return $html_table;
}

function create_group($name){
    $query = "INSERT INTO \"group\" (name) VALUES ('" . $name . "');";
    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $result = json_decode(file_get_contents("php://input"), true);
    $group_name = $result["name"];
    echo json_encode(create_group($group_name), JSON_UNESCAPED_UNICODE);
    return;
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Almanac Events | Группы | Создать</title>
    <link rel="stylesheet" href="public/groups.css">
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
        Новая группа
    </div>
    <table contenteditable="true">
        <tbody>
        <tr>
            <th>name</th>
        </tr>
        <tr>
            <td>Название новой группы</td>
        </tr>
        </tbody>
    </table>
    <button id="create_group" style="cursor: pointer;">Создать</button>
    <script type="module">
        import {add_handler_create_button} from "./public/script/group_crud_handler.js";
        add_handler_create_button();
    </script>
</div>
</body>
</html>
<!--onclick="document.location='./groups.php'"-->
