
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