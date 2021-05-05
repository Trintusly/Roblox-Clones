// scrollbar_draw(id,x,y,wh,maxwh)
var i,xx,yy,mw,mwh,bwh,bpos,mouseinarea,mouseinbar;
i=argument0
xx=argument1
yy=argument2
wh=argument3
mwh=argument4

if (wh>=mwh || mwh=0) {
    sb_nec[i]=0
    sb_val[i]=0
} else sb_nec[i]=1
sb_atend[i]=(sb_nec[i] && sb_val[i]>=mwh-wh)

if (!sb_nec[i]) return 0

bwh=floor(max(6,(wh/mwh)*wh))
bpos=floor(sb_val[i]*(wh/mwh))

if(!popup) {
    if (sb_dir[i]=0) {
        mouseinarea=mouse_rectangle(xx,yy,wh,14)
        mouseinbar=mouse_rectangle(xx+bpos,yy,bwh,14)
    } else {
        mouseinarea=mouse_rectangle(xx,yy,14,wh)
        mouseinbar=mouse_rectangle(xx,yy+bpos,14,bwh)
    }
    if (mouse_check_button_pressed(mb_left)) {
        if (sb_sel=i && !mouseinarea) sb_sel=-1
        else if (mouseinarea) sb_sel=i
    }
} else {
    mouseinarea = false;
    mouseinbar = false;
}
//Mouse wheel
if (sb_sel=i && sb_drag=-1) sb_val[i]+=(mouse_wheel_down()-mouse_wheel_up())*15

//Drag
if (sb_drag=i) {
    if (!mouse_check_button(mb_left)) {
        sb_drag=-1
        window_drag=""
        mouse_clear(mb_left)
    } else {
        if (sb_dir[i]=0) sb_val[i]+=(mousex-prevx)*(mwh/wh)
        else sb_val[i]+=(mousey-prevy)*(mwh/wh)
    }
}

//Start dragging
if window_hover == "scrollbar"+string(i) {
    if (sb_drag=-1 && mouse_check_button_pressed(mb_left)) {
        meter_sel=""
        window_drag="scrollbar"+string(i)
        sb_drag=i
    }
}
if (mouseinbar) {
    window_hover="scrollbar"+string(i)
} else {
    if(window_hover=="scrollbar"+string(i)) {
        window_hover="";
    }
}

//Click outside bar
if (!mouse_check_button(mb_left)) sb_press[i]=0
if (mouseinarea && !mouseinbar && sb_drag=-1 && window_drag="") {
    if (mouse_check_button(mb_left))  {
        meter_sel=""
        sb_press[i]-=1
        if (sb_press[i]=-1) {
            sb_press[i]=10
            if (sb_dir[i]=0) sb_val[i]+=20-40*(mousex<xx+bpos)
            else sb_val[i]+=50-100*(mousey<yy+bpos)
        } else if (sb_press[i]=0) {
            sb_press[i]=2
            if (sb_dir[i]=0) sb_val[i]+=20-40*(mousex<xx+bpos)
            else sb_val[i]+=50-100*(mousey<yy+bpos)
        }
    }
}
sb_val[i]=round(median(0,sb_val[i],mwh-wh))
bpos=floor(sb_val[i]*(wh/mwh))

if (sb_dir[i]=0) {
    //Bg
    draw_set_color(main_bar);
    draw_sprite_ext(spr_round,0,xx,yy,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,1,xx+wh-sprite_get_width(spr_round),yy,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,2,xx+wh-sprite_get_width(spr_round),yy+12-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,3,xx,yy+12-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    
    draw_rectangle(xx+sprite_get_width(spr_round),yy,xx+wh-sprite_get_width(spr_round),yy+12-1,0);
    draw_rectangle(xx,yy+sprite_get_height(spr_round),xx+wh-1,yy+12-sprite_get_height(spr_round),0);
    
    //Bar
    if(window_drag=="scrollbar"+string(i)) {
        draw_set_color($999999);
    } else if(window_hover=="scrollbar"+string(i)) {
        draw_set_color($bbbbbb);
    } else {
        draw_set_color(c_white);
    }
    draw_set_alpha(1);
    draw_sprite_ext(spr_round,0,xx+bpos,yy,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,1,xx+bpos+bwh-sprite_get_width(spr_round)+1,yy,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,2,xx+bpos+bwh-sprite_get_width(spr_round)+1,yy+12-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,3,xx+bpos,yy+12-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    
    draw_rectangle(xx+bpos+sprite_get_width(spr_round),yy,xx+bpos+bwh-sprite_get_width(spr_round),yy+12-1,0);
    draw_rectangle(xx+bpos,yy+sprite_get_height(spr_round),xx+bpos+bwh,yy+12-sprite_get_height(spr_round),0);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*draw_sprite_ext(spr_round,0,xx,yy+bpos,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,1,xx+12-sprite_get_width(spr_round),yy+bpos,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,2,xx+12-sprite_get_width(spr_round),yy+bpos+bwh-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,3,xx,yy+bpos+bwh-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    
    draw_rectangle(xx+sprite_get_width(spr_round),yy+bpos,xx+12-sprite_get_width(spr_round),yy+bpos+bwh-1,0);
    draw_rectangle(xx,yy+bpos+sprite_get_height(spr_round),xx+12-1,yy+bpos+bwh-sprite_get_height(spr_round)+1,0);*/
} else {
    //Bg
    draw_set_color(main_bar);
    draw_sprite_ext(spr_round,0,xx,yy,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,1,xx+12-sprite_get_width(spr_round),yy,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,2,xx+12-sprite_get_width(spr_round),yy+wh-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,3,xx,yy+wh-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    
    draw_rectangle(xx+sprite_get_width(spr_round),yy,xx+12-sprite_get_width(spr_round),yy+wh-1,0);
    draw_rectangle(xx,yy+sprite_get_height(spr_round),xx+12-1,yy+wh-sprite_get_height(spr_round),0);
    
    //Bar
    if(window_drag=="scrollbar"+string(i)) {
        draw_set_color($999999);
    } else if(window_hover=="scrollbar"+string(i)) {
        draw_set_color($bbbbbb);
    } else {
        draw_set_color(c_white);
    }
    draw_set_alpha(1);
    
    draw_sprite_ext(spr_round,0,xx,yy+bpos,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,1,xx+12-sprite_get_width(spr_round),yy+bpos,1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,2,xx+12-sprite_get_width(spr_round),yy+bpos+bwh-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    draw_sprite_ext(spr_round,3,xx,yy+bpos+bwh-sprite_get_height(spr_round),1,1,0,draw_get_color(),1);
    
    draw_rectangle(xx+sprite_get_width(spr_round),yy+bpos,xx+12-sprite_get_width(spr_round),yy+bpos+bwh-1,0);
    draw_rectangle(xx,yy+bpos+sprite_get_height(spr_round),xx+12-1,yy+bpos+bwh-sprite_get_height(spr_round)+1,0);
}
