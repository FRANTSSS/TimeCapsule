
export function clear_settings(){
    let doc = document.getElementsByClassName("page__group_theme_tag__rectangle")
    for(let i= 0; i < doc.length; i++){
        doc[i].innerHTML = ""
    }
}

export function clear_events() {
    let doc = document.getElementsByClassName("cal_day_one__list_events");
    for(let i= 0; i < doc.length; i++){
        doc[i].innerHTML = ""
    }
}

export function clear_events_day() {
    let doc = document.getElementsByClassName("page_text_events__list");
    for(let i = 0; i < doc.length; i++){
        doc[0].innerHTML = "";
    }
}

export function clear_date_day(){
    let month = document.getElementsByClassName("moth__comp__arrows");
    let year = document.getElementsByClassName("year__comp__arrows");
    month[0].innerHTML = "";
    year[0].innerHTML = "";
}