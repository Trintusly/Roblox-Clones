// mouse_set_world()
mousex = min(view_wview[view_interface]-properties_w,mouse_x);
mousey = max(settings_h,mouse_y);
window_mouse_set(mousex,mousey);
