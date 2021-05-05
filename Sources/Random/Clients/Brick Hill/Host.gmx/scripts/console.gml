// console(string)
var log_file, message, current_date;
log_file = file_text_open_append(global.APPDATA+"\log.txt");
if log_file {
    current_date = date_current_datetime();
    current_date = string(date_get_year(current_date))+"-"+
                   string(date_get_month(current_date))+"-"+
                   string(date_get_day(current_date))+" "+
                   string(date_get_hour(current_date))+":"+
                   string(date_get_minute(current_date))+":"+
                   string(date_get_second(current_date));
    message = "["+string(current_date)+"] "+argument0;
    file_text_write_string(log_file,message);
    file_text_writeln(log_file);
    file_text_close(log_file);
    print(message);
}
