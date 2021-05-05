// draw_brick(brick_id)
var brick;
brick = argument0;
if(brick.isVisible) {
draw_set_color(brick.color);

brickRotX = brick.xs;
brickRotY = brick.ys;
brickPosX = brick.x;
brickPosY = brick.y;
if brick.rotation mod 180 != 0 {
brick.xs = brickRotY;
brick.ys = brickRotX;
brick.x = brickPosX-(brick.xs/2-brick.ys/2);
brick.y = brickPosY-(brick.ys/2-brick.xs/2);
}

draw_set_alpha(brick.alpha);
d3d_transform_set_identity();
d3d_transform_add_translation(-brick.xs/2,-brick.ys/2,0);
d3d_transform_add_rotation_z(brick.rotation);
d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z);

switch brick.shape {
    case "":
        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),brick.xs,brick.ys);
        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
        d3d_draw_wall(0,0,0,brick.xs,0,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(0,brick.ys,0,0,0,brick.zs,-1,1,1);
        break;
    case "slope":
        d3d_draw_floor(brick.xs-1,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),1,brick.ys);
        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
        d3d_draw_floor(brick.xs-1,0,brick.zs,0,brick.ys,0.3,background_get_texture(bkg_slope),brick.xs-1,brick.ys); //slope
        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,brick.zs,-1,1,1); //back
        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,0.3,-1,1,1); //left base
        d3d_draw_wall(brick.xs,brick.ys,0,brick.xs-1,brick.ys,brick.zs,-1,1,1); //left
        d3d_draw_wall(0,brick.ys,0,0,0,0.3,-1,1,1); //font
        d3d_draw_wall(0,0,0,brick.xs,0,0.3,-1,1,1); //right base
        d3d_draw_wall(brick.xs-1,0,0,brick.xs,0,brick.zs,-1,1,1); //right
        d3d_primitive_begin(pr_trianglelist);
        d3d_vertex_texture_color(brick.xs-1, 0, brick.zs,0,0,brick.color,brick.alpha);
        d3d_vertex_texture_color(0, 0, 0.3, 0, 0,brick.color,brick.alpha);
        d3d_vertex_texture_color(brick.xs-1, 0, 0.3, 0, 0,brick.color,brick.alpha);
        d3d_primitive_end();
        d3d_primitive_begin(pr_trianglelist);
        d3d_vertex_texture_color(brick.xs-1, brick.ys, 0.3,0,0,brick.color,brick.alpha);
        d3d_vertex_texture_color(0, brick.ys, 0.3, 0, 0,brick.color,brick.alpha);
        d3d_vertex_texture_color(brick.xs-1, brick.ys, brick.zs, 0, 0,brick.color,brick.alpha);
        d3d_primitive_end();
        break;
    case "plate":
        brick.zs = 0.3
        d3d_draw_floor(0,brick.ys,0.3,brick.xs,0,0.3,background_get_texture(bkg_stud),brick.xs,brick.ys);
        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
        d3d_draw_wall(0,0,0,brick.xs,0,0.3,-1,1,1);
        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,0.3,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,0.3,-1,1,1);
        d3d_draw_wall(0,brick.ys,0,0,0,0.3,-1,1,1);
        break;
    case "wedge":
        if brick.rotation mod 180 == 0 {
            brick.xs = max(brick.xs,2);
        } else {
            brick.ys = max(brick.ys,2);
        }
        d3d_draw_floor(0,brick.ys,brick.zs,1,0,brick.zs,background_get_texture(bkg_stud),1,brick.ys);
        d3d_draw_floor(0,0,0,1,brick.ys,0,background_get_texture(bkg_understud),1,brick.ys);
        d3d_draw_wall(0,0,0,1,0,brick.zs,-1,1,1);
        d3d_draw_wall(1,0,0,brick.xs,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(0,brick.ys,0,0,0,brick.zs,-1,1,1);
        
        d3d_primitive_end();
        d3d_primitive_begin(pr_trianglelist);
        d3d_vertex_texture_color(1,0,0,0,0,brick.color,brick.alpha);
        d3d_vertex_texture_color(1,brick.ys,0,0,0,brick.color,brick.alpha);
        d3d_vertex_texture_color(brick.xs,brick.ys,0,0,0,brick.color,brick.alpha);
        d3d_primitive_end();
        
        d3d_primitive_end();
        d3d_primitive_begin(pr_trianglelist);
        d3d_vertex_texture_color(brick.xs,brick.ys,brick.zs,0,0,brick.color,brick.alpha);
        d3d_vertex_texture_color(1,brick.ys,brick.zs,0,0,brick.color,brick.alpha);
        d3d_vertex_texture_color(1,0,brick.zs,0,0,brick.color,brick.alpha);
        d3d_primitive_end();
        
        var brickBy,brickY,brickX,i,iCount;
        brickBy = hcf(brick.xs,brick.ys);
        brickY = brick.ys/brickBy;
        brickX = brick.xs/brickBy;
        iCount = min(brick.xs/brickX,brick.ys/brickY)-1;
        for(i=0;i<=iCount;i+=1) {
            d3d_draw_floor(brick.xs-(i+1)*brickX,(iCount-i)*brickY,brick.zs,0,(iCount-i+1)*brickY,brick.zs,background_get_texture(bkg_stud),brick.xs-(i+1)*brickX,brickY);
        }
        break;
    case "spawnpoint":
        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_spawnpoint),1,1);
        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
        d3d_draw_wall(0,0,0,brick.xs,0,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(0,brick.ys,0,0,0,brick.zs,-1,1,1);
        break;
    case "arch":
        brick.ys = max(brick.ys,3);
        /*if brick.rotation mod 180 == 0 {
            draw_set_color(c_green);
            brick.ys = max(brick.ys,3);
        } else {
            draw_set_color(c_blue);
            brick.xs = max(brick.xs,3);
        }*/
        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),brick.xs,brick.ys);
        d3d_draw_floor(0,0,0,brick.xs,1,0,background_get_texture(bkg_understud),brick.xs,1);
        d3d_draw_floor(0,brick.ys-1,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,1);
        
        d3d_draw_wall(0,0,0,brick.xs,0,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
        
        d3d_draw_wall(brick.xs,1,0,0,1,0.3,-1,1,1);
        d3d_draw_wall(0,brick.ys-1,0,brick.xs,brick.ys-1,0.3,-1,1,1);
        
        d3d_draw_wall(0,1,0,0,0,brick.zs,-1,1,1);
        d3d_draw_wall(0,brick.ys,0,0,brick.ys-1,brick.zs,-1,1,1);
        
        d3d_draw_wall(brick.xs,0,0,brick.xs,1,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys-1,0,brick.xs,brick.ys,brick.zs,-1,1,1);
        
        d3d_draw_wall(0,brick.ys,brick.zs-0.3,0,0,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,0,brick.zs-0.3,brick.xs,brick.ys,brick.zs,-1,1,1);
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_scaling(brick.xs/2,(brick.ys-2)/2,(brick.zs-0.6)/2);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+0.3);
        d3d_model_draw(Arch,0,1,0,-1);
        break;
    case "corner": //WIP
        brick.xs = max(brick.xs,2);
        brick.ys = max(brick.ys,2);
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_scaling((brick.xs-1)/2,(brick.ys-1)/2,brick.zs/2);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_translation(brick.x+(brick.xs+1)/2,brick.y+(brick.ys+1)/2,brick.z+brick.zs/2);
        d3d_model_draw(Corner,0,0,0,-1);
        break;
    case "corner_inv":
        brick.xs = max(brick.xs,2);
        brick.ys = max(brick.ys,2);
        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),brick.xs,brick.ys);
        d3d_draw_floor(0,0,0,1,1,0,background_get_texture(bkg_understud),1,1);
        
        d3d_draw_wall(brick.xs,0,brick.zs-0.3,brick.xs,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys,brick.zs-0.3,0,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(1,0,brick.zs-0.3,brick.xs,0,brick.zs,-1,1,1);
        d3d_draw_wall(0,brick.ys,brick.zs-0.3,0,1,brick.zs,-1,1,1);
        d3d_draw_wall(0,0,0,1,0,brick.zs,-1,1,1);
        d3d_draw_wall(0,1,0,0,0,brick.zs,-1,1,1);
        
        d3d_primitive_begin(pr_trianglelist);
        d3d_vertex_texture_color(1, 0, brick.zs-0.3, 0, 0,brick.color,brick.alpha);
        d3d_vertex_texture_color(1, 0, 0, 0, 0,brick.color,brick.alpha);
        d3d_vertex_texture_color(brick.xs, 0, brick.zs-0.3,0,0,brick.color,brick.alpha);
        d3d_primitive_end();
        
        d3d_primitive_begin(pr_trianglelist);
        d3d_vertex_texture_color(0, brick.ys, brick.zs-0.3,0,0,brick.color,brick.alpha);
        d3d_vertex_texture_color(0, 1, 0, 0, 0,brick.color,brick.alpha);
        d3d_vertex_texture_color(0, 1, brick.zs-0.3, 0, 0,brick.color,brick.alpha);
        d3d_primitive_end();
        
        d3d_draw_floor(1,0,0,brick.xs,1,brick.zs-0.3,-1,1,1);
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_z(brick.rotation+90);
        d3d_transform_add_translation(brick.x,brick.y+brick.ys,brick.z);
        d3d_draw_floor(0,0,brick.zs-0.3,brick.ys-1,1,0,-1,1,1);
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_scaling((brick.xs-1)/2,(brick.ys-1)/2,(brick.zs-0.3)/2);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_translation(brick.x+(brick.xs+1)/2,brick.y+(brick.ys+1)/2,brick.z+(brick.zs-0.3)/2);
        d3d_model_draw(Corner_Inverted,0,0,0,-1);
        break;
    case "dome":
        brick.xs = 2;
        brick.ys = 2;
        brick.zs = 1;
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_scaling(1/2,1/2,1/2);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
        d3d_model_draw(Dome,0,0,0,-1);
        break;
    case "bars":
        brick.xs = 1;
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_scaling(1/2,1/2,1/2);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z);
        var yrepeat;
        for(yrepeat=-brick.ys/2;yrepeat<brick.ys/2;yrepeat+=1) {
            d3d_model_draw(Fence_Bottom,0,0.3,-1-yrepeat*2,-1);
            d3d_model_draw(Fence_Top,0,0.3+(brick.zs-0.3)*2,-1-yrepeat*2,-1);
        }
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_scaling(1/2,1/2,brick.zs/2);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
        var yrepeat;
        for(yrepeat=-brick.ys/2;yrepeat<brick.ys/2;yrepeat+=1) {
            d3d_model_draw(Fence_Middle,0,0,-1-yrepeat*2,-1);
        }
        break;
    case "flag":
        brick.xs = 1;
        brick.ys = 1;
        brick.zs = 1;
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_scaling(1/2,1/2,1/2);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
        d3d_model_draw(Flag,0,0,0,-1);
        break;
    case "pole":
        brick.xs = 1;
        brick.ys = 1;
        d3d_transform_add_translation(1/2,1/2,0);
        d3d_draw_cylinder(-0.5,-0.5,0,0.5,0.5,0.3,-1,1,1,1,12);
        d3d_draw_cylinder(-0.3,-0.3,0.3,0.3,0.3,brick.zs-0.3,-1,1,1,1,12);
        d3d_draw_ellipsoid(-0.3,-0.3,brick.zs-0.6,0.3,0.3,brick.zs,-1,1,1,12);
        break;
    case "round":
        brick.xs = max(brick.xs,2);
        brick.ys = max(brick.ys,2);
        d3d_draw_floor(brick.xs-1,brick.ys,brick.zs,brick.xs,0,brick.zs,background_get_texture(bkg_stud),1,brick.ys);
        d3d_draw_floor(0,brick.ys,brick.zs,brick.xs-1,brick.ys-1,brick.zs,background_get_texture(bkg_stud),brick.xs-1,1);
        
        d3d_draw_floor(brick.xs-1,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),1,brick.ys);
        d3d_draw_floor(0,brick.ys-1,0,brick.xs-1,brick.ys,0,background_get_texture(bkg_understud),brick.xs-1,1);
        
        d3d_draw_wall(brick.xs-1,0,0,brick.xs,0,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,brick.zs,-1,1,1);
        d3d_draw_wall(0,brick.ys,0,0,brick.ys-1,brick.zs,-1,1,1);
        d3d_transform_set_identity();
        
        /*d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_scaling(brick.xs/2,brick.ys/2,brick.zs/2);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
        d3d_model_draw(Round_Brick,-2/brick.xs,-2/brick.ys,0,-1);*/
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_scaling((brick.xs-1)/2,(brick.ys-1)/2,brick.zs/2);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z);
        d3d_model_draw(Round_Brick,1-brick.xs/2,1-brick.ys/2,-1,-1);
        break;
    case "cylinder":
        d3d_draw_cylinder(0,0,0.3,brick.xs,brick.ys,brick.zs,-1,1,1,1,12);
        d3d_draw_cylinder(0.1,0.1,0,brick.xs-0.1,brick.ys-0.1,0.3,-1,1,1,1,12);
        /*d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_scaling(brick.xs/2,brick.ys/2,brick.zs/2);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
        d3d_model_draw(Round_Large1x1,0,0,0,-1);*/
        break;
    case "round_slope":
        d3d_draw_floor(0,0,0,brick.xs,brick.ys,0,background_get_texture(bkg_understud),brick.xs,brick.ys);
        d3d_draw_wall(0,0,0,brick.xs,0,0.3,-1,1,1);
        d3d_draw_wall(brick.xs,0,0,brick.xs,brick.ys,0.3,-1,1,1);
        d3d_draw_wall(brick.xs,brick.ys,0,0,brick.ys,0.3,-1,1,1);
        d3d_draw_wall(0,brick.ys,0,0,0,0.3,-1,1,1);
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_scaling(brick.xs/2,brick.ys/2,brick.zs/2-0.3);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+brick.zs/2);
        d3d_model_draw(Slope,0,0,0,-1);
        break;
    case "vent":
        brick.zs = 0.3;
        d3d_transform_set_identity();
        
        d3d_transform_set_identity();
        d3d_transform_add_rotation_x(-90);
        d3d_transform_add_scaling(1/2,brick.ys/2,1/2);
        d3d_transform_add_rotation_z(brick.rotation);
        d3d_transform_add_translation(brick.x+brick.xs/2,brick.y+brick.ys/2,brick.z+0.15);
        var xrepeat;
        for(xrepeat=-brick.xs/2;xrepeat<brick.xs/2;xrepeat+=1) {
            d3d_model_draw(Vent,xrepeat*2+1,0,0,-1);
        }
        break;
}

d3d_transform_set_identity();

if brick.rotation mod 180 != 0 {
brickRotX = brick.ys
brickRotY = brick.xs;
} else {
brickRotX = brick.xs
brickRotY = brick.ys;
}
brick.xs = brickRotX;
brick.ys = brickRotY;
brick.x = brickPosX;
brick.y = brickPosY;
}
