// read_vars(id_string)
var i,id_string;
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
        case "J":
            Arm = buffer_read_int8(global.BUFFER);
            break;
        case "K":
            toolNum = buffer_read_uint32(global.BUFFER);
            break;
        case "L":
            maxHealth = buffer_read_uint32(global.BUFFER);
            break;
        case "M":
            Health = buffer_read_float32(global.BUFFER);
            break;
        case "N":
            partColorHead = buffer_read_uint32(global.BUFFER);
            break;
        case "O":
            partColorTorso = buffer_read_uint32(global.BUFFER);
            break;
        case "P":
            partColorLArm = buffer_read_uint32(global.BUFFER);
            break;
        case "Q":
            partColorRArm = buffer_read_uint32(global.BUFFER);
            break;
        case "R":
            partColorLLeg = buffer_read_uint32(global.BUFFER);
            break;
        case "S":
            partColorRLeg = buffer_read_uint32(global.BUFFER);
            break;
        case "T":
            partStickerFace = buffer_read_uint32(global.BUFFER);
            FaceDownload = fetch_asset(partStickerFace, "face", "png", false) // do NOT use legacy bangla api
            break;
            /*
        case "U":
            partStickerTShirt = buffer_read_uint32(global.BUFFER);
            TShirtDownload = fetch_asset(partStickerTShirt, "tshirt")
            break;
        case "V":
            partStickerShirt = buffer_read_uint32(global.BUFFER);
            ShirtDownload = fetch_asset(partStickerShirt, "shirt")
            break;
        case "W":
            partStickerPants = buffer_read_uint32(global.BUFFER);
            PantsDownload = fetch_asset(partStickerPants, "pants")
            break;
        */
        case "X":
            partModelHat1 = buffer_read_uint32(global.BUFFER);
            Hat1TexDownload = fetch_asset(partModelHat1, "hat_tex1", "png", false)
            Hat1ModDownload = fetch_asset(partModelHat1, "hat_mod1", "obj", false)
            break
            /*
            if string_length(partModelHat1) == 8 {
                Hat1TexDownload = download("http://www.brick-hill.com/API/client/asset_texture?id="+partModelHat1+"&type=hat",global.ASSET_DIR+"hat1"+string(id)+".png");
                Hat1ModDownload = download("http://www.brick-hill.com/shop_storage/client/"+partModelHat1+".d3d",global.ASSET_DIR+"hat1"+string(id)+".d3d");
            } else {
                Hat1 = -1;
            }
            break;
            */
        case "Y":
            partModelHat2 = buffer_read_uint32(global.BUFFER);
            Hat2TexDownload = fetch_asset(partModelHat2, "hat_tex2", "png", false)
            Hat2ModDownload = fetch_asset(partModelHat2, "hat_mod2", "obj", false)
            break;
        case "Z":
            partModelHat3 = buffer_read_uint32(global.BUFFER);
            Hat3TexDownload = fetch_asset(partModelHat3, "hat_tex3", "png", false)
            Hat3ModDownload = fetch_asset(partModelHat3, "hat_mod3", "obj", false)
            break;
        case "0":
            Score = buffer_read_uint32(global.BUFFER);
            break;
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
            CamType = buffer_read_uint32(global.BUFFER);
            switch CamType {
                case 0:
                    CamType = "fixed";
                    break;
                case 1:
                    CamType = "orbit";
                    break;
                case 2:
                    CamType = "free";
                    break;
                case 3:
                    CamType = "first";
                    break;
            }
            break;
        case "c":
            CamObj = buffer_read_uint32(global.BUFFER);amObj = buffer_read_uint32(global.BUFFER);
            break;
        case "d":
            team = buffer_read_uint32(global.BUFFER);
            break;
    }
}
