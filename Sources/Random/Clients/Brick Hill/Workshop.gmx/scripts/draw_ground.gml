// draw_ground();
draw_set_color(col_ground);
draw_set_alpha(alpha_ground);
d3d_draw_floor(floor(size_base/2),floor(-size_base/2),0,floor(-size_base/2),floor(size_base/2),0,background_get_texture(bkg_stud),size_base,size_base);
if(lighting) {
    d3d_light_define_point(1,size_base/2,size_base/2,80,sun_intensity,c_white);
    d3d_light_define_point(2,-size_base/2,size_base/2,80,sun_intensity,c_white);
    d3d_light_define_point(3,size_base/2,-size_base/2,80,sun_intensity,c_white);
    d3d_light_define_point(4,-size_base/2,-size_base/2,80,sun_intensity,c_white);
    d3d_light_enable(1,true);
    d3d_light_enable(2,true);
    d3d_light_enable(3,true);
    d3d_light_enable(4,true);
}

d3d_set_lighting(false);
draw_set_alpha(1);
draw_set_color(background_color);
d3d_draw_floor(xfrom+512,yfrom+512,zfrom+512,xfrom-512,yfrom-512,zfrom+512,-1,1,1);
d3d_draw_floor(xfrom+512,yfrom-512,zfrom-512,xfrom-512,yfrom+512,zfrom-512,-1,1,1);
d3d_draw_wall(xfrom+512,yfrom-512,zfrom-512,xfrom-512,yfrom-512,zfrom+512,-1,1,1);
d3d_draw_wall(xfrom+512,yfrom+512,zfrom-512,xfrom+512,yfrom-512,zfrom+512,-1,1,1);
d3d_draw_wall(xfrom-512,yfrom+512,zfrom-512,xfrom+512,yfrom+512,zfrom+512,-1,1,1);
d3d_draw_wall(xfrom-512,yfrom-512,zfrom-512,xfrom-512,yfrom+512,zfrom+512,-1,1,1);
d3d_set_lighting(lighting);
