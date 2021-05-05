// draw_projectile();
draw_set_color(Color);

d3d_transform_set_identity();
d3d_transform_add_rotation_x(xRot);
d3d_transform_add_rotation_y(yRot);
d3d_transform_add_rotation_z(zRot);
d3d_transform_add_translation(xPos,yPos,zPos);

d3d_draw_ellipsoid(-Diameter/2,-Diameter/2,-Diameter/2,Diameter/2,Diameter/2,Diameter/2,-1,1,1,16);

d3d_transform_set_identity();
