// past_history()
if keyboard_check_pressed(vk_anykey) || keyboard_check_released(vk_anykey) || mouse_check_button_pressed(mb_any) || mouse_check_button_released(mb_any) {
    history = true;
    u = false;
    r = false;
    
    var b,brick;
    for(b = 0; b < ds_list_size(global.brickList); b += 1) {
        brick = ds_list_find_value(global.brickList,b);
        if instance_exists(brick) {
            hist_brick_name[b] = brick.name;
            
            if string_pos("vector",window_drag) == 0 {
                hist_brick_x[b] = brick.x;
                hist_brick_y[b] = brick.y;
                hist_brick_z[b] = brick.z;
                hist_brick_xs[b] = brick.xs;
                hist_brick_ys[b] = brick.ys;
                hist_brick_zs[b] = brick.zs;
            }
            
            hist_brick_color[b] = brick.color;
            hist_brick_light[b] = brick.light_color;
            hist_brick_light_range[b] = brick.light_range;
            hist_brick_rotation[b] = brick.rotation;
        }
    }
    hist_brickCount = ds_list_size(global.brickList);
    
    var t,team;
    for(t = 0; t < ds_list_size(global.teamList); t += 1) {
        team = ds_list_find_value(global.teamList,t);
        if instance_exists(team) {
            hist_team_name[t] = team.name;
            hist_team_color[t] = team.color;
        }
    }
    hist_teamCount = ds_list_size(global.teamList);
    
    hist_ground_col = col_ground;
    hist_base_size = size_base;
    hist_ambient_col = col_ambient;
    hist_sky_col = col_sky;
    hist_sun = sun_intensity;
} else {
    history = false;
}
