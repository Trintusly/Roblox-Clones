// draw_rain()
if(obj_client.Weather == "rain") {
    d3d_set_lighting(false);
    draw_set_color(c_white);
    var rain_x,rain_y,rain_z;
    rain_x = round(CamXPos/20)*20;
    rain_y = round(CamYPos/20)*20;
    rain_z = round(CamZPos/20)*20-(image_index mod 40);
    d3d_draw_wall(rain_x-80,rain_y+40,rain_z-120,rain_x+80,rain_y+40,rain_z+120,background_get_texture(bkg_rain),8,12);
    d3d_draw_wall(rain_x+80,rain_y-40,rain_z-120,rain_x-80,rain_y-40,rain_z+120,background_get_texture(bkg_rain),8,12);
    d3d_draw_wall(rain_x+40,rain_y+80,rain_z-120,rain_x+40,rain_y-80,rain_z+120,background_get_texture(bkg_rain),8,12);
    d3d_draw_wall(rain_x-40,rain_y-80,rain_z-120,rain_x-40,rain_y+80,rain_z+120,background_get_texture(bkg_rain),8,12);
    
    d3d_draw_wall(rain_x-80,rain_y+80,rain_z-120,rain_x+80,rain_y+80,rain_z+120,background_get_texture(bkg_rain),8,12);
    d3d_draw_wall(rain_x+80,rain_y-80,rain_z-120,rain_x-80,rain_y-80,rain_z+120,background_get_texture(bkg_rain),8,12);
    d3d_draw_wall(rain_x+80,rain_y+80,rain_z-120,rain_x+80,rain_y-80,rain_z+120,background_get_texture(bkg_rain),8,12);
    d3d_draw_wall(rain_x-80,rain_y-80,rain_z-120,rain_x-80,rain_y+80,rain_z+120,background_get_texture(bkg_rain),8,12);
    d3d_set_lighting(true);
}
