<?php session_start();
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

function update_group($id, $new_name){
    $query = "UPDATE \"group\" SET name='" . $new_name . "' WHERE id=" . "'$id';";
    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

function delete_group($id){
    $query = "DELETE FROM \"group\" WHERE id='" . $id . "';";
    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $result = json_decode(file_get_contents("php://input"), true);
    echo json_encode(update_group($result["id"], $result["name"]), JSON_UNESCAPED_UNICODE);
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
//    $result = json_decode(file_get_contents("php://input"), true);
    echo json_encode(delete_group($_GET["id"]), JSON_UNESCAPED_UNICODE);
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER["REQUEST_URI"], "add")){

    echo "hren";
    return;
}

$db_response = get_group();


if(count($db_response) === 0){
    $group_table = '';
}
else{
    $group_table = get_table($db_response);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Almanac Events | Группы</title>
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
            Группы
        </div>
        <table contenteditable="true">
            <?php echo $group_table; ?>
        </table>
        <button id="change_group" style="cursor: pointer;">Обновить</button>
        <script type="module">
            import {add_handler_change_button} from "./public/script/group_crud_handler.js";
            add_handler_change_button();
        </script>
    </div>
</body>
</html>
<!--onclick="document.location='./groups.php'"-->