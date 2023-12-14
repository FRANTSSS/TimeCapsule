import {render_tag_group_theme} from "./render_html.js"
import {get_html_event, get_event_days} from "./event_template.js"
import {MONTHS} from "./GetDateYearUpDown.js"

export var group_ids = [];
export var theme_ids = [];
export var tag_ids = [];


function create_request(){
    let httpRequest;
    if (window.XMLHttpRequest) {
        httpRequest = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return httpRequest;
}

function view_get_tag_theme(httpRequest) {
    if(httpRequest.readyState === 4) {
        let result = JSON.parse(httpRequest.responseText);
        group_ids = result["group"];
        theme_ids = result["theme"];
        tag_ids = result["tag"];
        render_tag_group_theme(tag_ids, group_ids, theme_ids);
    }
}


function get_checked_settings(id_name, list_ids){
    let checked_settings = [];
    let dom = document.getElementById(id_name)
    for(let i= 0; i < dom.children.length; i++){
        // console.log(dom.children[0]);
        if(dom.children[i].children[0].checked){
            for(let j = 0; j < list_ids.length; j++){
                let text_tag = dom.children[i].children[1].textContent.toString().trim();
                if(list_ids[j]["name"] === text_tag){
                    checked_settings.push(list_ids[j]["id"]);
                }
            }
        }
    }
    return checked_settings;
}

function view_events_month(httpRequest){
    if(httpRequest.readyState === 4){
        let result = JSON.parse(httpRequest.responseText);
        let events_days = Object.keys(result);

        let doc = document.getElementsByClassName("cal__day_one__for_text");
        for(let i= 0; i < doc.length; i++){
            for(let j = 0; j < events_days.length; j++) {
                if (doc[i].children[0].textContent.toString().trim() === events_days[j]) {
                    doc[i].style.cursor = "pointer";
                    let year = document.getElementById("button_year_text").textContent.toString().trim();
                    let month = (Number(MONTHS.indexOf(document.getElementById("button_month_text").textContent.toString().trim()))+1).toString();
                    let month_str = document.getElementById("button_month_text").textContent.toString().trim();
                    let str_href = `'day.php?day=${events_days[j]}&month=${month}-${month_str}&year=${year}'`;
                    doc[i].setAttribute("onclick", `document.location=${str_href}`);
                    console.log(doc[i].children[0]);
                    for(let k = 0; k < events_days[j].length; k++){
                        try {
                            let htm = get_html_event(result[events_days[j]][k]["name"]);
                            doc[i].children[1].innerHTML += htm;
                        }
                        catch (e){}
                    }

                }
            }
        }
    }
}

function get_params_events(){
    let checked_tag = get_checked_settings("page__tag_", tag_ids);
    let checked_theme = get_checked_settings("page__theme_", theme_ids);
    let checked_group = get_checked_settings("page__group_", group_ids);
    let year = Number(document.getElementById("button_year_text").textContent.toString().trim());
    let month = Number(MONTHS.indexOf(document.getElementById("button_month_text").textContent.toString().trim()))+1;

    return {"tag": checked_tag, "theme": checked_theme, group: checked_group, "year": year, "month": month};
}

export function get_group_tag_theme(){
    let httpRequest = create_request();
    httpRequest.onreadystatechange = function() { view_get_tag_theme(httpRequest); };
    httpRequest.open("GET", "/settings.php", true);
    httpRequest.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    httpRequest.send();
}

export function get_events_month(){
    let httpRequest = create_request();

    let params = get_params_events();
    httpRequest.onreadystatechange = function() { view_events_month(httpRequest); };
    httpRequest.open("POST", "/calendar.php", true);
    httpRequest.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    httpRequest.send(JSON.stringify(params));
}

function view_events_day(httpRequest, day){
    if(httpRequest.readyState === 4){
        let result = JSON.parse(httpRequest.responseText);
        let events_list = [];
        console.log(result[day]);
        for(let i = 0; i < result[day].length; i++){
            let htm = get_event_days(result[day][i]["name"], result[day][i]["description"]);
            let doc = document.getElementsByClassName("page_text_events__list");
            doc[0].innerHTML += htm;
            console.log("adf");
        }
    }
}

export function get_events_day(date_list){
    let httpRequest = create_request();
    console.log(date_list);
    let params = {"tag": [], "theme": [], group: [], "year": Number(date_list[2]), "month": Number(date_list[3])};
    httpRequest.onreadystatechange = function() { view_events_day(httpRequest, Number(date_list[0])); };
    httpRequest.open("POST", "/calendar.php", true);
    httpRequest.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    httpRequest.send(JSON.stringify(params));
}
