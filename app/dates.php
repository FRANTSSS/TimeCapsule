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

function get_admin_list(){
    $query = <<<SQL
        SELECT  "date", array_agg("event"."name") as event_list
            FROM "dates_events"
            JOIN "event" ON "dates_events"."EventId" = "event".id
        GROUP BY "dates_events"."date";
SQL;

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
        $table_entry .= '<td><a href="date.php?id=' . $tr_values['date'] . '">Редактировать</a>';
        foreach(array_values($tr_values) as $td_value){
            $table_entry .= '<td>' . $td_value . '</td>';
        }
        $table_entry .= sprintf("<td><button class=\"delete_button\" style=\"cursor: pointer;\"id=\"%s\"></button></td></tr>", $tr_values['date']);

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
    <title>Almanac Events | Даты</title>
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
        Даты
        <button id="add_group" onclick="document.location='./date_add.php'" style="cursor: pointer;">+</button>
    </div>
    <table>
        <?php echo $group_table ?>
    </table>
    <script type="module">
        import {add_handlers_delete_buttons} from "./public/script/dates.js";
        add_handlers_delete_buttons();
    </script>
</div>
</body>
</html>
