<?php session_start();
if($_SESSION["user"] !== "admin"){
    var_dump(http_response_code(403));
    return;
}

$admin_panel = include "panel.php";

include("config.php");

function get_events(){
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
    GROUP BY "event".id;
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
        $table_entry .= '<td><a href="event.php?id=' . $tr_values['id'] . '">Редактировать</a>';
        foreach(array_values($tr_values) as $td_value){
            $table_entry .= '<td>' . $td_value . '</td>';
        }
        $table_entry .= sprintf("<td><button class=\"delete_button\" style=\"cursor: pointer;\"id=\"%s\"></button></td></tr>", $tr_values['id']);

        $html_table .= $table_entry;
    }
    return $html_table;
}

$db_response = get_events();
if(count($db_response) === 0){
    $group_table = '';
}
else{
    $group_table = get_table($db_response);
}

//echo json_encode($db_response, JSON_UNESCAPED_UNICODE);
//return;
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
        <button id="add_group" onclick="document.location='./event_add.php'" style="cursor: pointer;">+</button>
    </div>
    <table>
        <?php echo $group_table; ?>
    </table>
    <script type="module">
        import {add_handlers_delete_buttons} from "./public/script/events.js";
        add_handlers_delete_buttons();
    </script>
</div>
</body>
</html>
