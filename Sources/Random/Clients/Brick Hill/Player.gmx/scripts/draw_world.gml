// draw_world()
texture_set_interpolation(true);
d3d_set_hidden(true);
d3d_set_lighting(true);
d3d_set_shading(true);
d3d_set_culling(true);
d3d_set_perspective(true);

d3d_set_projection_ext(CamXPos,CamYPos,CamZPos,CamXTo,CamYTo,CamZTo,0,0,1,FOV,room_width/room_height,0.5,1024);

//frustum_culling_init(CamXPos,CamYPos,CamZPos,CamXTo,CamYTo,CamZTo,0,0,1,FOV,room_width/room_height,0.5,1024);

background_color = SkyColor;
d3d_light_define_ambient(Ambient);

d3d_set_zwriteenable(true)

draw_set_alpha(1); 

draw_ground();

with obj_figure {
    draw_player();
}

with obj_dummy {
    draw_figure();
}

/*
with obj_projectile {
    draw_projectile();
}
*/

if CamDist > 0 {

    if(CamDist > 6) draw_set_alpha(Dist/6);
    else draw_set_alpha(1);

    //draw_player()
     
    with obj_client {draw_player();}
}

draw_snow();

draw_rain();

if (bricksDownloaded) { // Begin drawing bricks, the world is fully downloaded.
    draw_bricks()
}
