// draw_ground()
draw_set_color(BasePlateColor);
draw_set_alpha(BasePlateAlpha);
d3d_draw_floor(-BasePlateSize/2,BasePlateSize/2,0,BasePlateSize/2,-BasePlateSize/2,0,stud,BasePlateSize,BasePlateSize);
d3d_light_define_point(1,BasePlateSize/2,BasePlateSize/2,80,SunIntensity,c_white);
d3d_light_define_point(2,-BasePlateSize/2,BasePlateSize/2,80,SunIntensity,c_white);
d3d_light_define_point(3,BasePlateSize/2,-BasePlateSize/2,80,SunIntensity,c_white);
d3d_light_define_point(4,-BasePlateSize/2,-BasePlateSize/2,80,SunIntensity,c_white);
d3d_light_enable(1,true);
d3d_light_enable(2,true);
d3d_light_enable(3,true);
d3d_light_enable(4,true);
