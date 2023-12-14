
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

function delete_date(id){
    let requests = create_request();
    requests.open("DELETE", "/date.php?id=" + id, true);
    requests.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    requests.send();
}

export function add_handlers_delete_buttons() {
    let button_list = document.getElementsByClassName("delete_button");
    for (let i = 0; i < button_list.length; i++) {
        button_list[i].addEventListener("click", function () {
            if (confirm("Подтвердите удаление")) {
                delete_date(button_list[i].id);
            }
            location.reload();
        });
    }
}

