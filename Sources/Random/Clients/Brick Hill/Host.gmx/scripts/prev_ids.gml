// prev_ids()
var ID_List;
ID_List = "";

if forcePos {
    if prev_xPos != xPos {
        ID_List += "A";
    }
    if prev_yPos != yPos {
        ID_List += "B";
    }
    if prev_zPos != zPos {
        ID_List += "C";
    }
    if prev_xRot != xRot {
        ID_List += "D";
    }
    if prev_yRot != yRot {
        ID_List += "E";
    }
    if prev_zRot != zRot {
        ID_List += "F";
    }
}
if prev_xScale != xScale {
    ID_List += "G";
}
if prev_yScale != yScale {
    ID_List += "H";
}
if prev_zScale != zScale {
    ID_List += "I";
}
if prev_Arm != Arm {
    ID_List += "J";
}
if prev_toolNum != toolNum {
    ID_List += "K";
}
if prev_maxHealth != maxHealth {
    ID_List += "L";
}
if prev_Health != Health {
    ID_List += "M";
}
if prev_partColorHead != partColorHead {
    ID_List += "N";
}
if prev_partColorTorso != partColorTorso {
    ID_List += "O";
}
if prev_partColorLArm != partColorLArm {
    ID_List += "P";
}
if prev_partColorRArm != partColorRArm {
    ID_List += "Q";
}
if prev_partColorLLeg != partColorLLeg {
    ID_List += "R";
}
if prev_partColorRLeg != partColorRLeg {
    ID_List += "S";
}
if prev_partStickerFace != partStickerFace {
    ID_List += "T";
}
if prev_partStickerTShirt != partStickerTShirt {
    ID_List += "U";
}
if prev_partStickerShirt != partStickerShirt {
    ID_List += "V";
}
if prev_partStickerPants != partStickerPants {
    ID_List += "W";
}
if prev_partModelHat1 != partModelHat1 {
    ID_List += "X";
}
if prev_partModelHat2 != partModelHat2 {
    ID_List += "Y";
}
if prev_partModelHat3 != partModelHat3 {
    ID_List += "Z";
}
if prev_Score != Score {
    ID_List += "0";
}
if prev_maxSpeed != maxSpeed {
    ID_List += "1";
}
if prev_maxJumpHeight != maxJumpHeight {
    ID_List += "2";
}
if prev_FOV != FOV {
    ID_List += "3";
}
if prev_camDist != camDist {
    ID_List += "4";
}
if prev_camXPos != camXPos {
    ID_List += "5";
}
if prev_camYPos != camYPos {
    ID_List += "6";
}
if prev_camZPos != camZPos {
    ID_List += "7";
}
if prev_camXRot != camXRot {
    ID_List += "8";
}
if prev_camYRot != camYRot {
    ID_List += "9";
}
if prev_camZRot != camZRot {
    ID_List += "a";
}
if prev_camType != camType {
    ID_List += "b";
}
if prev_camObj != camObj {
    ID_List += "c";
}
if prev_team != team {
    ID_List += "d";
}
return ID_List;
