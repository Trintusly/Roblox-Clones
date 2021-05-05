// draw_figure()

if(alive) {
    if power(xPos-obj_client.xPos,2)+power(yPos-obj_client.yPos,2)+power(zPos-obj_client.zPos,2) >= 250000 {
        break;
    }
    
    if is_col(xPos,yPos,zPos-0.1,zPos+1,1.5*xScale,1.5*yScale) {
        if (xPos != xPrev || yPos != yPrev) {
            if animation != 1 {
                frame = 0;
                animation = 1;
            }
        } else {
            animation = 0;
        }
    }
    
    if zPos != zPrev && animation != 2 {
        frame = 0;
        animation = 2;
    }
    
    frame += 1;
    
    d3d_transform_set_identity();
    
    d3d_transform_add_scaling(xScale,yScale,zScale);
    d3d_transform_add_rotation_x(xRot-90);
    d3d_transform_add_rotation_y(yRot);
    d3d_transform_add_rotation_z(zRot);
    d3d_transform_add_translation(xPos,yPos,zPos);
    
    draw_set_color(c_white);
    
    if(obj_client.SETTINGS_Models) {
        if Hat1 != -1 && background_exists(Hat1_Tex) {
            d3d_model_draw(Hat1, 0, 0, 0, background_get_texture(Hat1_Tex));
        }
        if Hat2 != -1 && background_exists(Hat2_Tex) {
            d3d_model_draw(Hat2, 0, 0, 0, background_get_texture(Hat2_Tex));
        }
        if Hat3 != -1 && background_exists(Hat3_Tex) {
            d3d_model_draw(Hat3, 0, 0, 0, background_get_texture(Hat3_Tex));
        }
    }
    
    draw_set_color(partColorHead);
    d3d_model_draw(obj_client.modelHead, 0, 0, 0, -1);
    draw_set_color(c_white);
    
    if Face != -1 && background_exists(Face) {
        d3d_model_draw(obj_client.modelHead, 0, 0, 0, background_get_texture(Face));
    } else {
        d3d_model_draw(obj_client.modelHead, 0, 0, 0, bkg_face);
    }
    
    draw_set_color(partColorTorso);
    d3d_model_draw(obj_client.modelTorso, 0, 0, 0, -1);
    draw_set_color(c_white);
    
    /*
    if partStickerShirt != "0" && background_exists(Shirt) {
        d3d_model_draw(obj_client.modelTorso, 0, 0, 0, background_get_texture(Shirt));
    } else {
        d3d_model_draw(obj_client.modelTorso, 0, 0, 0, bkg_default);
    }
    if partStickerTShirt != "0" && background_exists(TShirt) {
        d3d_model_draw(obj_client.modelTShirt, 0, 0, 0, background_get_texture(TShirt));
    }
    */
    
    d3d_model_draw(obj_client.modelTorso, 0, 0, 0, bkg_default);
    
    d3d_transform_set_identity();
    
    
    //Left Arm
    d3d_transform_set_identity();
    d3d_transform_add_scaling(xScale,yScale,zScale);
    d3d_transform_add_rotation_x(xRot-90);
    d3d_transform_add_translation(0,0,-3.5*zScale);
    switch animation {
        case 1:
            d3d_transform_add_rotation_x(larm_walk(frame));
            break;
        case 2:
            d3d_transform_add_rotation_x(larm_jump(frame));
            break;
    }
    d3d_transform_add_rotation_y(yRot);
    d3d_transform_add_rotation_z(zRot);
    d3d_transform_add_translation(xPos,yPos,zPos+3.5*zScale);
    draw_set_color(partColorLArm);
    d3d_model_draw(obj_client.modelLArm, 0, 0, 0, -1);
    draw_set_color(c_white);
    /*
    if partStickerShirt != "0" && background_exists(Shirt) {
        d3d_model_draw(obj_client.modelLArm, 0, 0, 0, background_get_texture(Shirt));
    } else {
        d3d_model_draw(obj_client.modelLArm, 0, 0, 0, bkg_default);
    }
    */
    
    d3d_model_draw(obj_client.modelLArm, 0, 0, 0, bkg_default);
    
    d3d_transform_set_identity();
    

    //Right Arm
    d3d_transform_set_identity();
    d3d_transform_add_scaling(xScale,yScale,zScale);
    d3d_transform_add_rotation_x(xRot-90);
    d3d_transform_add_translation(0,0,-3.5*zScale);
    switch animation {
        case 1:
            d3d_transform_add_rotation_x(rarm_walk(frame));
            break;
        case 2:
            d3d_transform_add_rotation_x(rarm_jump(frame));
            break;
    }
    d3d_transform_add_rotation_y(yRot);
    d3d_transform_add_rotation_z(zRot);
    d3d_transform_add_translation(xPos,yPos,zPos+3.5*zScale);
    draw_set_color(partColorRArm);
    d3d_model_draw(obj_client.modelRArm, 0, 0, 0, -1);
    draw_set_color(c_white);
    /*
    if partStickerShirt != "0" && background_exists(Shirt) {
        d3d_model_draw(obj_client.modelRArm, 0, 0, 0, background_get_texture(Shirt));
    } else {
        d3d_model_draw(obj_client.modelRArm, 0, 0, 0, bkg_default);
    }
    */
    
    d3d_model_draw(obj_client.modelRArm, 0, 0, 0, bkg_default);
    
    d3d_transform_set_identity();
    
    //Left Leg
    d3d_transform_set_identity();
    d3d_transform_add_scaling(xScale,yScale,zScale);
    d3d_transform_add_rotation_x(xRot-90);
    d3d_transform_add_translation(0,0,-2*zScale);
    switch animation {
        case 1:
            d3d_transform_add_rotation_x(lleg_walk(frame));
            break;
    }
    d3d_transform_add_rotation_y(yRot);
    d3d_transform_add_rotation_z(zRot);
    d3d_transform_add_translation(xPos,yPos,zPos+2*zScale);
    draw_set_color(partColorLLeg);
    d3d_model_draw(obj_client.modelLLeg, 0, 0, 0, -1);
    draw_set_color(c_white);
    
    /*
    if partStickerPants != "0" && background_exists(Pants) {
        d3d_model_draw(obj_client.modelLLeg, 0, 0, 0, background_get_texture(Pants));
    } else {
        d3d_model_draw(obj_client.modelLLeg, 0, 0, 0, bkg_default);
    }
    */
    
    d3d_model_draw(obj_client.modelLLeg, 0, 0, 0, bkg_default);
    
    d3d_transform_set_identity();
    
    //Right Leg
    d3d_transform_set_identity();
    d3d_transform_add_scaling(xScale,yScale,zScale);
    d3d_transform_add_rotation_x(xRot-90);
    d3d_transform_add_translation(0,0,-2*zScale);
    switch animation {
        case 1:
            d3d_transform_add_rotation_x(rleg_walk(frame));
            break;
    }
    d3d_transform_add_rotation_y(yRot);
    d3d_transform_add_rotation_z(zRot);
    d3d_transform_add_translation(xPos,yPos,zPos+2*zScale);
    draw_set_color(partColorRLeg);
    d3d_model_draw(obj_client.modelRLeg, 0, 0, 0, -1);
    draw_set_color(c_white);
    
    /*
    if partStickerPants != "0" && background_exists(Pants) {
        d3d_model_draw(obj_client.modelRLeg, 0, 0, 0, background_get_texture(Pants));
    } else {
        d3d_model_draw(obj_client.modelRLeg, 0, 0, 0, bkg_default);
    }
    */
    
    d3d_model_draw(obj_client.modelRLeg, 0, 0, 0, bkg_default);
    
    d3d_transform_set_identity();
    
    xPrev = xPos;
    yPrev = yPos;
    zPrev = zPos;
}
