
admin_logout.addEventListener("click", logout_handler);

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


function view_result_logout(httpRequest){
    if(httpRequest.readyState === 4){
        location.replace("./index.php");
    }
}

function logout_handler(){
    let httpRequest = create_request();
    httpRequest.onreadystatechange = function() { view_result_logout(httpRequest); };
    httpRequest.open("GET", "/app/logout.php", true);
    httpRequest.setRequestHeader("Content-Type", "application/json;charset=utf-8");
    httpRequest.send();
}
