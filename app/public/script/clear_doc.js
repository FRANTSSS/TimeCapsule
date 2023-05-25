
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