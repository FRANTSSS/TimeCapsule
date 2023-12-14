
export const MONTHS = [
    "JAN",
    "FEB",
    "MAR",
    "APR",
    "MAY",
    "JUN",
    "JUL",
    "AUG",
    "SEP",
    "OCT",
    "NOV",
    "DEC"
]

export const WEEKS = [
    "Mon",
    "Tue",
    "Wed",
    "Thu",
    "Fri",
    "Sat",
    "Sun"
]

export function get_up_down_month(month_name){
    let index;
    for(let i= 0; i<MONTHS.length; i++){
        if(MONTHS[i] === month_name.trim()){
            index = i;
            break;
        }
    }
    let up = MONTHS[index+1];
    let down = MONTHS[index-1];
    if(index === 0){
        down = MONTHS[MONTHS.length-1]
    }
    if(index === MONTHS.length-1){
        up = MONTHS[0]
    }
    return {"up": up, "down": down};
}

export function calendar_generate_days(){
    let year = document.getElementById("button_year_text").name.toString().trim();
    let month = MONTHS.indexOf(document.getElementById("button_month_text").name.toString().trim());

    const days = [];
    const d = new Date(`${year}-${month}-1`);
    let week = 1;

    while (MONTHS[d.getMonth()] === month) {
        const date = d.getDate();
        const day = d.getDay();

        days.push({
            day: date,
            weekday: d.toLocaleString('en-US', { weekday: 'short' }),
        });

        d.setDate(date + 1);
        week += !day;
    }

    let dayss = [];
    let days_week = [];
    for(let i=0; i < days.length ; i++){
        days_week.push(days[i]);
        if(days[i]["weekday"] === "Sun" || i === days.length-1){
            dayss.push(days_week);
            days_week = [];
        }
    }

    return dayss;

}

export function replace_day_text(){
    clear_cal_text();
    let year = Number(document.getElementById("button_year_text").textContent.toString().trim());
    let month = MONTHS.indexOf(document.getElementById("button_month_text").textContent.toString().trim());
    let week_first_date = new Date(year, month, 1).getDay()-1;
    if(week_first_date === -1) week_first_date = 6;
    const daysInMonth = (year, month) => new Date(year, month, 0).getDate();
    let current_month_len = daysInMonth(year, month+1);

    let day_text= 1;

    let text_day = document.getElementsByClassName("cal__day_one___text")
    for(let i= week_first_date; i < current_month_len + week_first_date; i++){
        try {
            text_day[i].textContent = day_text.toString();
            day_text++;
        }
        catch {}
    }
}

export function clear_cal_text(){
    let text_day = document.getElementsByClassName("cal__day_one___text")
    for(let i= 0; i < 35; i++){
        text_day[i].textContent = ""
    }
}
