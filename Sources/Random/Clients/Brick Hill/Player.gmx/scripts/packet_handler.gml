
var i, id_string;
id_string = argument0;

for(i = 1; i <= string_length(id_string); i += 1) {
    switch string_char_at(id_string,i) {
        case "A":
            xPos = buffer_read_float32(global.BUFFER);
            break;
        case "B":
            yPos = buffer_read_float32(global.BUFFER);
            break;
        case "C":
            zPos = buffer_read_float32(global.BUFFER);
            break;
        case "D":
            xRot = buffer_read_uint32(global.BUFFER);
            break;
        case "E":
            yRot = buffer_read_uint32(global.BUFFER);
            break;
        case "F":
            zRot = buffer_read_uint32(global.BUFFER);
            break;
        case "G":
            xScale = buffer_read_float32(global.BUFFER);
            break;
        case "H":
            yScale = buffer_read_float32(global.BUFFER);
            break;
        case "I":
            zScale = buffer_read_float32(global.BUFFER);
            break;
            /*
        case "J":
            Arm = buffer_read_int8(global.BUFFER);
            break;
            */
        case "K":
            partColorHead = buffer_read_uint32(global.BUFFER);
            break;
        case "L":
            partColorTorso = buffer_read_uint32(global.BUFFER);
            break;
        case "M":
            partColorLArm = buffer_read_uint32(global.BUFFER);
            break;
        case "N":
            partColorRArm = buffer_read_uint32(global.BUFFER);
            break;
        case "O":
            partColorLLeg = buffer_read_uint32(global.BUFFER);
            break;
        case "P":
            partColorRLeg = buffer_read_uint32(global.BUFFER);
            break;
        case "Q":
            partStickerFace = buffer_read_uint32(global.BUFFER);
            FaceDownload = fetch_asset(partStickerFace, "face", "png", false)
            break;
        case "U":
            partModelHat1 = buffer_read_uint32(global.BUFFER);
            Hat1TexDownload = fetch_asset(partModelHat1, "hat_tex1", "png", false)
            Hat1ModDownload = fetch_asset(partModelHat1, "hat_mod1", "obj", false)
            break;
        case "V":
            partModelHat2 = buffer_read_uint32(global.BUFFER);
            Hat2TexDownload = fetch_asset(partModelHat2, "hat_tex2", "png", false)
            Hat2ModDownload = fetch_asset(partModelHat2, "hat_mod2", "obj", false)
            break;
        case "W":
            partModelHat3 = buffer_read_uint32(global.BUFFER);
            Hat3TexDownload = fetch_asset(partModelHat3, "hat_tex3", "png", false)
            Hat3ModDownload = fetch_asset(partModelHat3, "hat_mod3", "obj", false)
            break;
        case "X":
            Score = buffer_read_uint32(global.BUFFER);
            break;
        case "Y":
            team = buffer_read_uint32(global.BUFFER);
            break;
        
        // LOCAL CHANGES
        case "1":
            maxSpeed = buffer_read_uint32(global.BUFFER);
            break;
        case "2":
            maxJumpHeight = buffer_read_uint32(global.BUFFER);
            break;
        case "3":
            FOV = buffer_read_uint32(global.BUFFER);
            break;
        case "4":
            CamDist = buffer_read_uint32(global.BUFFER);
            break;
        case "5":
            CamXPos = buffer_read_uint32(global.BUFFER);
            break;
        case "6":
            CamYPos = buffer_read_uint32(global.BUFFER);
            break;
        case "7":
            CamZPos = buffer_read_uint32(global.BUFFER);
            break;
        case "8":
            CamXRot = buffer_read_uint32(global.BUFFER);
            break;
        case "9":
            CamYRot = buffer_read_uint32(global.BUFFER);
            break;
        case "a":
            CamZRot = buffer_read_uint32(global.BUFFER);
            break;
        case "b":
            CamType = buffer_read_string(global.BUFFER);
            break;
        case "c":
            CamObj = buffer_read_uint32(global.BUFFER);
            break;
        case "e":
            var healthVar;
            healthVar = buffer_read_float32(global.BUFFER);
            if (healthVar > maxHealth) {
                maxHealth = healthVar
            }
            Health = healthVar
            break;
        case "f":
            Speech = buffer_read_string(global.BUFFER);
            break
        case "g": // Equip tool
            var slotId, model;
            slotId = buffer_read_uint32(global.BUFFER);
            model = buffer_read_uint32(global.BUFFER);
            Item_ModDownload = fetch_asset(model, "item_mod", "obj", false)
            Item_TexDownload = fetch_asset(model, "item_tex", "png", false)
            Arm = slotId
            break
        case "h": // De-equip tool
            Arm = -1;
            break
    }
}
