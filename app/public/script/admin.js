
btn_admin_login.addEventListener("click", login_handler);


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

function get_params(){
    let login = document.getElementById("login-input").value.toString().trim();
    let passwd = document.getElementById("password-input").value.toString().trim();
    return {
        "login": login,
        "password": passwd
    };
}

function view_result_auth(httpRequest){
    if(httpRequest.readyState === 4){
        let response = JSON.parse(httpRequest.responseText);
        if(response.authorize === true){
            location.replace("./index.php");
        }
        else{
            alert("Неверный логин или пароль");
        }
    }
}

function login_handler(){
    let httpRequest = create_request();
    let params = get_params();
    if(params.login.length !== 0 && params.password.length !== 0) {
        httpRequest.onreadystatechange = function() { view_result_auth(httpRequest); };
        httpRequest.open("POST", "/app/auth.php", true);
        httpRequest.setRequestHeader("Content-Type", "application/json;charset=utf-8");
        httpRequest.send(JSON.stringify(params));
    }
}
