with obj_brick {
/*
    if in_cuboid(x,y,z,x+xs,y+ys,z+zs,obj_client.MxRay,obj_client.MyRay,obj_client.MzRay) {
        obj_client.lookingAt = brickID;
    }
*/
      
    if(isVisible) { //&& frustum_culling(obj_client.xPos+xs/2, obj_client.yPos+ys/2, obj_client.zPos+zs/2, max(xs,ys,zs))) {
        
        d3d_set_zwriteenable(true)
    
        brickRotX = xs;
        brickRotY = ys;
        brickPosX = x;
        brickPosY = y;
        if rotation mod 180 != 0 {
            xs = brickRotY;
            ys = brickRotX;
            x = brickPosX-(xs/2-ys/2);
            y = brickPosY-(ys/2-xs/2);
        }
        
        if light_range > 0 {
            if power(x-obj_client.xPos,2)+power(y-obj_client.yPos,2)+power(z-obj_client.zPos,2) < 1000 {
                d3d_light_define_point(id,x,y,z,light_range,light_color);
                Light = true;
                d3d_light_enable(id,true);
            } else {
                Light = false;
                d3d_light_enable(id,false);
            }
        } else if(Light) {
            Light = false;
            d3d_light_enable(id,false);
        }
    
        if alpha < 1 {
            d3d_set_zwriteenable(false)
        }
            
        draw_set_alpha(alpha);
    
        
        /*
        if alpha > 0 {
            d3d_set_zwriteenable(false)
        }
        */
                
        if (Model = -1) {
            draw_set_color(color);
            d3d_transform_set_identity();
            d3d_transform_add_translation(-xs/2,-ys/2,0);
            d3d_transform_add_rotation_z(rotation);
            d3d_transform_add_translation(x+xs/2,y+ys/2,z);
            /*draw_set_color(color);
            d3d_transform_set_identity();
            d3d_transform_add_translation(-xs/2,-ys/2,-zs/2);
            d3d_transform_add_rotation_x(xRot);
            d3d_transform_add_rotation_y(yRot);
            d3d_transform_add_rotation_z(zRot+rotation);//zRot+
            d3d_transform_add_translation(xPos+xs/2,yPos+ys/2,zPos+zs/2);*/
            switch shape {
                case "":
                    d3d_draw_floor(0,ys,zs,xs,0,zs,background_get_texture(bkg_stud),xs,ys);
                    d3d_draw_floor(0,0,0,xs,ys,0,background_get_texture(bkg_stud_under),xs,ys);
                    //d3d_transform_set_identity();
                    
                    /* d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling(xs,ys,zs);
                    d3d_transform_add_translation(-xs/2,-ys/2,0);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z);
                    d3d_model_draw(obj_client.Brick,0,0,0,-1);*/
                    
                    d3d_draw_wall(0,0,0,xs,0,zs,-1,1,1);
                    d3d_draw_wall(xs,0,0,xs,ys,zs,-1,1,1);
                    d3d_draw_wall(xs,ys,0,0,ys,zs,-1,1,1);
                    d3d_draw_wall(0,ys,0,0,0,zs,-1,1,1);
                    
                    if(obj_client.Weather == "snow") {
                        draw_set_color(c_white);
                        d3d_draw_block2(0,ys,zs+1,xs,0,zs,background_get_texture(bkg_snow),ys/100,xs/100);
                    }
                    break;
                case "slope":
                    d3d_draw_floor(xs-1,ys,zs,xs,0,zs,background_get_texture(bkg_stud),1,ys);
                    d3d_draw_floor(0,0,0,xs,ys,0,background_get_texture(bkg_stud_under),xs,ys);
                    d3d_draw_floor(xs-1,0,zs,0,ys,0.3,background_get_texture(bkg_slope),xs-1,ys); //slope
                    d3d_draw_wall(xs,0,0,xs,ys,zs,-1,1,1); //back
                    d3d_draw_wall(xs,ys,0,0,ys,0.3,-1,1,1); //left base
                    d3d_draw_wall(xs,ys,0,xs-1,ys,zs,-1,1,1); //left
                    d3d_draw_wall(0,ys,0,0,0,0.3,-1,1,1); //font
                    d3d_draw_wall(0,0,0,xs,0,0.3,-1,1,1); //right base
                    d3d_draw_wall(xs-1,0,0,xs,0,zs,-1,1,1); //right
                    d3d_primitive_begin(pr_trianglelist);
                    d3d_vertex_texture_color(xs-1, 0, zs,0,0,color,alpha);
                    d3d_vertex_texture_color(0, 0, 0.3, 0, 0,color,alpha);
                    d3d_vertex_texture_color(xs-1, 0, 0.3, 0, 0,color,alpha);
                    d3d_primitive_end();
                    d3d_primitive_begin(pr_trianglelist);
                    d3d_vertex_texture_color(xs-1, ys, 0.3,0,0,color,alpha);
                    d3d_vertex_texture_color(0, ys, 0.3, 0, 0,color,alpha);
                    d3d_vertex_texture_color(xs-1, ys, zs, 0, 0,color,alpha);
                    d3d_primitive_end();
                    break;
                case "plate":
                    zs = 0.3
                    d3d_draw_floor(0,ys,0.3,xs,0,0.3,background_get_texture(bkg_stud),xs,ys);
                    d3d_draw_floor(0,0,0,xs,ys,0,background_get_texture(bkg_stud_under),xs,ys);
                    d3d_draw_wall(0,0,0,xs,0,0.3,-1,1,1);
                    d3d_draw_wall(xs,0,0,xs,ys,0.3,-1,1,1);
                    d3d_draw_wall(xs,ys,0,0,ys,0.3,-1,1,1);
                    d3d_draw_wall(0,ys,0,0,0,0.3,-1,1,1);
                    break;
                case "wedge":
                    if rotation mod 180 == 0 {
                        xs = max(xs,2);
                    } else {
                        ys = max(ys,2);
                    }
                    d3d_draw_floor(0,ys,zs,1,0,zs,background_get_texture(bkg_stud),1,ys);
                    d3d_draw_floor(0,0,0,1,ys,0,background_get_texture(bkg_stud_under),1,ys);
                    d3d_draw_wall(0,0,0,1,0,zs,-1,1,1);
                    d3d_draw_wall(1,0,0,xs,ys,zs,-1,1,1);
                    d3d_draw_wall(xs,ys,0,0,ys,zs,-1,1,1);
                    d3d_draw_wall(0,ys,0,0,0,zs,-1,1,1);
                    
                    d3d_primitive_end();
                    d3d_primitive_begin(pr_trianglelist);
                    d3d_vertex_texture_color(1,0,0,0,0,color,alpha);
                    d3d_vertex_texture_color(1,ys,0,0,0,color,alpha);
                    d3d_vertex_texture_color(xs,ys,0,0,0,color,alpha);
                    d3d_primitive_end();
                    
                    d3d_primitive_end();
                    d3d_primitive_begin(pr_trianglelist);
                    d3d_vertex_texture_color(xs,ys,zs,0,0,color,alpha);
                    d3d_vertex_texture_color(1,ys,zs,0,0,color,alpha);
                    d3d_vertex_texture_color(1,0,zs,0,0,color,alpha);
                    d3d_primitive_end();
                    
                    var brickBy,brickY,brickX,i,iCount;
                    brickBy = hcf(xs,ys);
                    brickY = ys/brickBy;
                    brickX = xs/brickBy;
                    iCount = min(xs/brickX,ys/brickY)-1;
                    for(i=0;i<=iCount;i+=1) {
                        d3d_draw_floor(xs-(i+1)*brickX,(iCount-i)*brickY,zs,0,(iCount-i+1)*brickY,zs,background_get_texture(bkg_stud),xs-(i+1)*brickX,brickY);
                    }
                    break;
                case "spawnpoint":
                    d3d_draw_floor(0,ys,zs,xs,0,zs,background_get_texture(bkg_spawnpoint),1,1);
                    d3d_draw_floor(0,0,0,xs,ys,0,background_get_texture(bkg_stud_under),xs,ys);
                    d3d_draw_wall(0,0,0,xs,0,zs,-1,1,1);
                    d3d_draw_wall(xs,0,0,xs,ys,zs,-1,1,1);
                    d3d_draw_wall(xs,ys,0,0,ys,zs,-1,1,1);
                    d3d_draw_wall(0,ys,0,0,0,zs,-1,1,1);
                    break;
                case "arch":
                    ys = max(ys,3);
                    /*if rotation mod 180 == 0 {
                        draw_set_color(c_green);
                        ys = max(ys,3);
                    } else {
                        draw_set_color(c_blue);
                        xs = max(xs,3);
                    }*/
                    d3d_draw_floor(0,ys,zs,xs,0,zs,background_get_texture(bkg_stud),xs,ys);
                    d3d_draw_floor(0,0,0,xs,1,0,background_get_texture(bkg_stud_under),xs,1);
                    d3d_draw_floor(0,ys-1,0,xs,ys,0,background_get_texture(bkg_stud_under),xs,1);
                    
                    d3d_draw_wall(0,0,0,xs,0,zs,-1,1,1);
                    d3d_draw_wall(xs,ys,0,0,ys,zs,-1,1,1);
                    
                    d3d_draw_wall(xs,1,0,0,1,0.3,-1,1,1);
                    d3d_draw_wall(0,ys-1,0,xs,ys-1,0.3,-1,1,1);
                    
                    d3d_draw_wall(0,1,0,0,0,zs,-1,1,1);
                    d3d_draw_wall(0,ys,0,0,ys-1,zs,-1,1,1);
                    
                    d3d_draw_wall(xs,0,0,xs,1,zs,-1,1,1);
                    d3d_draw_wall(xs,ys-1,0,xs,ys,zs,-1,1,1);
                    
                    d3d_draw_wall(0,ys,zs-0.3,0,0,zs,-1,1,1);
                    d3d_draw_wall(xs,0,zs-0.3,xs,ys,zs,-1,1,1);
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling(xs/2,(ys-2)/2,(zs-0.6)/2);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z+0.3);
                    d3d_model_draw(obj_client.Arch,0,1,0,-1);
                    break;
                case "corner": //WIP
                    xs = max(xs,2);
                    ys = max(ys,2);
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling((xs-1)/2,(ys-1)/2,zs/2);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+(xs+1)/2,y+(ys+1)/2,z+zs/2);
                    d3d_model_draw(obj_client.Corner,0,0,0,-1);
                    break;
                case "corner_inv":
                    xs = max(xs,2);
                    ys = max(ys,2);
                    d3d_draw_floor(0,ys,zs,xs,0,zs,background_get_texture(bkg_stud),xs,ys);
                    d3d_draw_floor(0,0,0,1,1,0,background_get_texture(bkg_stud_under),1,1);
                    
                    d3d_draw_wall(xs,0,zs-0.3,xs,ys,zs,-1,1,1);
                    d3d_draw_wall(xs,ys,zs-0.3,0,ys,zs,-1,1,1);
                    d3d_draw_wall(1,0,zs-0.3,xs,0,zs,-1,1,1);
                    d3d_draw_wall(0,ys,zs-0.3,0,1,zs,-1,1,1);
                    d3d_draw_wall(0,0,0,1,0,zs,-1,1,1);
                    d3d_draw_wall(0,1,0,0,0,zs,-1,1,1);
                    
                    d3d_primitive_begin(pr_trianglelist);
                    d3d_vertex_texture_color(1, 0, zs-0.3, 0, 0,color,alpha);
                    d3d_vertex_texture_color(1, 0, 0, 0, 0,color,alpha);
                    d3d_vertex_texture_color(xs, 0, zs-0.3,0,0,color,alpha);
                    d3d_primitive_end();
                    
                    d3d_primitive_begin(pr_trianglelist);
                    d3d_vertex_texture_color(0, ys, zs-0.3,0,0,color,alpha);
                    d3d_vertex_texture_color(0, 1, 0, 0, 0,color,alpha);
                    d3d_vertex_texture_color(0, 1, zs-0.3, 0, 0,color,alpha);
                    d3d_primitive_end();
                    
                    d3d_draw_floor(1,0,0,xs,1,zs-0.3,-1,1,1);
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_z(rotation+90);
                    d3d_transform_add_translation(x,y+ys,z);
                    d3d_draw_floor(0,0,zs-0.3,ys-1,1,0,-1,1,1);
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling((xs-1)/2,(ys-1)/2,(zs-0.3)/2);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+(xs+1)/2,y+(ys+1)/2,z+(zs-0.3)/2);
                    d3d_model_draw(obj_client.Corner_Inverted,0,0,0,-1);
                    break;
                case "dome":
                    xs = 2;
                    ys = 2;
                    zs = 1;
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling(1/2,1/2,1/2);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z+zs/2);
                    d3d_model_draw(obj_client.Dome,0,0,0,-1);
                    break;
                case "bars":
                    xs = 1;
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling(1/2,1/2,1/2);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z);
                    var yrepeat;
                    for(yrepeat=-ys/2;yrepeat<ys/2;yrepeat+=1) {
                        d3d_model_draw(obj_client.Fence_Bottom,0,0.3,-1-yrepeat*2,-1);
                        d3d_model_draw(obj_client.Fence_Top,0,0.3+(zs-0.3)*2,-1-yrepeat*2,-1);
                    }
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling(1/2,1/2,zs/2);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z+zs/2);
                    var yrepeat;
                    for(yrepeat=-ys/2;yrepeat<ys/2;yrepeat+=1) {
                        d3d_model_draw(obj_client.Fence_Middle,0,0,-1-yrepeat*2,-1);
                    }
                    break;
                case "flag":
                    xs = 1;
                    ys = 1;
                    zs = 1;
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_scaling(1/2,1/2,1/2);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z+zs/2);
                    d3d_model_draw(obj_client.Flag,0,0,0,-1);
                    break;
                case "pole":
                    xs = 1;
                    ys = 1;
                    d3d_transform_add_translation(1/2,1/2,0);
                    d3d_draw_cylinder(-0.5,-0.5,0,0.5,0.5,0.3,-1,1,1,1,12);
                    d3d_draw_cylinder(-0.3,-0.3,0.3,0.3,0.3,zs-0.3,-1,1,1,1,12);
                    d3d_draw_ellipsoid(-0.3,-0.3,zs-0.6,0.3,0.3,zs,-1,1,1,12);
                    break;
                case "round":
                    xs = max(xs,2);
                    ys = max(ys,2);
                    d3d_draw_floor(xs-1,ys,zs,xs,0,zs,background_get_texture(bkg_stud),1,ys);
                    d3d_draw_floor(0,ys,zs,xs-1,ys-1,zs,background_get_texture(bkg_stud),xs-1,1);
                    
                    d3d_draw_floor(xs-1,0,0,xs,ys,0,background_get_texture(bkg_stud_under),1,ys);
                    d3d_draw_floor(0,ys-1,0,xs-1,ys,0,background_get_texture(bkg_stud_under),xs-1,1);
                    
                    d3d_draw_wall(xs-1,0,0,xs,0,zs,-1,1,1);
                    d3d_draw_wall(xs,0,0,xs,ys,zs,-1,1,1);
                    d3d_draw_wall(xs,ys,0,0,ys,zs,-1,1,1);
                    d3d_draw_wall(0,ys,0,0,ys-1,zs,-1,1,1);
                    d3d_transform_set_identity();
                    
                    /* d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling(xs/2,ys/2,zs/2);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z+zs/2);
                    d3d_model_draw(obj_client.Round_Brick,-2/xs,-2/ys,0,-1);*/
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_scaling((xs-1)/2,(ys-1)/2,zs/2);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z);
                    d3d_model_draw(obj_client.Round_Brick,1-xs/2,1-ys/2,-1,-1);
                    break;
                case "cylinder":
                    d3d_draw_cylinder(0,0,0.3,xs,ys,zs,-1,1,1,1,12);
                    d3d_draw_cylinder(0.1,0.1,0,xs-0.1,ys-0.1,0.3,-1,1,1,1,12);
                    /* d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_scaling(xs/2,ys/2,zs/2);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z+zs/2);
                    d3d_model_draw(obj_client.Round_Large1x1,0,0,0,-1);*/
                    break;
                case "round_slope":
                    d3d_draw_floor(0,0,0,xs,ys,0,background_get_texture(bkg_stud_under),xs,ys);
                    d3d_draw_wall(0,0,0,xs,0,0.3,-1,1,1);
                    d3d_draw_wall(xs,0,0,xs,ys,0.3,-1,1,1);
                    d3d_draw_wall(xs,ys,0,0,ys,0.3,-1,1,1);
                    d3d_draw_wall(0,ys,0,0,0,0.3,-1,1,1);
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_scaling(xs/2,ys/2,zs/2-0.3);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z+zs/2);
                    d3d_model_draw(obj_client.Slope,0,0,0,-1);
                    break;
                case "vent":
                    zs = 0.3;
                    d3d_transform_set_identity();
                    
                    d3d_transform_set_identity();
                    d3d_transform_add_rotation_x(-90);
                    d3d_transform_add_scaling(1/2,ys/2,1/2);
                    d3d_transform_add_rotation_z(rotation);
                    d3d_transform_add_translation(x+xs/2,y+ys/2,z+0.15);
                    var xrepeat;
                    for(xrepeat=-xs/2;xrepeat<xs/2;xrepeat+=1) {
                        d3d_model_draw(obj_client.Vent,xrepeat*2+1,0,0,-1);
                    }
                    break;
            }
        } else {
            d3d_transform_add_rotation_x(-90);
            d3d_transform_add_rotation_z(rotation);
            d3d_transform_add_translation(x+xs/2,y+ys/2,z+zs/2-5);
            if Tex != -1 && background_exists(Tex) {
                d3d_model_draw(Model, 0,0,0, background_get_texture(Tex));
            } else {
                d3d_model_draw(Model, 0,0,0, -1)
            }
        }
        d3d_transform_set_identity();
        
        if rotation mod 180 != 0 {
            brickRotX = ys
            brickRotY = xs;
        } else {
            brickRotX = xs
            brickRotY = ys;
        }
        xs = brickRotX;
        ys = brickRotY;
        x = brickPosX;
        y = brickPosY;
        
        
    }
    //GmnBodySetRotation(body,0,0,rotation);
    //GmnBodySetPosition(body,x,y,z);
}
