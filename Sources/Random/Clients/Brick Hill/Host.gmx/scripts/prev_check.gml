// prev_check()
if forcePos {
    if prev_xPos != xPos {
        buffer_write_float32(global.BUFFER, xPos);
    }
    if prev_yPos != yPos {
        buffer_write_float32(global.BUFFER, yPos);
    }
    if prev_zPos != zPos {
        buffer_write_float32(global.BUFFER, zPos);
    }
    if prev_xRot != xRot {
        buffer_write_uint32(global.BUFFER, xRot);
    }
    if prev_yRot != yRot {
        buffer_write_uint32(global.BUFFER, yRot);
    }
    if prev_zRot != zRot {
        buffer_write_uint32(global.BUFFER, zRot);
    }
    forcePos = false;
}
if prev_xScale != xScale {
    buffer_write_float32(global.BUFFER, xScale);
}
if prev_yScale != yScale {
    buffer_write_float32(global.BUFFER, yScale);
}
if prev_zScale != zScale {
    buffer_write_float32(global.BUFFER, zScale);
}
if prev_Arm != Arm {
    buffer_write_uint32(global.BUFFER, Arm);
}
if prev_toolNum != toolNum {
    buffer_write_uint32(global.BUFFER, toolNum);
}
if prev_maxHealth != maxHealth {
    buffer_write_uint32(global.BUFFER, maxHealth);
}
if prev_Health != Health {
    buffer_write_float32(global.BUFFER, Health);
}
if prev_partColorHead != partColorHead {
    buffer_write_uint32(global.BUFFER, partColorHead);
}
if prev_partColorTorso != partColorTorso {
    buffer_write_uint32(global.BUFFER, partColorTorso);
}
if prev_partColorLArm != partColorLArm {
    buffer_write_uint32(global.BUFFER, partColorLArm);
}
if prev_partColorRArm != partColorRArm {
    buffer_write_uint32(global.BUFFER, partColorRArm);
}
if prev_partColorLLeg != partColorLLeg {
    buffer_write_uint32(global.BUFFER, partColorLLeg);
}
if prev_partColorRLeg != partColorRLeg {
    buffer_write_uint32(global.BUFFER, partColorRLeg);
}
if prev_partStickerFace != partStickerFace {
    buffer_write_string(global.BUFFER, partStickerFace);
}
if prev_partStickerTShirt != partStickerTShirt {
    buffer_write_string(global.BUFFER, partStickerTShirt);
}
if prev_partStickerShirt != partStickerShirt {
    buffer_write_string(global.BUFFER, partStickerShirt);
}
if prev_partStickerPants != partStickerPants {
    buffer_write_string(global.BUFFER, partStickerPants);
}
if prev_partModelHat1 != partModelHat1 {
    buffer_write_string(global.BUFFER, partModelHat1);
}
if prev_partModelHat2 != partModelHat2 {
    buffer_write_string(global.BUFFER, partModelHat2);
}
if prev_partModelHat3 != partModelHat3 {
    buffer_write_string(global.BUFFER, partModelHat3);
}
if prev_Score != Score {
    buffer_write_uint32(global.BUFFER, Score);
}
if prev_maxSpeed != maxSpeed {
    buffer_write_uint32(global.BUFFER, maxSpeed);
}
if prev_maxJumpHeight != maxJumpHeight {
    buffer_write_uint32(global.BUFFER, maxJumpHeight);
}
if prev_FOV != FOV {
    buffer_write_uint32(global.BUFFER, FOV);
}
if prev_camDist != camDist {
    buffer_write_uint32(global.BUFFER, camDist);
}
if prev_camXPos != camXPos {
    buffer_write_uint32(global.BUFFER, camXPos);
}
if prev_camYPos != camYPos {
    buffer_write_uint32(global.BUFFER, camYPos);
}
if prev_camZPos != camZPos {
    buffer_write_uint32(global.BUFFER, camZPos);
}
if prev_camXRot != camXRot {
    buffer_write_uint32(global.BUFFER, camXRot);
}
if prev_camYRot != camYRot {
    buffer_write_uint32(global.BUFFER, camYRot);
}
if prev_camZRot != camZRot {
    buffer_write_uint32(global.BUFFER, camZRot);
}
if prev_camType != camType {
    //(0"fixed", 1"orbit", 2"free", 3"first")
    switch camType {
        case "fixed":
            buffer_write_uint32(global.BUFFER, 0);
            break;
        case "orbit":
            buffer_write_uint32(global.BUFFER, 1);
            break;
        case "free":
            buffer_write_uint32(global.BUFFER, 2);
            break;
        case "first":
            buffer_write_uint32(global.BUFFER, 3);
            break;
    }
}
if prev_camObj != camObj {
    buffer_write_uint32(global.BUFFER, camObj.net_id);
}
if prev_team != team {
    buffer_write_uint32(global.BUFFER, team);
}
