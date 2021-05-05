// playerGetColor(id player, string part)
with argument0 {
    switch argument1 {
        case "Head":
            return partColorHead;
        case "Torso":
            return partColorTorso;
        case "LArm":
            return partColorLArm;
        case "RArm":
            return partColorRArm;
        case "LLeg":
            return partColorLLeg;
        case "RLeg":
            return partColorRLeg;
    }
}
return "";
