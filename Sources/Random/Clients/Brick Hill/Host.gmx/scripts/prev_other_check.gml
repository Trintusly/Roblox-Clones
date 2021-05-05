// c.prev_check(other)
c = argument0;
if c.prev_xPos != c.xPos {
    buffer_write_float32(global.BUFFER, c.xPos);
}
if c.prev_yPos != c.yPos {
    buffer_write_float32(global.BUFFER, c.yPos);
}
if c.prev_zPos != c.zPos {
    buffer_write_float32(global.BUFFER, c.zPos);
}
if c.prev_xRot != c.xRot {
    buffer_write_uint32(global.BUFFER, c.xRot);
}
if c.prev_yRot != c.yRot {
    buffer_write_uint32(global.BUFFER, c.yRot);
}
if c.prev_zRot != c.zRot {
    buffer_write_uint32(global.BUFFER, c.zRot);
}
if c.prev_xScale != c.xScale {
    buffer_write_float32(global.BUFFER, c.xScale);
}
if c.prev_yScale != c.yScale {
    buffer_write_float32(global.BUFFER, c.yScale);
}
if c.prev_zScale != c.zScale {
    buffer_write_float32(global.BUFFER, c.zScale);
}
if c.prev_Arm != c.Arm {
    buffer_write_uint32(global.BUFFER, c.Arm);
}
if c.prev_partColorHead != c.partColorHead {
    buffer_write_uint32(global.BUFFER, c.partColorHead);
}
if c.prev_partColorTorso != c.partColorTorso {
    buffer_write_uint32(global.BUFFER, c.partColorTorso);
}
if c.prev_partColorLArm != c.partColorLArm {
    buffer_write_uint32(global.BUFFER, c.partColorLArm);
}
if c.prev_partColorRArm != c.partColorRArm {
    buffer_write_uint32(global.BUFFER, c.partColorRArm);
}
if c.prev_partColorLLeg != c.partColorLLeg {
    buffer_write_uint32(global.BUFFER, c.partColorLLeg);
}
if c.prev_partColorRLeg != c.partColorRLeg {
    buffer_write_uint32(global.BUFFER, c.partColorRLeg);
}
if c.prev_partStickerFace != c.partStickerFace {
    buffer_write_string(global.BUFFER, c.partStickerFace);
}
if c.prev_partStickerTShirt != c.partStickerTShirt {
    buffer_write_string(global.BUFFER, c.partStickerTShirt);
}
if c.prev_partStickerShirt != c.partStickerShirt {
    buffer_write_string(global.BUFFER, c.partStickerShirt);
}
if c.prev_partStickerPants != c.partStickerPants {
    buffer_write_string(global.BUFFER, c.partStickerPants);
}
if c.prev_partModelHat1 != c.partModelHat1 {
    buffer_write_string(global.BUFFER, c.partModelHat1);
}
if c.prev_partModelHat2 != c.partModelHat2 {
    buffer_write_string(global.BUFFER, c.partModelHat2);
}
if c.prev_partModelHat3 != c.partModelHat3 {
    buffer_write_string(global.BUFFER, c.partModelHat3);
}
if c.prev_Score != c.Score {
    buffer_write_uint32(global.BUFFER, c.Score);
}
if c.prev_team != c.team {
    buffer_write_uint32(global.BUFFER, c.team);
}
