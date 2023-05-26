import {clear_events_day, clear_date_day} from "./clear_doc.js"
import {get_event_days} from "./event_template.js"
import {render_year_month_day_page} from "./render_html.js"
import {get_events_day} from "./requests.js"

clear_events_day();
clear_date_day();

function get_date_list(){
    let path = window.location.search;
    path = path.split("=");
    let day = path[1].split("&")[0];
    let month = path[2].split("&")[0].split("-")[1];
    let month_count = path[2].split("&")[0].split("-")[0];
    let year = path.pop();

    return [day, month, year, month_count];
}

let date_list = get_date_list();
render_year_month_day_page(date_list);
get_events_day(date_list);

