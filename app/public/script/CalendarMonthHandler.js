import {get_up_down_month, MONTHS, replace_day_text, calendar_generate_days, clear_cal_text} from "./GetDateYearUpDown.js";
import {get_events_month, get_group_tag_theme} from "./requests.js"
import {clear_settings, clear_events} from "./clear_doc.js"


btn__search_month_down.addEventListener("click", cal_moth_handler);
btn__search_month_up.addEventListener("click", cal_moth_handler);
btn__search_year_down.addEventListener("click", cal_year_handler);
btn__search_year_up.addEventListener("click", cal_year_handler);
button__apply.addEventListener("click", cal_apply_handler);

function cal_apply_handler(event){
    get_events_month();
    replace_day_text();
    //clear_settings();
    clear_events();

    //get_group_tag_theme();
}


function cal_moth_handler(event){
    // console.log("sdf");

    let current_month = document.getElementById("button_month_text").textContent;
    let up_down_months = get_up_down_month(current_month);
    if(event.target.id === "btn__search_month_down"){
        document.getElementById("button_month_text").textContent = up_down_months["down"];
    }
    else{
        document.getElementById("button_month_text").textContent = up_down_months["up"];
    }
    // console.log(document.getElementsByClassName("button_month_text").textContent);

    //let days = calendar_generate_days()
    replace_day_text();
    //clear_settings();
    clear_events();

    //get_group_tag_theme();
    get_events_month();
}

function cal_year_handler(event){
    let year = parseInt(document.getElementById("button_year_text").textContent)
    if(event.target.id === "btn__search_year_down"){
        document.getElementById("button_year_text").textContent = (year-1).toString();
    }
    else{
        document.getElementById("button_year_text").textContent = (year+1).toString();
    }

    let days = calendar_generate_days()

    replace_day_text();
   // clear_settings();
    clear_events();

    //get_group_tag_theme();
    get_events_month();
}

replace_day_text();
clear_settings();
clear_events();

get_group_tag_theme();
get_events_month();
