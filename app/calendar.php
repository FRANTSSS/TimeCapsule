<?php session_start();
if($_SESSION["user"] === null){
    $_SESSION["user"] = "user";
}
include("config.php");



function get_str_list_settings($result_req, $settings_name, $column_name){
    if(count($result_req[$settings_name]) == 0){
        $settings = "TRUE";
    }
    else{
        $new_result_req = array_map(function($n){
            return "'$n'";
        }, $result_req[$settings_name]);

        $settings = "(" . implode(", ", $new_result_req) . ")";
        $settings = "$column_name IN $settings";
    }
    return $settings;
}

function get_str_list_events_id($list_events){
    $list_events_ids = [];
    foreach($list_events as $event_){
        $list_events_ids[] = "\"dates_events\".\"EventId\" = " . "'{$event_['id']}'";
    }

    if(count($list_events) == 0){
        $str_events = "TRUE";
    }
    else{
        $str_events = "(" . implode(" OR ", $list_events_ids) . ")";
    }

    return $str_events;
}

function get_month_q($year, $month){
    return "'{$year}-{$month}-01'";
}

function main(){
    $result = json_decode(file_get_contents("php://input"), true);

    $str_group = get_str_list_settings($result, "group", '"GroupId"');
    $str_tag = get_str_list_settings($result, "tag", '"tags_events"."TagId"');
    $str_theme = get_str_list_settings($result, "theme", '"ThemeId"');

    $query = "SELECT * 
              FROM \"event\"
              LEFT JOIN \"tags_events\" ON \"event\".\"id\" = \"tags_events\".\"EventId\"
              WHERE $str_theme AND
              $str_group AND
              $str_tag;";

    $response = pg_query($query) or die('Query failed: ' . pg_last_error());
    $resultArray = array();
    while ($row = pg_fetch_array($response, null, PGSQL_ASSOC)) {
        $resultArray[] = $row;
    }
    header("Content-Type: application/json");
    pg_free_result($response);

//    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE );


    $start_m = get_month_q($result["year"], $result["month"]);
    if($result["month"] === 12){
        $end_m = get_month_q($result["year"] + 1, 1);
    }
    else{
        $end_m = get_month_q($result["year"], $result["month"] + 1);
    }
    $events_id_str = get_str_list_events_id($resultArray);

    $query1 = "SELECT * FROM \"dates_events\" WHERE (\"dates_events\".\"date\"
               BETWEEN $start_m AND $end_m) AND
               $events_id_str;";


//   echo $query1;
    $response1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
    $resultArray1 = array();

    while ($row = pg_fetch_array($response1, null, PGSQL_ASSOC)) {
        $resultArray1[] = $row;
    }

    header("Content-Type: application/json");
//    echo json_encode($resultArray1, JSON_UNESCAPED_UNICODE );
    pg_free_result($response1);

    $result_comp = [];
    foreach($resultArray1 as $events_settings){
        foreach($resultArray as $full_events){
            if($events_settings["EventId"] === $full_events["id"]){
                $day_key = explode("-", $events_settings["date"]);
                $day_key = (int)end($day_key);
                $result_comp[$day_key][] = [
                    "id" => $full_events["id"],
                    "name" => $full_events["name"],
                    "description" => $full_events["description"]
                ];
            }
        }
    }
    echo json_encode($result_comp, JSON_UNESCAPED_UNICODE );

}

main();