
let expanded = false;

function showCheckboxes() {
    let checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
}

// <label htmlFor="one"><input type="checkbox" id="one"/>First checkbox</label>

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

function change_date_id(){
    let event_ids_element = document.getElementById("event_ids");
    let event_ids = [];
    let event_names = document.getElementsByName("hren3");
    for(let i= 0; i<event_names.length; i++){
        if(event_names[i].checked){
            event_ids.push(event_names[i].id);
        }
    }
    event_ids = "{" + event_ids.join(",") + "}";
    // console.log(event_names);
    event_ids_element.innerHTML = event_ids;
    // event_id_element.innerHTML = event_id;
}

function get_current_event_ids(){
    let list_ids = document.getElementById("event_ids").textContent;
    list_ids = list_ids.replace("{", "").replace("}", "");
    list_ids = list_ids.split(",");
    return list_ids;
}

function load_events(requests){
    if(requests.readyState === 4) {
        let current_event_ids = get_current_event_ids();
        let events = JSON.parse(requests.responseText);
        for (let i = 0; i < events.length; i++) {
            // active_tag_ids
            // console.log(tags[i]);
            let checked = "";
            if(current_event_ids.includes(events[i]["id"])){
                checked = "checked";
            }
            let html_button = `<label htmlFor="${events[i]["id"]}"><input type="checkbox" name="hren3" id="${events[i]["id"]}" onclick="change_date_id()" ${checked}/>${events[i]["name"]}</label>`
            let tag_name_column = document.getElementById("checkboxes");
            tag_name_column.innerHTML += html_button;
        }
    }
}

function get_all_events(){
    let requests = create_request();
    requests.onreadystatechange = function() { load_events(requests); };
    requests.open("GET", "/date.php/get_all_events", true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send();
}

get_all_events();

function get_body(){
    return {
        "date": document.getElementById("date_event").textContent,
        "event_ids": get_current_event_ids()
    };
}

function change_date(){
    let params = get_body();
    let requests = create_request();
    requests.open("PUT", "/date.php?id=" + params["date"], true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send(JSON.stringify(params));
}


if(document.getElementById("change__date") !== null) {
    change__date.addEventListener("click", function() {
            change_date();
            location.replace("./dates.php");
        }
    );
}


function create_date(){
    let params = get_body();
    let requests = create_request();
    requests.open("POST", "/date.php?id=" + params["date"], true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send(JSON.stringify(params));
}

if(document.getElementById("create__date") !== null) {
    create__date.addEventListener("click", function() {
            create_date();
            location.replace("./dates.php");
        }
    );
}
