
// let request_result;
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

function change_theme_id(theme_id){
    let theme_id_element = document.getElementById("theme_id");
    if(theme_id === "not_theme"){
        theme_id_element.innerHTML = "";
    }
    else{
        theme_id_element.innerHTML = theme_id;
    }
}

function load_themes(requests){
    if(requests.readyState === 4) {
        let current_theme_id = get_current_theme_id();
        let themes = JSON.parse(requests.responseText);
        // request_result = themes;
        let checked_t = "";
        if(current_theme_id === ""){
            checked_t = "checked";
        }
        let html_first_button = `<div>
                <input type="radio" id="not_theme" onclick="change_theme_id('not_theme')" name="hren" ${checked_t} />
                <label>Без темы</label>
            </div>`
        let theme_name_column = document.getElementById("theme_name");
        theme_name_column.innerHTML += html_first_button;
        for (let i = 0; i < themes.length; i++) {
            // console.log(themes[i]);
            let checked = "";
            if(current_theme_id === themes[i]["id"]){
                checked = "checked";
            }
            let html_button = `<div>
                <input type="radio" id="${themes[i]["id"]}" onclick="change_theme_id('${themes[i]["id"]}')" name="hren" ${checked} />
                <label>${themes[i]["name"]}</label>
            </div>`
            let theme_name_column = document.getElementById("theme_name");
            theme_name_column.innerHTML += html_button;
        }
    }
}

function get_current_theme_id(){
    let theme_id = document.getElementById("theme_id").textContent;
    return theme_id;
}

function get_all_themes(){
    let requests = create_request();
    requests.onreadystatechange = function() { load_themes(requests); };
    requests.open("GET", "/event.php/get_all_themes", true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send();
}

get_all_themes();


function change_group_id(group_id){
    let group_id_element = document.getElementById("group_id");
    group_id_element.innerHTML = group_id;
}

function load_groups(requests){
    if(requests.readyState === 4) {
        let current_group_id = get_current_group_id();
        let groups = JSON.parse(requests.responseText);
        for (let i = 0; i < groups.length; i++) {
            // console.log(groups[i]);
            let checked = "";
            if(current_group_id === groups[i]["id"]){
                checked = "checked";
            }
            let html_button = `<div>
                <input type="radio" id="${groups[i]["id"]}" onclick="change_group_id('${groups[i]["id"]}')" name="hren1" ${checked} />
                <label>${groups[i]["name"]}</label>
            </div>`
            let group_name_column = document.getElementById("group_name");
            group_name_column.innerHTML += html_button;
        }
    }
}

function get_current_group_id(){
    let group_id = document.getElementById("group_id").textContent;
    return group_id;
}

function get_all_groups(){
    let requests = create_request();
    requests.onreadystatechange = function() { load_groups(requests); };
    requests.open("GET", "/event.php/get_all_groups", true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send();
}

get_all_groups();

// let active_tag_ids = [];

function change_tag_id(){
    let tag_ids_element = document.getElementById("tag_ids");
    let tag_ids = [];
    let tag_names = document.getElementsByName("hren2");
    for(let i= 0; i<tag_names.length; i++){
        if(tag_names[i].checked){
            tag_ids.push(tag_names[i].id);
        }
    }
    tag_ids = "{" + tag_ids.join(",") + "}";
    // console.log(tag_names);
    tag_ids_element.innerHTML = tag_ids;
    // tag_id_element.innerHTML = tag_id;
}

function get_current_tag_ids(){
    let list_ids = document.getElementById("tag_ids").textContent;
    list_ids = list_ids.replace("{", "").replace("}", "");
    list_ids = list_ids.split(",");
    let clean_list_ids = [];
    for(let i=0; i< list_ids.length; i++){
        if(list_ids[i] !== "NULL" && list_ids[i] !== ""){
            clean_list_ids.push(list_ids[i]);
        }
    }

    // console.log(clean_list_ids);
    return clean_list_ids;
}

function load_tags(requests){
    if(requests.readyState === 4) {
        let current_tag_ids = get_current_tag_ids();
        let tags = JSON.parse(requests.responseText);
        for (let i = 0; i < tags.length; i++) {
            // active_tag_ids
            // console.log(tags[i]);
            let checked = "";
            if(current_tag_ids.includes(tags[i]["id"])){

                checked = "checked";
            }
            let html_button = `<div>
                <input type="checkbox" id="${tags[i]["id"]}" onclick="change_tag_id()" name="hren2" ${checked} />
                <label>${tags[i]["name"]}</label>
            </div>`
            let tag_name_column = document.getElementById("tag_names");
            tag_name_column.innerHTML += html_button;
        }
    }
}

function get_all_tags(){
    let requests = create_request();
    requests.onreadystatechange = function() { load_tags(requests); };
    requests.open("GET", "/event.php/get_all_tags", true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send();
}

get_all_tags();

function get_null_params(td_id){
    let null_param;
    if(document.getElementById(td_id).textContent.toString() === ""){
        null_param = null;
    }
    else{
        null_param = document.getElementById(td_id).textContent;
    }
    return null_param;
}
function get_body(){
    return {
        "id": document.getElementById("event_id").textContent,
        "name": document.getElementById("event_name").textContent,
        "description": get_null_params("event_description"),
        "theme_id": get_null_params("theme_id"),
        "group_id": document.getElementById("group_id").textContent,
        "tag_ids": get_current_tag_ids()
    };
}

function get_body_create(){
    return {
        "name": document.getElementById("event_name").textContent,
        "description": get_null_params("event_description"),
        "theme_id": get_null_params("theme_id"),
        "group_id": document.getElementById("group_id").textContent,
        "tag_ids": get_current_tag_ids()
    };
}

function change_event(){
    let params = get_body();
    let requests = create_request();
    requests.open("PUT", "/event.php?id=" + params["id"], true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send(JSON.stringify(params));
}

function add_event(){
    let params = get_body_create();
    let requests = create_request();
    requests.open("POST", "/event_add.php", true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send(JSON.stringify(params));
}

if(document.getElementById("change__event") !== null) {
    change__event.addEventListener("click", function() {
            change_event();
            location.replace("./events.php");
        }
    );
}

if(document.getElementById("create_event") !== null){
    create_event.addEventListener("click", function() {
        add_event();
        location.replace("./events.php");
    })
}
