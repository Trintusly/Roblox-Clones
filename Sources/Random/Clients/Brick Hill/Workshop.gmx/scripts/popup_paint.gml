// popup_paint()
var w,h,xx,yy,nextY;
w = 448;
h = 251;
xx = round(popup_x-w/2);
yy = round(popup_y-h/2);

if mouse_check_button_pressed(mb_left) {
    if mouse_x > xx && mouse_x < xx+w && mouse_y > yy && mouse_y < yy+34 {
        popup_drag_last_x = mouse_x;
        popup_drag_last_y = mouse_y;
        popup_drag = true;
    } else if mouse_y > yy+h {
        if window_hover == ""
            popup = false;
    }
}
if popup_drag {
    popup_drag_x = mouse_x;
    popup_drag_y = mouse_y;
    
    popup_x -= popup_drag_last_x-popup_drag_x;
    popup_y -= popup_drag_last_y-popup_drag_y;
    
    popup_drag_last_x = mouse_x;
    popup_drag_last_y = mouse_y;
    draw_set_alpha(0.1);
    var bl;
    for(bl = 0; bl < 4; bl += 1) {
        draw_roundrect(xx-bl,yy-bl,xx+w+bl,yy+h+bl,0);
    }
} else {
    if xx < 0 {
        popup_x = floor(xx/2+w/2);
    } else if xx+w > room_width {
        popup_x = floor((xx+room_width-w)/2+w/2);
    }
    
    if yy < 0 {
        popup_y = floor(yy/2+h/2);
    } else if yy+h > room_height {
        popup_y = floor((yy+room_height-h)/2+h/2);
    }
}
if mouse_check_button_released(mb_left) {
    popup_drag = false;
}
draw_set_alpha(1);
draw_set_color(col_main);
draw_box(xx,yy,xx+w,yy+h,0);
draw_set_color(c_white);
draw_set_font(fnt_bold);
draw_text(xx+10,yy+2,"Colors");
draw_set_color(main_outline);
draw_line(xx,yy+34,xx+w-1,yy+34);

nextY = yy+50;
if draw_color_button2("popup_color_1","",$0d00de,xx+8,nextY,32,32,1) {popup = false; paint_popup_color = $0d00de;}
if draw_color_button2("popup_color_2","",$1b0880,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $1b0880;}
if draw_color_button2("popup_color_3","",$77152c,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $77152c;}
if draw_color_button2("popup_color_4","",$a85700,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $a85700;}
if draw_color_button2("popup_color_5","",$daa300,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $daa300;}
if draw_color_button2("popup_color_6","",$0bb995,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $0bb995;}
if draw_color_button2("popup_color_7","",$287b00,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $287b00;}
if draw_color_button2("popup_color_8","",$0c1c5b,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $0c1c5b;}
if draw_color_button2("popup_color_9","",$4072d6,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $4072d6;}
if draw_color_button2("popup_color_10","",$f4f4f4,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $f4f4f4;}
if draw_color_button2("popup_color_11","",$fdfbd4,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $fdfbd4;}

nextY = next_y+8;
if draw_color_button2("popup_color_12","",$1863e7,xx+8,nextY,32,32,1) {popup = false; paint_popup_color = $1863e7;}
if draw_color_button2("popup_color_13","",$8b37de,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $8b37de;}
if draw_color_button2("popup_color_14","",$b47596,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $b47596;}
if draw_color_button2("popup_color_15","",$eac087,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $eac087;}
if draw_color_button2("popup_color_16","",$d3be00,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $d3be00;}
if draw_color_button2("popup_color_17","",$538382,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $538382;}
if draw_color_button2("popup_color_18","",$249600,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $249600;}
if draw_color_button2("popup_color_19","",$7bbbd9,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $7bbbd9;}
if draw_color_button2("popup_color_20","",$89c1f5,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $89c1f5;}
if draw_color_button2("popup_color_21","",$dae4e4,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $dae4e4;}

nextY = next_y+8;
if draw_color_button2("popup_color_22","",$009bf4,xx+8,nextY,32,32,1) {popup = false; paint_popup_color = $009bf4;}
if draw_color_button2("popup_color_23","",$c39dee,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $c39dee;}
if draw_color_button2("popup_color_24","",$d0a6bc,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $d0a6bc;}
if draw_color_button2("popup_color_25","",$c68c47,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $c68c47;}
if draw_color_button2("popup_color_26","",$8c745e,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $8c745e;}
if draw_color_button2("popup_color_27","",$97e1cc,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $97e1cc;}
if draw_color_button2("popup_color_28","",$65825f,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $65825f;}
if draw_color_button2("popup_color_29","",$52748d,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $52748d;}
next_x += 40;
if draw_color_button2("popup_color_30","",$91929c,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $91929c;}
if draw_color_button2("popup_color_31","",$7e7b76,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $7e7b76;}

nextY = next_y+8;
if draw_color_button2("popup_color_32","",$00c4fe,xx+8,nextY,32,32,1) {popup = false; paint_popup_color = $00c4fe;}
if draw_color_button2("popup_color_33","",$6b009c,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $6b009c;}
if draw_color_button2("popup_color_34","",$922f4c,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $922f4c;}
if draw_color_button2("popup_color_35","",$978267,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $978267;}
if draw_color_button2("popup_color_36","",$dae4c1,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $dae4c1;}
next_x += 40;
if draw_color_button2("popup_color_37","",$479200,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $479200;}
if draw_color_button2("popup_color_38","",$557daa,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $557daa;}
if draw_color_button2("popup_color_39","",$153da8,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $153da8;}
if draw_color_button2("popup_color_40","",$56514c,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $56514c;}
if draw_color_button2("popup_color_41","",$287096,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $287096;}

nextY = next_y+8;
if draw_color_button2("popup_color_42","",$99ffff,xx+8,nextY,32,32,1) {popup = false; paint_popup_color = $99ffff;}
next_x += 80;
if draw_color_button2("popup_color_43","",$412500,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $412500;}
next_x += 80;
if draw_color_button2("popup_color_44","",$2d4a00,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $2d4a00;}
if draw_color_button2("popup_color_45","",$060f30,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $060f30;}
next_x += 40;
if draw_color_button2("popup_color_46","",$000000,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $000000;}
if draw_color_button2("popup_color_47","",$33383f,next_x+8,nextY,32,32,1) {popup = false; paint_popup_color = $33383f;}
