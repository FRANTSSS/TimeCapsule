<?php session_start();

if(!array_key_exists("user", $_SESSION)){
    $_SESSION["user"] = "user";
}

if($_SESSION["user"] === "admin"){
    $admin_panel = include "panel.php";
}
else{
    $admin_panel = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Almanac Events</title>
    <link rel="stylesheet" href="public/days.css">
    <link rel="shortcut icon" href="public/icon.png">
    <title>Almanac Events</title>
</head>
<body>
<div id="app" class="main">
    <div class="page__panel"><?php echo $admin_panel?></div>
    <div class="page__months_years__main">
        <!--                <form name="search__by_month_year" method="GET" action="index.php">-->
        <div class="moth__comp__arrows">
        </div>
        <!--                </form>-->

        <!--                <form name="search__by_years_year" method="GET" action="index.php">-->
        <div class="year__comp__arrows">
        </div>
        <!--                </form>-->
    </div>

    <div class="page__main_text_almanac_events__">
        <div class="page__text_almanac"> ALMANAC </div>
        <div class="page__text_events"> EVENTS </div>
    </div>

    <div class="page_text_events__list">

    </div>
    <script src="public/script/DayMonthHandler.js" type="module"></script>

</div>
</body>
</html>
