// external_edit();
if (page == page_script) {
    var file,program;
    file = file_text_open_write(global.APPDATA+"\script.gml");
    file_text_write_string(file,script_textbox.text);
    file_text_close(file);
    program = get_open_filename("Program|*.exe",script_shortcut);
    script_shortcut = program;
    if file_exists(program) {
        execute_program(program,global.APPDATA+"\script.gml",1);
        file = file_text_open_read(global.APPDATA+"\script.gml");
        script_textbox.text = "";
        while !file_text_eof(file) {
            script_textbox.text += chr(10)+file_text_read_string(file);
            file_text_readln(file);
        }
        file_text_close(file);
        script_textbox.text = string_copy(script_textbox.text,2,string_length(script_textbox.text));
    }
}
