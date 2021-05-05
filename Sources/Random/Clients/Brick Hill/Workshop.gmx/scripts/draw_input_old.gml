// draw_input(x,y,str,w,prompt,caption,lock,helptext)
var xx,yy,str,nstr,w,m,prompt,cap,lock,txt;
xx=argument0
yy=argument1
str=argument2
w=argument3
prompt=argument4
cap=argument5
lock=argument6
txt=argument7
nstr=""

draw_set_color(c_white);
draw_rectangle(xx,yy,xx+w,yy+string_height(" "),0);
draw_set_color(0);
draw_rectangle(xx,yy,xx+w,yy+string_height(" "),1);
draw_set_alpha(1-lock/2);
draw_text(xx+4,yy+3,string_limit(str,w-8))
draw_set_alpha(1)

m=mouse_rectangle(xx,yy,w,18)
if (m) {
    helptext=txt
    curs=cr_beam
}
if (m>0 && mouse_check_button_released(mb_left) && !lock) nstr=get_string(prompt,str)
if (nstr!="") {
    nstr=string_replace_all(nstr,"\#","#")
    nstr=string_replace_all(nstr,"#","\#")
    nstr=string_replace_all(nstr,"|","l")
    return nstr
    
}
return str
