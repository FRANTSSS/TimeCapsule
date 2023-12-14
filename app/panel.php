<?php session_start();
if(!array_key_exists("user", $_SESSION)){
    $_SESSION["user"] = "user";
}
if($_SESSION["user"] !== "admin"){
    var_dump(http_response_code(403));
}

else{
    return <<<HTML
        <div id="admin_panel">
            <button id="admin_groups" onclick="document.location='./groups.php'" style="cursor: pointer;">Группы</button>
            <button id="admin_themes" onclick="document.location='./themes.php'" style="cursor: pointer;">Темы</button>
            <button id="admin_tags" onclick="document.location='./tags.php'" style="cursor: pointer;">Теги</button>
            <button id="admin_events" onclick="document.location='./events.php'" style="cursor: pointer;">События</button>
            <button id="admin_dates" onclick="document.location='./dates.php'" style="cursor: pointer;">Даты</button>
            <button id="admin_logout" style="margin-left: 2%; cursor: pointer;"" >Выйти</button>
        </div>
        <script type="module" src="./public/script/logout.js"></script>
HTML;
}
