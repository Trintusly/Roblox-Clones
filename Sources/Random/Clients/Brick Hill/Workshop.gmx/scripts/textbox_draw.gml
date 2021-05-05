/// textbox_draw(id, x1, y1, x2, y2)

/// Draws a box with editable text at the given position and with the given dimensions.
/// The properties of the textbox are stored in the given obj_textbox instance id.
/// See the textbox_create script for info about the properties.
/// Use draw_set_font() and draw_set_color() to change the appearance of the text.

/// http://www.stuffbydavid.com

{
    var i,xx,yy,w,h;
    var color_normal,color_selected,color_selection,color_marker;
    var changetext,deletetext,inserttext,lineheight,mouseover;
    var realmousepos,realstartpos,realendpos;
    var a,b,c,l,p,ww,hh,str;
    
    i=argument0
    xx=argument1+string_width("    ")
    xx_linenumber=argument1
    yy=argument2
    w=argument3-argument1-string_width("    ")
    h=argument4-argument2
    
    draw_set_color(0);
    draw_set_alpha(0.1);
    draw_rectangle(xx_linenumber,yy,xx,yy+h,0);
    
    // Colors
    color_normal=draw_get_color()
    color_selected=c_white
    color_selection=make_color_rgb(51,153,255)
    color_marker=c_black
    if (i.color_selected>-1) color_selected=i.color_selected
    if (i.color_selection>-1) color_selection=i.color_selection
    
    if (i.last_text!=i.text) {
        str=i.text
        str=string_replace_all(str,chr(13)+chr(10),chr(10))
        str=string_replace_all(str,chr(13),chr(10))
        if (i.max_chars>0) str=string_copy(str,1,i.max_chars)
        if (i.single_line) str=string_replace_all(str,chr(10)," ")
        i.text=str
        str+=chr(10)
        i.lines=0
        while (str!="") {
            i.line[i.lines]=string_copy(str,1,string_pos(chr(10),str)-1)
            i.line_wrap[i.lines]=0
            i.line_single[i.lines]=0
            i.lines+=1
            str=string_delete(str,1,string_pos(chr(10),str))
        }
        changetext=1
    } else changetext=0
    
    deletetext=0
    inserttext=""
    lineheight=string_height(" ")
    mouseover=(mouse_x>=xx && mouse_x<xx+w && mouse_y>=yy && mouse_y<yy+h)
    
    if (textbox_focus=i && !i.read_only) {
        a=string_width(string_replace_all(string_copy(i.line[textbox_select_mouseline],1,textbox_select_mousepos),"#","\#"))
        b=(textbox_select_mouseline-i.start)*lineheight
        if (a>=0 && a<=w && b>=0 && b+lineheight<=h) {
            draw_set_alpha(0.1);
            draw_rectangle(xx_linenumber,yy+b,xx+w,yy+b+lineheight,0);
            draw_set_alpha(1);
        }
    }
    
    if (textbox_focus=i) {
        var keys,key_press,action;
        if (textbox_lastfocus!=i) { // Select all
            textbox_select_endline=i.lines-1 textbox_select_endpos=string_length(i.line[textbox_select_endline])
            if (i.select_on_focus) {textbox_select_startline=0 textbox_select_startpos=0}
            else {textbox_select_startline=textbox_select_endline textbox_select_startpos=textbox_select_endpos}
            textbox_select_mouseline=textbox_select_endline textbox_select_mousepos=textbox_select_endpos
            textbox_select_clickline=0 textbox_select_clickpos=0
        }
        //Automatic key presses
        keys[0]=vk_enter keys[1]=vk_backspace keys[2]=vk_delete keys[3]=ord("V") keys[4]=vk_right keys[5]=vk_left keys[6]=vk_up keys[7]=vk_down keys[8]=vk_tab
        for (k=0 k<9 k+=1) {
            key_press[keys[k]]=0
            if (keyboard_check(keys[k])) {
                if (current_time-textbox_key_delay[k]>30) {
                    key_press[keys[k]]=1
                    textbox_key_delay[k]=current_time+500*keyboard_check_pressed(keys[k]) // 500 msec if first press, otherwise 30
                }
            } else textbox_key_delay[k]=0
        }
        
        if (mouse_check_button_pressed(mb_left) && !keyboard_check(vk_shift)) textbox_focus=-1
        if (!i.read_only && textbox_select=-1) {
            deletetext=key_press[vk_backspace]-key_press[vk_delete] // 0=Do nothing, 1=Erase to left, -1=Erase to right, 2=Delete selected
            inserttext=keyboard_string
        }
        keyboard_string=""
        
        //Controls
        if (!i.single_line) {
            i.start+=mouse_wheel_down()-mouse_wheel_up()  // Mousewheel to scroll
            if (key_press[vk_enter] && !i.read_only) inserttext=chr(10)  // Enter for linebreak
            if (key_press[vk_tab] && !i.read_only) inserttext="    "  // Tab
        }
        if (key_press[vk_right] || key_press[vk_left] || (key_press[vk_up] && textbox_select_mouseline>0) || (key_press[vk_down] && textbox_select_mouseline<i.lines-1)) {  //Arrow keys to move marker
            if (key_press[vk_right] || key_press[vk_left]) {
                textbox_select_mousepos+=(key_press[vk_right]-key_press[vk_left]) // Move marker right or left
                if (textbox_select_mousepos>string_length(i.line[textbox_select_mouseline])) { // Check if beyond end of line
                    if (textbox_select_mouseline<i.lines-1) { // Wrap around to next line
                        textbox_select_mouseline+=1
                        textbox_select_mousepos=0
                    } else textbox_select_mousepos-=1
                }
                if (textbox_select_mousepos<0) {  // Check if before start of line
                    if (textbox_select_mouseline>0) {
                        textbox_select_mouseline-=1
                        textbox_select_mousepos=string_length(i.line[textbox_select_mouseline])
                    } else textbox_select_mousepos+=1
                }
            }
            if (!i.single_line && (key_press[vk_up] || key_press[vk_down])) {  // Move marker up/down
                var currentx,nextx;
                currentx=string_width(string_replace_all(string_copy(i.line[textbox_select_mouseline],1,textbox_select_mousepos),"#","\#"))
                nextx=0
                textbox_select_mouseline+=key_press[vk_down]-key_press[vk_up]
                for (textbox_select_mousepos=0 textbox_select_mousepos<=string_length(i.line[textbox_select_mouseline]) textbox_select_mousepos+=1) { // Find correct position
                    nextx+=string_width(string_replace(string_char_at(i.line[textbox_select_mouseline],textbox_select_mousepos),"#","\#"))
                    if (nextx>currentx) break
                }
            }
            if (!keyboard_check(vk_shift)) {
                textbox_select_clickline=textbox_select_mouseline
                textbox_select_clickpos=textbox_select_mousepos
            }
            textbox_select_startline=textbox_select_mouseline textbox_select_startpos=textbox_select_mousepos
            textbox_select_endline=textbox_select_mouseline textbox_select_endpos=textbox_select_mousepos
            textbox_marker=current_time
        }
        
        action=-1
        if (mouse_check_button_pressed(mb_right) && mouseover && textbox_select=-1) {  //Right-click menu
            if (i.read_only) {
                action=show_menu("Copy|-|Select all",-1)
                if (action=1) action=4
                if (action=0) action=1
            } else action=show_menu("Cut|Copy|Paste|Delete|-|Select all",-1)
        }
        if (keyboard_check(vk_control) && textbox_select=-1) {  // Ctrl commands
            if (!i.read_only && keyboard_check_pressed(ord("X"))) action=0
            if (keyboard_check_pressed(ord("C"))) action=1
            if (!i.read_only && key_press[ord("V")]) action=2
            if (keyboard_check_pressed(ord("A"))) action=4
        }
        switch (action) {
            case 0: case 1: { // Cut/Copy text
                str=""
                if (textbox_select_startline=textbox_select_endline) {  // Get text on single line
                    str=string_copy(i.line[textbox_select_startline],textbox_select_startpos+1,textbox_select_endpos-textbox_select_startpos)
                } else {
                    for (l=textbox_select_startline l<=textbox_select_endline l+=1) {  // Get selected text
                        if (l=textbox_select_startline) str+=string_delete(i.line[l],1,textbox_select_startpos)
                        else if (l=textbox_select_endline) str+=string_copy(i.line[l],1,textbox_select_endpos)
                        else str+=i.line[l]
                        if (l<textbox_select_endline) {
                            if (!i.line_wrap[l+1] && !i.line_single[l]) str+=chr(13)+chr(10);
                        }
                    }
                }
                if (str!="") clipboard_set_text(str)
                if (action=0) deletetext=2
                break
            }
            case 2: { // Paste text
                inserttext=clipboard_get_text()
                inserttext=string_replace_all(inserttext,chr(13)+chr(10),chr(10))
                inserttext=string_replace_all(inserttext,chr(13),chr(10))
                inserttext=string_replace_all(inserttext,chr(9),"    ")
                break
            }
            case 3: { // Delete text
                deletetext=2
                break
            }
            case 4: { // Select all text
                textbox_select_startline=0 textbox_select_startpos=0
                textbox_select_endline=i.lines-1 textbox_select_endpos=string_length(i.line[textbox_select_endline])
                textbox_select_mouseline=textbox_select_endline textbox_select_mousepos=textbox_select_endpos
                textbox_select_clickline=0 textbox_select_clickpos=0
                break
            }
        }
        
        // Filter
        if (i.filter_chars!="" && inserttext!="") {
            str=""
            for (p=1 p<=string_length(inserttext) p+=1) {
                c=string_char_at(inserttext,p)
                str+=string_repeat(c,string_pos(c,i.filter_chars)>0)
            }
            inserttext=str
        }
        
        // Delete
        if ((deletetext!=0 || inserttext!="") && !key_press[vk_tab]) {
            // Get real position in total string for mouse/start/end
            realmousepos=textbox_select_mousepos
            realstartpos=textbox_select_startpos
            realendpos=textbox_select_endpos
            for (l=0 l<textbox_select_mouseline l+=1) realmousepos+=string_length(i.line[l])+(!i.line_wrap[l+1] && !i.line_single[l])
            for (l=0 l<textbox_select_startline l+=1) realstartpos+=string_length(i.line[l])+(!i.line_wrap[l+1] && !i.line_single[l])
            for (l=0 l<textbox_select_endline l+=1) realendpos+=string_length(i.line[l])+(!i.line_wrap[l+1] && !i.line_single[l])
            
            if (textbox_select_startline!=textbox_select_endline || textbox_select_startpos!=textbox_select_endpos) {  //Several characters
                if (textbox_select_startline=textbox_select_endline) {  // Same line, just do string_delete
                    i.line[textbox_select_startline]=string_delete(i.line[textbox_select_startline],textbox_select_startpos+1,textbox_select_endpos-textbox_select_startpos)
                } else {  // Delete all lines between the two points
                    var linestodelete;
                    linestodelete=textbox_select_endline-textbox_select_startline;
                    i.line[textbox_select_startline]=string_copy(i.line[textbox_select_startline],1,textbox_select_startpos)+string_delete(i.line[textbox_select_endline],1,textbox_select_endpos)
                    i.lines-=linestodelete
                    for (l=textbox_select_startline+1 l<i.lines l+=1) {
                        i.line[l]=i.line[l+linestodelete]
                        i.line_wrap[l]=i.line_wrap[l+linestodelete]
                        i.line_single[l]=i.line_single[l+linestodelete]
                    }
                }
                i.text=string_delete(i.text,realstartpos+1,realendpos-realstartpos)
            } else if (deletetext<2) {  // Single character
                if (deletetext=1) {  // Delete to the left (Backspace)
                    if (textbox_select_startpos>0) {  // In middle of line, just do string_delete
                        i.line[textbox_select_startline]=string_delete(i.line[textbox_select_startline],textbox_select_startpos,1)
                        textbox_select_startpos-=1
                        i.text=string_delete(i.text,realstartpos,1)
                    } else if (textbox_select_startline>0) {  // Else, move up
                        textbox_select_startline-=1
                        textbox_select_startpos=string_length(i.line[textbox_select_startline])
                        if (i.line_wrap[textbox_select_startline+1]) {  // If wrapped, delete, otherwise just jump up
                            textbox_select_startpos-=1
                            i.line[textbox_select_startline]=string_copy(i.line[textbox_select_startline],1,textbox_select_startpos)
                        }
                        i.line[textbox_select_startline]=i.line[textbox_select_startline]+i.line[textbox_select_startline+1]
                        i.lines-=1
                        for (l=textbox_select_startline+1 l<i.lines l+=1) {
                            i.line[l]=i.line[l+1]
                            i.line_wrap[l]=i.line_wrap[l+1]
                            i.line_single[l]=i.line_single[l+1]
                        }
                        i.text=string_delete(i.text,realstartpos,1)
                    }
                } else if (deletetext=-1) {  // Delete to right (Delete)
                    if (textbox_select_startpos<string_length(i.line[textbox_select_startline])) {
                        i.line[textbox_select_startline]=string_delete(i.line[textbox_select_startline],textbox_select_startpos+1,1)
                        i.text=string_delete(i.text,realstartpos+1,1)
                    } else if (textbox_select_startline<i.lines-1) {
                        if (i.line_wrap[textbox_select_startline+1]) { 
                            i.line[textbox_select_startline+1]=string_delete(i.line[textbox_select_startline+1],1,1)  // If wrapped, delete below
                        } else {
                            i.line[textbox_select_startline]+=i.line[textbox_select_startline+1]
                            i.lines-=1
                            for (l=textbox_select_startline+1 l<i.lines l+=1) {
                                i.line[l]=i.line[l+1]
                                i.line_wrap[l]=i.line_wrap[l+1]
                                i.line_single[l]=i.line_single[l+1]
                            }
                        }
                        i.text=string_delete(i.text,realstartpos+1,1)
                    }
                }
            }
            textbox_select_clickline=textbox_select_startline textbox_select_clickpos=textbox_select_startpos
            textbox_select_mouseline=textbox_select_startline textbox_select_mousepos=textbox_select_startpos
            textbox_select_endline=textbox_select_startline textbox_select_endpos=textbox_select_startpos
        } else if((deletetext!=0 || inserttext!="") && key_press[vk_tab]) {
            realmousepos=textbox_select_mousepos
            realstartpos=textbox_select_startpos
            realendpos=textbox_select_endpos
            if(!keyboard_check(vk_shift)) {
                // tab to indent
                for (l=textbox_select_startline; l<=textbox_select_endline; l+=1) {
                    i.line[l] = "    "+i.line[l]
                }
            } else {
                // tab to decrease
                for (l=textbox_select_startline; l<=textbox_select_endline; l+=1) {
                    i.line[l] = string_replace(i.line[l],"    ","");
                }
            }
            textbox_select_startpos = 0;
            textbox_select_endpos = string_length(i.line[textbox_select_endline]);
            
            inserttext="";
        }
        
        // Insert text
        if (i.max_chars>0) {  // Check max limit
            var maxlen;
            maxlen=i.max_chars-string_length(i.text);
            if (string_length(inserttext)>maxlen) inserttext=string_copy(inserttext,1,maxlen)
        }
        if (inserttext!="") {
            textbox_marker=current_time
            if (i.single_line) inserttext=string_replace_all(inserttext,chr(10)," ")
            i.text=string_copy(i.text,1,realmousepos)+inserttext+string_delete(i.text,1,realmousepos)
            
            if (string_pos(chr(10),inserttext)>0) {  // Add text with multiple lines (Paste or linebreak)
                inserttext+=chr(10)
                a=i.line[textbox_select_mouseline]
                b=-1
                while (inserttext!="") {  // Parse
                    b+=1
                    str[b]=string_copy(inserttext,1,string_pos(chr(10),inserttext)-1)
                    if (i.replace_char!="") str[b]=string_repeat(i.replace_char,string_length(str[b]))
                    inserttext=string_delete(inserttext,1,string_pos(chr(10),inserttext))
                }
                i.lines+=b
                for (l=i.lines-1 l>=textbox_select_mouseline+b l-=1) {  //Push up
                    i.line[l]=i.line[l-b]
                    i.line_wrap[l]=i.line_wrap[l-b]
                    i.line_single[l]=i.line_single[l-b]
                }
                for (l=0 l<=b l+=1) {  // Insert
                    if (l=0) {
                        i.line[textbox_select_mouseline+l]=string_copy(a,1,textbox_select_mousepos)+str[l]  // First
                        i.line_single[textbox_select_mouseline+l]=false
                    } else if (l=b) {
                        i.line[textbox_select_mouseline+l]=str[l]+string_delete(a,1,textbox_select_mousepos)  // Last
                        i.line_wrap[textbox_select_mouseline+l]=false
                    } else i.line[textbox_select_mouseline+l]=str[l]  // Middle
                }
                textbox_select_mouseline+=b
                textbox_select_mousepos=string_length(str[b])
                inserttext=" "
            } else {  // Simple insert
                if (i.replace_char!="") inserttext=string_repeat(i.replace_char,string_length(inserttext))
                // Apparently, string_insert doesn't support Ã¥,Ã¤,Ã¶,Ã©,Ã¨,Ã­ etc.
                i.line[textbox_select_startline]=string_copy(i.line[textbox_select_startline],1,textbox_select_mousepos)+inserttext+string_delete(i.line[textbox_select_startline],1,textbox_select_mousepos)
                textbox_select_mousepos+=string_length(inserttext)
            }
            textbox_select_clickline=textbox_select_mouseline textbox_select_clickpos=textbox_select_mousepos
            textbox_select_startline=textbox_select_mouseline textbox_select_startpos=textbox_select_mousepos
            textbox_select_endline=textbox_select_mouseline textbox_select_endpos=textbox_select_mousepos
        }
        
        // Move screen if text is edited or marker is moved
        if (inserttext!="" || deletetext!=0 || key_press[vk_left] || key_press[vk_right] || key_press[vk_up] || key_press[vk_down]) {
            if (i.single_line) {
                if (textbox_select_mousepos<i.start) i.start=textbox_select_mousepos  // Move screen left
                if (textbox_select_mousepos>i.start+i.chars-1) i.start=textbox_select_mousepos-i.chars  // Move screen right
            } else {
                if (textbox_select_mouseline<i.start) i.start=textbox_select_mouseline  // Move screen up
                if (textbox_select_mouseline>=i.start+floor(h/lineheight)) i.start=textbox_select_mouseline-floor(h/lineheight)+1  // Move screen down
            }
        }
        
        // Handle selecting
        if (!mouse_check_button(mb_left)) textbox_select=-1
        if (textbox_select=i) {  // Move up/down if dragging outside of box
            textbox_marker=current_time
            if (i.single_line) {
                if (mouse_x<xx) i.start-=1
                if (mouse_x>xx+w) i.start+=1
            } else {
                if (mouse_y<yy) i.start-=1
                if (mouse_y>yy+h) i.start+=1
            }
        }
        if (textbox_click>0) {
            if (textbox_select_mouseline=textbox_select_clickline) {
                textbox_select_startline=textbox_select_mouseline
                textbox_select_endline=textbox_select_mouseline
                if (textbox_select_mousepos>=textbox_select_clickpos) {
                    textbox_select_startpos=textbox_select_clickpos
                    textbox_select_endpos=textbox_select_mousepos
                } else {
                    textbox_select_startpos=textbox_select_mousepos
                    textbox_select_endpos=textbox_select_clickpos
                }
            }
            if (textbox_select_mouseline>textbox_select_clickline) {
                textbox_select_startline=textbox_select_clickline
                textbox_select_startpos=textbox_select_clickpos
                textbox_select_endline=textbox_select_mouseline
                textbox_select_endpos=textbox_select_mousepos
            }
            if (textbox_select_mouseline<textbox_select_clickline) {
                textbox_select_startline=textbox_select_mouseline
                textbox_select_startpos=textbox_select_mousepos
                textbox_select_endline=textbox_select_clickline
                textbox_select_endpos=textbox_select_clickpos
            }
        }
    }
    
    if (i.single_line) {  // Calculate the amount of characters visible
        // Avoid negative start character
        i.start=max(0,i.start)
        // Find minimum position
        ww=0
        for (a=string_length(i.line[0]) a>=0 a-=1) {
            ww+=string_width(string_replace(string_char_at(i.line[0],a),"#","\#"))
            b=a
            if (ww>w) break
        }
        i.start=min(b,i.start)
        // Calculate visible
        ww=0
        i.chars=0
        for (a=i.start+1 a<=string_length(i.line[0]) a+=1) {
            ww+=string_width(string_replace(string_char_at(i.line[0],a),"#","\#"))
            if (ww>w) break
            i.chars+=1
        }
    } else {  // Wordwrapping
        if (changetext || i.last_width!=w || inserttext!="" || deletetext!=0) {  // Detect box width or line length changes.
            for (l=1 l<i.lines l+=1) {  // Move words up?
                ww=string_width(string_replace_all(i.line[l-1],"#","\#"))
                if (!i.line_wrap[l] || ww>w) continue
                if (i.line_single[l-1]) {  // Single-worded line
                    for (p=1 p<=string_length(i.line[l]) p+=1) {  // Try to add remaining letters
                        if (ww+string_width(string_replace_all(string_copy(i.line[l],1,p),"#","\#"))>w) break
                        a=string_char_at(i.line[l],p+1)
                        if (a=" " || a="-") {
                            p+=1
                            i.line_single[l-1]=false
                            break
                        }
                        if (p=string_length(i.line[l]) && !i.line_single[l]) i.line_single[l-1]=false
                    }
                    if (p=1) continue  //Cannot move up
                    a=string_length(i.line[l-1])  // Move markers if affected
                    if (textbox_select_mouseline=l && textbox_select_mousepos<=p) {textbox_select_mouseline-=1 textbox_select_mousepos+=a}
                    if (textbox_select_clickline=l && textbox_select_clickpos<=p) {textbox_select_clickline-=1 textbox_select_clickpos+=a}
                    if (textbox_select_endline=l && textbox_select_endpos<=p) {textbox_select_endline-=1 textbox_select_endpos+=a}
                    if (textbox_select_startline=l && textbox_select_startpos<=p) {textbox_select_startline-=1 textbox_select_startpos+=a}
                    if (textbox_select_mouseline=l) textbox_select_mousepos-=p
                    if (textbox_select_clickline=l) textbox_select_clickpos-=p
                    if (textbox_select_endline=l) textbox_select_endpos-=p
                    if (textbox_select_startline=l) textbox_select_startpos-=p
                    i.line[l-1]+=string_copy(i.line[l],1,p)
                    i.line[l]=string_delete(i.line[l],1,p)
                }
                while (i.line[l]!="") {  // Try to add words
                    p=string_pos(" ",i.line[l])
                    if (p=0) p=string_pos("-",i.line[l])
                    if (p=0) p=string_length(i.line[l])
                    if (ww+string_width(string_replace_all(string_copy(i.line[l],1,p-1),"#","\#"))>w) break
                    a=string_length(i.line[l-1])  // Move markers if affected
                    if (textbox_select_mouseline=l && textbox_select_mousepos<=p) {textbox_select_mouseline-=1 textbox_select_mousepos+=a}
                    if (textbox_select_clickline=l && textbox_select_clickpos<=p) {textbox_select_clickline-=1 textbox_select_clickpos+=a}
                    if (textbox_select_endline=l && textbox_select_endpos<=p) {textbox_select_endline-=1 textbox_select_endpos+=a}
                    if (textbox_select_startline=l && textbox_select_startpos<=p) {textbox_select_startline-=1 textbox_select_startpos+=a}
                    if (textbox_select_mouseline=l) textbox_select_mousepos-=p
                    if (textbox_select_clickline=l) textbox_select_clickpos-=p
                    if (textbox_select_endline=l) textbox_select_endpos-=p
                    if (textbox_select_startline=l) textbox_select_startpos-=p
                    i.line[l-1]+=string_copy(i.line[l],1,p)
                    i.line[l]=string_delete(i.line[l],1,p)
                }
                
                if (i.line[l]="") { // Remove empty line
                    i.lines-=1
                    for (a=l a<i.lines a+=1) {
                        i.line[a]=i.line[a+1]
                        i.line_wrap[a]=i.line_wrap[a+1]
                        i.line_single[a]=i.line_single[a+1]
                        if (textbox_select_mouseline=a+1) textbox_select_mouseline-=1  // Move markers if affected
                        if (textbox_select_clickline=a+1) textbox_select_clickline-=1
                        if (textbox_select_endline=a+1) textbox_select_endline-=1
                        if (textbox_select_startline=a+1) textbox_select_startline-=1
                    }
                    l-=1
                }
            }
            for (l=0 l<i.lines l+=1) {  // Move words down?
                if (string_width(string_replace_all(i.line[l],"#","\#"))>w) {
                    i.line_single[l]=false
                    for (p=string_length(i.line[l]) p>1 p-=1) {  // Look for words
                        a=string_char_at(i.line[l],p)
                        if (a=" " || a="-") {
                            if (string_width(string_replace_all(string_copy(i.line[l],1,p-1),"#","\#"))<w) break
                        }
                    }
                    if (p=1) {  // Single-word line found
                        i.line_single[l]=true
                        for (p=string_length(i.line[l])-1 p>1 p-=1) {
                            if (string_width(string_replace_all(string_copy(i.line[l],1,p),"#","\#"))<w) break
                        }
                    }
                    if (p=0) continue  // Cannot be wrapped            
                    if (l=i.lines-1) a=true
                    else a=!i.line_wrap[l+1]
                    if (a) {  // Create new line for wrapped text
                        for (b=i.lines b>l b-=1) {  // Push
                            i.line[b]=i.line[b-1]
                            i.line_wrap[b]=i.line_wrap[b-1]
                            i.line_single[b]=i.line_single[b-1]
                            if (textbox_select_mouseline=b) textbox_select_mouseline+=1  //Move markers if affected
                            if (textbox_select_clickline=b) textbox_select_clickline+=1
                            if (textbox_select_endline=b) textbox_select_endline+=1
                            if (textbox_select_startline=b) textbox_select_startline+=1
                        }
                        i.lines+=1
                        i.line[l+1]=string_delete(i.line[l],1,p)
                        i.line_wrap[l+1]=true
                        i.line_single[l+1]=false
                    } else {
                        i.line[l+1]=string_delete(i.line[l],1,p)+i.line[l+1]  // Add to existing
                    }
                    // Move markers if affected
                    a=string_length(i.line[l])-p
                    if (textbox_select_mouseline=l+1) textbox_select_mousepos+=a
                    if (textbox_select_clickline=l+1) textbox_select_clickpos+=a
                    if (textbox_select_endline=l+1) textbox_select_endpos+=a
                    if (textbox_select_startline=l+1) textbox_select_startpos+=a
                    if (textbox_select_mouseline=l && textbox_select_mousepos>=p) {textbox_select_mouseline+=1 textbox_select_mousepos-=p}
                    if (textbox_select_clickline=l && textbox_select_clickpos>=p) {textbox_select_clickline+=1 textbox_select_clickpos-=p}
                    if (textbox_select_endline=l && textbox_select_endpos>=p) {textbox_select_endline+=1 textbox_select_endpos-=p}
                    if (textbox_select_startline=l && textbox_select_startpos>=p) {textbox_select_startline+=1 textbox_select_startpos-=p}
                    i.line[l]=string_copy(i.line[l],1,p)
                }
            }
            if (textbox_select_mouseline<i.start) i.start=textbox_select_mouseline  // Move screen up
            if (textbox_select_mouseline>=i.start+floor(h/lineheight)) i.start=textbox_select_mouseline-floor(h/lineheight)+1  // Move screen down
        }
        i.start=max(0,min(i.start,i.lines-floor(h/lineheight)))
    }
    
    //Draw text and selection
    draw_set_halign(fa_left)
    draw_set_valign(fa_top)
    for (l=i.start*!i.single_line l<i.lines l+=1) {
        var ly;
        ly=(l-i.start*!i.single_line)*lineheight;  // Current line y value
        if (ly+lineheight>h) break  // Exit if beyond box
        if ((mouseover && textbox_select=-1) || textbox_select=i) {
            if (l=i.lines-1) hh=h-ly
            else hh=lineheight
            if ((mouse_x>=xx || textbox_select=i) &&
                (mouse_x<xx+w || textbox_select=i) &&
                (mouse_y>=yy+ly || (textbox_select=i && ly=0)) &&
                (mouse_y<yy+ly+hh || (textbox_select=i && (ly+lineheight>h || l=i.lines-1)))) {  // Cursor is inside line
                if (mouse_check_button(mb_left)) {
                    if (i.select_on_focus && textbox_lastfocus!=i) { // Select all
                        textbox_select_startline=0 textbox_select_startpos=0
                        textbox_select_endline=i.lines-1 textbox_select_endpos=string_length(i.line[textbox_select_endline])
                        textbox_select_mouseline=textbox_select_endline textbox_select_mousepos=textbox_select_endpos
                        textbox_select_clickline=0 textbox_select_clickpos=0
                        textbox_marker=current_time
                        textbox_focus=i
                        keyboard_string=""
                        mouse_clear(mb_left)
                    } else {
                        textbox_select=i
                        ww=0
                        for (a=i.start*i.single_line a<string_length(i.line[l]) a+=1) {  // Find character over mouse
                            b=string_width(string_replace(string_char_at(i.line[l],a+1),"#","\#"))
                            ww+=b
                            if (mouse_x<xx+ww-b/2) break
                        }
                        textbox_select_mouseline=l
                        textbox_select_mousepos=a
                        if (mouse_check_button_pressed(mb_left)) {
                            if (textbox_select_clickline=textbox_select_mouseline && textbox_select_clickpos=textbox_select_mousepos) {  // Double click, word select
                                if (current_time-textbox_click<500) {
                                    textbox_select_startline=textbox_select_mouseline textbox_select_startpos=max(1,textbox_select_mousepos-1)
                                    textbox_select_endline=textbox_select_mouseline textbox_select_endpos=max(1,textbox_select_mousepos)
                                    while (1) {  // Look left/up for start position
                                        c=string_char_at(i.line[textbox_select_startline],textbox_select_startpos)
                                        if (c=" " || c="," || c="(" || c=")" || c="[" || c="]" || c="+") break
                                        textbox_select_startpos-=1
                                        if (textbox_select_startpos<=0) {  // Jump up a line if it's a single word
                                            if (textbox_select_startline=0) break
                                            if (!i.line_single[textbox_select_startline-1]) break
                                            textbox_select_startline-=1
                                            textbox_select_startpos=string_length(i.line[textbox_select_startline])
                                        }
                                        if (textbox_select_startpos<=0) break
                                    }
                                    while (1) {  // Look right/down for end position
                                        c=string_char_at(i.line[textbox_select_endline],textbox_select_endpos)
                                        if (c=" " || c="," || c="(" || c=")" || c="[" || c="]" || c="+") break
                                        textbox_select_endpos+=1
                                        if (textbox_select_endpos>=string_length(i.line[textbox_select_endline])) {
                                            if (textbox_select_endline=i.lines-1) break
                                            if (!i.line_single[textbox_select_endline]) break
                                            textbox_select_endline+=1
                                            textbox_select_endpos=0
                                        }
                                        if (textbox_select_endpos>=string_length(i.line[textbox_select_endline])) break
                                    }
                                    textbox_select_mouseline=textbox_select_endline
                                    textbox_select_mousepos=textbox_select_endpos
                                    textbox_click=0
                                    mouse_clear(mb_left)
                                } else {  // Remove selection if clicking after word select
                                    textbox_click=current_time
                                    textbox_select_startline=textbox_select_mouseline textbox_select_startpos=textbox_select_mousepos
                                    textbox_select_endline=textbox_select_mouseline textbox_select_endpos=textbox_select_mousepos
                                }
                            } else {
                                textbox_click=current_time
                                if (!keyboard_check(vk_shift) || textbox_lastfocus!=i) {  // Drag selection if shift is held
                                    textbox_select_startline=textbox_select_mouseline textbox_select_startpos=textbox_select_mousepos
                                    textbox_select_endline=textbox_select_mouseline textbox_select_endpos=textbox_select_mousepos
                                    textbox_select_clickline=textbox_select_mouseline textbox_select_clickpos=textbox_select_mousepos
                                }
                            }
                            textbox_marker=current_time
                            textbox_focus=i
                            keyboard_string=""
                            textbox_lastfocus=i
                        }
                    }
                }
            }
        }
        if (i.single_line) {
            if (textbox_focus=i && textbox_select_startpos!=textbox_select_endpos) {
                for (a=0 a<3 a+=1) str[a]=""
                if (textbox_select_endpos<i.start+1 || textbox_select_startpos>i.start+1+i.chars) str[0]=string_copy(i.line[0],i.start+1,i.chars) // Selection is outside
                else if (textbox_select_startpos<=i.start && textbox_select_endpos>i.start+i.chars) str[1]=string_copy(i.line[0],i.start+1,i.chars) // All visible is selected
                else if (textbox_select_startpos>i.start && textbox_select_endpos<i.start+i.chars) { // Only a part of visible is selected
                    str[0]=string_copy(i.line[0],i.start+1,textbox_select_startpos-i.start)
                    str[1]=string_copy(i.line[0],textbox_select_startpos+1,textbox_select_endpos-textbox_select_startpos)
                    str[2]=string_copy(i.line[0],textbox_select_endpos+1,i.start+i.chars-textbox_select_endpos)
                } else if (textbox_select_startpos<=i.start) { // Beginning is to the left
                    str[1]=string_copy(i.line[0],i.start+1,textbox_select_endpos-i.start)
                    str[2]=string_copy(i.line[0],textbox_select_endpos+1,i.start+i.chars-textbox_select_endpos)
                } else { // Ending is to the right
                    str[0]=string_copy(i.line[0],i.start+1,textbox_select_startpos-i.start)
                    str[1]=string_copy(i.line[0],textbox_select_startpos+1,i.start+i.chars-textbox_select_startpos)
                }
                for (a=0 a<3 a+=1) str[a]=string_replace_all(str[a],"#","\#")
                if (str[0]!="") {  // Text before or outside selection
                    draw_set_color(color_normal)
                    //draw_text(xx,yy,str[0])
                    draw_script(xx,yy,script_encode(str[0]),0)
                }
                if (str[1]!="") {  // Selected text
                    draw_set_color(color_selection)
                    draw_rectangle(min(xx+w,xx+string_width(str[0])),yy,min(xx+w,xx+string_width(str[0]+str[1])),yy+lineheight,0)
                    draw_set_color(color_selected)
                    //draw_text(xx+string_width(str[0]),yy,str[1])
                    draw_script(xx+string_width(str[0]),yy,script_encode(str[1]),1)
                }
                if (str[2]!="") {  // Text after selection
                    draw_set_color(color_normal)
                    //draw_text(xx+string_width(str[0]+str[1]),yy,str[2])
                    draw_script(xx+string_width(str[0]+str[1]),yy,script_encode(str[2]),0)
                }
            } else { // Unselected
                draw_set_color(color_normal)
                //draw_text(xx,yy,string_replace_all(string_copy(i.line[0],i.start+1,i.chars),"#","\#"))
                draw_script(xx,yy,script_encode(string_replace_all(string_copy(i.line[0],i.start+1,i.chars),"#","\#")),0)
            }
        } else {
            if (textbox_focus=i && (textbox_select_startline!=textbox_select_endline || textbox_select_startpos!=textbox_select_endpos)) {  // This line is selected
                for (a=0 a<3 a+=1) str[a]=""
                if (textbox_select_startline=l && textbox_select_endline=l) {  // Same line
                    str[0]=string_copy(i.line[l],1,textbox_select_startpos)
                    str[1]=string_copy(i.line[l],textbox_select_startpos+1,textbox_select_endpos-textbox_select_startpos)
                    str[2]=string_delete(i.line[l],1,textbox_select_endpos)
                } else if (textbox_select_startline=l) {  // Beginning line
                    str[0]=string_copy(i.line[l],1,textbox_select_startpos)
                    str[1]=string_delete(i.line[l],1,textbox_select_startpos)
                } else if (textbox_select_endline=l) {  // Ending line
                    str[1]=string_copy(i.line[l],1,textbox_select_endpos)
                    str[2]=string_delete(i.line[l],1,textbox_select_endpos)
                } else if (textbox_select_startline<l && textbox_select_endline>l) {  // Between
                    str[1]=i.line[l]
                } else {  // Outside
                    str[0]=i.line[l]
                }
                for (a=0 a<3 a+=1) str[a]=string_replace_all(str[a],"#","\#")
                if (str[0]!="") {  // Text before or outside selection
                    draw_set_color(color_normal)
                    //draw_text(xx,yy+ly,str[0])
                    draw_script(xx,yy+ly,script_encode(str[0]),0)
                }
                if (str[1]!="") {  // Selected text
                    draw_set_color(color_selection)
                    draw_rectangle(min(xx+w,xx+string_width(str[0])),yy+ly,min(xx+w,xx+string_width(str[0]+str[1])),yy+ly+lineheight,0)
                    draw_set_color(color_selected)
                    //draw_text(xx+string_width(str[0]),yy+ly,str[1])
                    draw_script(xx+string_width(str[0]),yy+ly,script_encode(str[1]),1)
                }
                if (str[2]!="") {  // Text after selection
                    draw_set_color(color_normal)
                    //draw_text(xx+string_width(str[0]+str[1]),yy+ly,str[2])
                    draw_script(xx+string_width(str[0]+str[1]),yy+ly,script_encode(str[2]),0)
                }
            } else { // Unselected line
                draw_set_color(color_normal)
                //draw_text(xx,yy+ly,string_replace_all(i.line[l],"#","\#"))
                draw_script(xx,yy+ly,script_encode(string_replace_all(i.line[l],"#","\#")),0);
            }
            draw_set_color($8080ff);
            draw_set_alpha(1);
            draw_text(xx_linenumber,yy+ly,l+1)
            draw_text(xx_linenumber+1,yy+ly,l+1)
        }
    }
    
    // Marker
    if (textbox_focus=i && !i.read_only) {
        a=string_width(string_replace_all(string_copy(i.line[textbox_select_mouseline],1,textbox_select_mousepos),"#","\#"))
        b=(textbox_select_mouseline-i.start)*lineheight
        if (i.single_line) {
            a-=string_width(string_replace_all(string_copy(i.line[textbox_select_mouseline],1,i.start),"#","\#"))
            b=0
        }
        if (a>=0 && a<=w && b>=0 && b+lineheight<=h) {
            if ((current_time-textbox_marker) mod 1000<500) {
                draw_set_color(color_marker)
                draw_line(xx+a,yy+b,xx+a,yy+b+lineheight);
                draw_line(xx+a+1,yy+b,xx+a+1,yy+b+lineheight);
            }
        }
    }
    
    if (textbox_focus=i) textbox_lastfocus=i
    else if (textbox_focus=-1) textbox_lastfocus=-1
    
    // Set cursor
    if (mouseover || textbox_select=i) {
        textbox_mouseover=i
        window_hover = "textbox"+string(i);
        window_set_cursor(cr_beam)
    } else if (textbox_mouseover=i) {
        textbox_mouseover=-1
        window_hover = "";
        window_set_cursor(cr_default)
    }
    i.last_text=i.text
    i.last_width=w
    
    //scrollbar_draw(scroll_script,argument3,yy,h,i.lines*string_height(" "));
    
    draw_set_color(color_normal)
    return i.text
}
