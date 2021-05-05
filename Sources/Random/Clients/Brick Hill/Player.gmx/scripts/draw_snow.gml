// draw_snow()
if(obj_client.Weather == "snow") {
    draw_set_color(c_white);
    d3d_draw_block2(floor(BasePlateSize/2),floor(BasePlateSize/2),0,floor(-BasePlateSize/2),floor(-BasePlateSize/2),1,background_get_texture(bkg_snow),BasePlateSize/100,BasePlateSize/100);
}

if(obj_client.Weather == "snow") {
    d3d_set_lighting(false);
    draw_set_color(c_white);
    var snow_x,snow_y,snow_z;
    snow_x = round(CamXPos/20)*20;
    snow_y = round(CamYPos/20)*20;
    snow_z = round(CamZPos/20)*20-(image_index mod 40);
    d3d_draw_wall(snow_x-80,snow_y+40,snow_z-120,snow_x+80,snow_y+40,snow_z+120,background_get_texture(bkg_snow_drop),8,12);
    d3d_draw_wall(snow_x+80,snow_y-40,snow_z-120,snow_x-80,snow_y-40,snow_z+120,background_get_texture(bkg_snow_drop),8,12);
    d3d_draw_wall(snow_x+40,snow_y+80,snow_z-120,snow_x+40,snow_y-80,snow_z+120,background_get_texture(bkg_snow_drop),8,12);
    d3d_draw_wall(snow_x-40,snow_y-80,snow_z-120,snow_x-40,snow_y+80,snow_z+120,background_get_texture(bkg_snow_drop),8,12);
    
    d3d_draw_wall(snow_x-80,snow_y+80,snow_z-120,snow_x+80,snow_y+80,snow_z+120,background_get_texture(bkg_snow_drop),8,12);
    d3d_draw_wall(snow_x+80,snow_y-80,snow_z-120,snow_x-80,snow_y-80,snow_z+120,background_get_texture(bkg_snow_drop),8,12);
    d3d_draw_wall(snow_x+80,snow_y+80,snow_z-120,snow_x+80,snow_y-80,snow_z+120,background_get_texture(bkg_snow_drop),8,12);
    d3d_draw_wall(snow_x-80,snow_y-80,snow_z-120,snow_x-80,snow_y+80,snow_z+120,background_get_texture(bkg_snow_drop),8,12);
    d3d_set_lighting(true);
}
