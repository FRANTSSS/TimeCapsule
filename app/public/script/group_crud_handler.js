

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


export function add_handlers_buttons(){
    let button_list = document.getElementsByClassName("delete_button");
    for(let i=0; i<button_list.length; i++){
        button_list[i].addEventListener("click", function() {
            if(confirm("Подтвердите удаление")){
                let requests = create_request();
                requests.open("DELETE", "/app/group.php?id=" + button_list[i].id, true);
                requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
                requests.send();
            }
            location.reload();
        });
    }
}

function get_body_groups(){
    let params_group = document.getElementsByTagName("td");
    return {
        "id": params_group[0].textContent,
        "name": params_group[1].textContent
    }
}

function change_groups(){
    let params = get_body_groups();
    let requests = create_request();
    requests.open("PUT", "/app/group.php?id=" + params["id"], true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send(JSON.stringify(params));
}

export function add_handler_change_button(){
    document.getElementById("change_group").addEventListener("click", function(){
        change_groups();
        location.replace("./groups.php");
    });
}


function get_params_create_group(){
    let params_group = document.getElementsByTagName("td");
    return {
        "name": params_group[0].textContent
    }
}

function create_groups(){
    let params = get_params_create_group();
    let requests = create_request();
    requests.open("POST", "/app/group_add.php", true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send(JSON.stringify(params));
}
export function add_handler_create_button(){
    document.getElementById("create_group").addEventListener("click", function(){
        create_groups();
        location.replace("./groups.php");
    })
}
