// in_box(x1,y1,x2,y2)
var x1,y1,x2,y2;
x1 = argument0;
y1 = argument1;
x2 = argument2;
y2 = argument3;
if window_mouse_get_x() >= x1 && window_mouse_get_x() <= x2 {
    if window_mouse_get_y() >= y1 && window_mouse_get_y() <= y2 {
        return true;
    }
}
return false;
