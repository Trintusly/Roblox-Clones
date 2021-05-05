// history_check()
//if keyboard_check_pressed(vk_anykey) || keyboard_check_released(vk_anykey) || mouse_check_button_pressed(mb_any) || mouse_check_button_released(mb_any) {
if history {
    if u {return 0;}
    //CHANGE BRICK PoSITION & SIZE SO LONG AS THEY'RE NOT DRAGGING A VECTOR ;););)
    
    if ds_list_size(global.brickList) < hist_brickCount {return 0;}
    if ds_list_size(global.teamList) < hist_teamCount {return 0;}
    //if ds_list_size(global.slotList) < hist_brickCount {return 0;}
    
    var b,brick;
    for(b = 0; b < hist_brickCount; b += 1) {
        brick = ds_list_find_value(global.brickList,b);
        if !instance_exists(brick) {continue;}
        if hist_brick_name[b] != brick.name
            history_add("brick name",string(brick)+" "+string(hist_brick_name[b]));
        
        
        if string_pos("vector",window_drag) == 0 {
            if hist_brick_x[b] != brick.x || hist_brick_y[b] != brick.y ||hist_brick_z[b] != brick.z {
                history_add("brick pos",string(brick)+" "+string(hist_brick_x[b])+" "+string(hist_brick_y[b])+" "+string(hist_brick_z[b]));
            }
            
            if hist_brick_xs[b] != brick.xs || hist_brick_ys[b] != brick.ys || hist_brick_zs[b] != brick.zs {
                history_add("brick size",string(brick)+" "+string(hist_brick_xs[b])+" "+string(hist_brick_ys[b])+" "+string(hist_brick_zs[b])+" "+string(hist_brick_x[b])+" "+string(hist_brick_y[b])+" "+string(hist_brick_z[b]));
            }
        }
        
        
        if hist_brick_color[b] != brick.color
            history_add("brick color",string(brick)+" "+string(hist_brick_color[b]));
        
        if hist_brick_light[b] != brick.light_color
            history_add("brick light",string(brick)+" "+string(hist_brick_light[b]));
        
        if hist_brick_light_range[b] != brick.light_range
            history_add("brick light range",string(brick)+" "+string(hist_brick_light_range[b]));
        
        if hist_brick_rotation[b] != brick.rotation
            history_add("brick rotation",string(brick)+" "+string(hist_brick_rotation[b]));
    }
    
    var t,team;
    for(t = 0; t < hist_teamCount; t += 1) {
        team = ds_list_find_value(global.teamList,t);
        if !instance_exists(team) {continue;}
        if hist_team_name[t] != team.name {
            history_add("team name",string(team)+" "+string(hist_team_name[t]));
        }
        if hist_team_color[t] != team.color
            history_add("team color",string(team)+" "+string(hist_team_color[t]));
    }
    
    if hist_ground_col != col_ground
        history_add("ground_color",hist_ground_col);
    
    if hist_base_size != size_base
        history_add("ground_size",hist_base_size);
    
    if hist_ambient_col != col_ambient
        history_add("ambient",hist_ambient_col);
    
    if hist_sky_col != col_sky
        history_add("sky_color",hist_sky_col);
    
    if hist_sun != sun_intensity
        history_add("sun_intensity",hist_sun);
}
