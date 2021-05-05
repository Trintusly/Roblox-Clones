/// textbox_create()

var i;
i=instance_create(0,0,obj_textbox)

// Feel free to change/use these variables after creating the object
i.text=""               // Text in the textbox
i.single_line=0         // If true, the textbox is limited to one line
i.read_only=0           // If true, the textbox contents cannot be changed in any way
i.max_chars=0           // If larger than 0, sets the maximum allowed number of characters
i.filter_chars=""       // If not "", these are the only allowed characters, "0123456789" to only allow digits
i.replace_char=""       // If not "", replaces all characters with this (text variable remains unchanged)
i.select_on_focus=0     // If true, all text will be selected upon focusing the textbox
i.color_selected=-1     // The color of selected text, -1 for default
i.color_selection=-1    // The color of the selection box, -1 for default

i.start=0               // Set the start line (multi-line) or start character (single-line)
i.lines=1               // Access the amount of lines in the textbox (read only)
i.line[0]=""            // Access a specific line from the textbox (read only)

// Don't touch
i.line_wrap[0]=0
i.line_single[0]=0
i.chars=0
i.last_text=""
i.last_width=0

if (instance_number(obj_textbox)=1) {
    globalvar textbox_focus,textbox_lastfocus,textbox_select;
    globalvar textbox_key_delay,textbox_click,textbox_marker,textbox_mouseover;
    globalvar textbox_select_mouseline,textbox_select_mousepos,textbox_select_clickline,textbox_select_clickpos;
    globalvar textbox_select_startline,textbox_select_startpos,textbox_select_endline,textbox_select_endpos;
    textbox_focus=-1        // Holds the ID of the textbox being edited, you can change this during runtime
    textbox_select=-1       // Holds the ID of the textbox whose text is being selected
    textbox_lastfocus=-1
    textbox_click=0
    textbox_marker=0
    textbox_mouseover=-1
    textbox_select_startline=0
    textbox_select_startpos=0
    textbox_select_endline=0
    textbox_select_endpos=0
    textbox_select_mouseline=0
    textbox_select_mousepos=0
    textbox_select_clickline=0
    textbox_select_clickpos=0
}

return i
