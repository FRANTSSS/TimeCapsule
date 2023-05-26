
export function get_html_event(value){
    return `<li>${value}</li>`;
}

export function get_html_group_tag_theme(value){
    return `<div class="form-check">\n` +
        `<input class="form-check-input" type="checkbox">\n` +
        `<label class="form-check-label">\n` +
        `${value}` +
        `</label>\n` +
        `</div>`;
}

export function get_event_days(tittle, description){
    if(description === null){
        return `<div class="page_text_event__main">
        <div class="page_text__header">${tittle}</div>`;
    }
    else{
        return `<div class="page_text_event__main">
            <div class="page_text__header">${tittle}</div>
            <div class="page_text__description">${description}</div>`;
        }
}
