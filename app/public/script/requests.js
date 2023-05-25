import {render_tag_group_theme} from "./render_html.js"

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


function get_checked_settings(){
    let checked_tag = []
    let dom = document.getElementById("page__tag_")
    for(let i= 0; i < dom.length; i++){
        if(dom[i].children[0].checked){
            console.log("+")
        }
    }
}

function view_events_month(httpRequest){

}

export function get_events_month(){
    let httpRequest = create_request();
    httpRequest.onreadystatechange = function() { view_events_month(httpRequest); };
    httpRequest.open("POST", "http://localhost:8040/app/calendar.php", true);
    httpRequest.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    httpRequest.send(JSON.stringify({"hren": "yes"}));
}

export function get_group_tag_theme(){
    let httpRequest = create_request();
    httpRequest.onreadystatechange = function() { view_get_tag_theme(httpRequest); };
    httpRequest.open("GET", "http://localhost:8040/app/settings.php", true);
    httpRequest.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    httpRequest.send();
}
