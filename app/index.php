<?php session_start();
if($_SESSION["user"] === null){
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
    <link rel="stylesheet" href="public/style.css">
    <link rel="shortcut icon" href="public/icon.png">
    <title>Almanac Events</title>
</head>
<body>
    <div id="app" class="main">
        <div class="page__header">
<!--            <form name="search__by_search_form" method="GET" action="index.php">-->
<!--                <div class="rectangle_search__main">-->
<!--                    <img class="free-icon-magnifier" src="public/search-glass.png" alt="search">-->
<!--                    <input type="text" class="search__input">-->
<!--                    <button class="button__search" id="btn_search__1">SEARCH</button>-->
<!--                </div>-->
<!--            </form>-->
        </div>
        <div class="page__panel"><?php echo $admin_panel?></div>
<!--        <form name="search__by_month_year">-->
            <div class="page__months_years__main">
<!--                <form name="search__by_month_year" method="GET" action="index.php">-->
                    <div class="moth__comp__arrows">
                        <button class="button__search_moth" id="btn__search_month_down"> < </button>
                        <p class="button_month_year_text" id="button_month_text"> DEC </p>
                        <button type="button" class="button__search_moth" id="btn__search_month_up"> > </button>
                    </div>
<!--                </form>-->

<!--                <form name="search__by_years_year" method="GET" action="index.php">-->
                    <div class="year__comp__arrows">
                        <button class="button__search_moth" id="btn__search_year_down"> < </button>
                        <p class="button_month_year_text"  id="button_year_text"> 2023 </p>
                        <button class="button__search_moth" id="btn__search_year_up"> > </button>
                    </div>
<!--                </form>-->
                    <script src="public/script/CalendarMonthHandler.js" type="module"></script>
            </div>
<!--        </form>-->

        <div class="page__main_text_almanac_events__">
            <div class="page__text_almanac"> ALMANAC </div>
            <div class="page__text_events"> EVENTS </div>
        </div>

        <div class="page__calendar__main">
            <table class="table__calendar">
                <tr class="cal__days_week">
                    <td class="cal__day_wk">
                        <div class="cal__day_week__text">Mon</div>
                    </td>
                    <td class="cal__day_wk">
                        <div class="cal__day_week__text">Tue</div>
                    </td>
                    <td class="cal__day_wk">
                        <div class="cal__day_week__text">Wed</div>
                    </td>
                    <td class="cal__day_wk">
                        <div class="cal__day_week__text">Thu</div>
                    </td>
                    <td class="cal__day_wk">
                        <div class="cal__day_week__text">Fri</div>
                    </td>
                    <td class="cal__day_wk">
                        <div class="cal__day_week__text">Sat</div>
                    </td>
                    <td class="cal__day_wk_extreme">
                        <div class="cal__day_week__text">Sun</div>
                    </td>
                </tr>
                <tr class="cal__days_week">
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal_day_one_extreme">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr class="cal__days_week">
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal_day_one_extreme">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr class="cal__days_week">
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal_day_one_extreme">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr class="cal__days_week">
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal_day_one_extreme">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr class="cal__days_week">
                    <td class="cal__day__one_last">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one_last">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one_last">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one_last">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one_last">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one_last">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                    <td class="cal__day__one_last_extreme">
                        <div class="cal__day_one__for_text">
                            <div class="cal__day_one___text"></div>
                            <ul class="cal_day_one__list_events">
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="page__settings__main">
<!--            <form name="search__by_settings">-->
                <div class="page__settings_group__main">
                    <div class="page__group_theme_tag__text"> Группа </div>
                    <div class="page__group_theme_tag__rectangle" id="page__group_">

                    </div>
                </div>

                <div class="page__settings_theme__main">
                    <div class="page__group_theme_tag__text"> Тема </div>
                    <div class="page__group_theme_tag__rectangle" id="page__theme_">

                    </div>
                </div>

                <div class="page__settings_tag__main">
                    <div class="page__group_theme_tag__text"> Тег </div>
                    <div class="page__group_theme_tag__rectangle" id="page__tag_">

                    </div>
                </div>

                <button id="button__apply"> Применить </button>
<!--            </form>-->
        </div>

    </div>
</body>
</html>
