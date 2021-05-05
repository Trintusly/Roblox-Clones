// scrollbar_create(direction)
var d;
d=argument0
if (!variable_global_exists("sb_count")) {
    globalvar sb_count,sb_drag,sb_press,sb_sel,sb_nec;
    sb_count=0
    sb_drag=-1
    sb_sel=-1
}
sb_val[sb_count]=0
sb_dir[sb_count]=d
sb_press[sb_count]=0
sb_nec[sb_count]=0
sb_atend[sb_count]=0
sb_count+=1
return sb_count-1
