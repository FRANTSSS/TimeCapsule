<?php session_start();
if($_SESSION["user"] === null){
    $_SESSION["user"] = "user";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Almanac Events | Adminer</title>
    <link rel="stylesheet" href="public/admin.css">
    <link rel="shortcut icon" href="public/icon.png">
    <title>Almanac Events</title>
</head>
<body>
    <div class="Main__page__admin__login">
        <div class="Page__admin__title">ADMINER</div>
        <div class="Page__login__form">
<!--            form to div  input_line__admin-->
            <div class="input_line__admin">
                <div class="cont__log_label">
                    <h3>login:</h3>
                    <div class="login">
                        <input type="login" id="login-input" placeholder="Введите логин" class="log_pass" required>
                    </div>
                </div>
                <div class="cont__log_label">
                    <h3>password:</h3>
                    <div class="password">
                        <input type="password" id="password-input" placeholder="Введите пароль" class="log_pass" required>
                        <br><label><input type="checkbox" class="password-checkbox"> Показать пароль</label>
                    </div>
                    <script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
                    <script>
                        $('body').on('click', '.password-checkbox', function(){
                            if ($(this).is(':checked')){
                                $('#password-input').attr('type', 'text');
                            } else {
                                $('#password-input').attr('type', 'password');
                            }
                        });
                    </script>
                </div>
                <button class="butt__login" id="btn_admin_login">LOGIN</button>
                <script src="public/script/admin.js" type="module"></script>
            </div>
        </div>
    </div>
</body>
