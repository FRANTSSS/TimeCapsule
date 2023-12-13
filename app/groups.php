<?php session_start();
if($_SESSION["user"] !== "admin"){
    var_dump(http_response_code(403));
    return;
}

$admin_panel = include "panel.php";

include("config.php");

function get_admin_list(){
    $query = 'SELECT  id, name FROM "group"';

    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    return $resultArray;
}

function get_table($db_response){
    $html_table = '<tr><th>Изменить</th>';
    foreach(array_keys($db_response[0]) as $table_title){
        $html_table .= '<th>' . $table_title . '</th>';
    }
    $html_table .= '</tr>';

    foreach($db_response as $tr_values){
        $table_entry = '<tr>';
        $table_entry .= '<td><a href="group.php?id=' . $tr_values['id'] . '">Редактировать</a>';
        foreach(array_values($tr_values) as $td_value){
            $table_entry .= '<td>' . $td_value . '</td>';
        }
        $table_entry .= sprintf("<td><button class=\"delete_button\" style=\"cursor: pointer;\"id=\"%s\"></button></td></tr>", $tr_values['id']);

        $html_table .= $table_entry;
    }
    return $html_table;
}

$db_response = get_admin_list();
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
            <button id="add_group" onclick="document.location='./group_add.php'" style="cursor: pointer;">+</button>
        </div>
        <table>
            <?php echo $group_table ?>
        </table>
        <script type="module">
            import {add_handlers_buttons} from "./public/script/group_crud_handler.js";
            add_handlers_buttons();
        </script>
    </div>
</body>
</html>
