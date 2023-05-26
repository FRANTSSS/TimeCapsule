import {get_html_group_tag_theme} from "./event_template.js"

export function render_tag_group_theme(tags_ids, group_ids, theme_ids){
    for(let i = 0; i < tags_ids.length; i++) {
        let htm = get_html_group_tag_theme(tags_ids[i]["name"]);
        let doc = document.getElementById("page__tag_")
        doc.innerHTML += htm;
    }

    for(let i = 0; i < group_ids.length; i++) {
        let htm = get_html_group_tag_theme(group_ids[i]["name"]);
        let doc = document.getElementById("page__group_")
        doc.innerHTML += htm;
    }

    for(let i = 0; i < theme_ids.length; i++) {
        let htm = get_html_group_tag_theme(theme_ids[i]["name"]);
        let doc = document.getElementById("page__theme_")
        doc.innerHTML += htm;
    }
}

export function render_year_month_day_page(date_list){
    let day_month = document.getElementsByClassName("moth__comp__arrows");
    let year = document.getElementsByClassName("year__comp__arrows");
    day_month[0].innerHTML = `<p class="button_month_year_text" id="button_month_text">${date_list[0]} ${date_list[1]}</p>`;
    year[0].innerHTML = `<p class="button_month_year_text" id="button_year_text">${date_list[2]}</p>`;
}