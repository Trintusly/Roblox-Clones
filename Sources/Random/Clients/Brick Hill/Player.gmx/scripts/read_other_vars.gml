// read_other_vars(id_string)
var i,id_string;
id_string = argument0;
for(i = 1; i <= string_length(id_string); i += 1) {
    switch string_char_at(id_string,i) {
        case "A":
            walking = true;
            xPos = buffer_read_float32(global.BUFFER);
            break;
        case "B":
            walking = true;
            yPos = buffer_read_float32(global.BUFFER);
            break;
        case "C":
            walking = true;
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
            GmnDestroyBody(global.set,Body);
            Bound = GmnCreateBox(global.set,xScale*2,yScale*2,zScale*5,xScale,yScale,zScale*5/2);
            Body = GmnCreateBody(global.set,Bound);
            break;
        case "H":
            yScale = buffer_read_float32(global.BUFFER);
            GmnDestroyBody(global.set,Body);
            Bound = GmnCreateBox(global.set,xScale*2,yScale*2,zScale*5,xScale,yScale,zScale*5/2);
            Body = GmnCreateBody(global.set,Bound);
            break;
        case "I":
            zScale = buffer_read_float32(global.BUFFER);
            GmnDestroyBody(global.set,Body);
            Bound = GmnCreateBox(global.set,xScale*2,yScale*2,zScale*5,xScale,yScale,zScale*5/2);
            Body = GmnCreateBody(global.set,Bound);
            break;
        case "J":
            Arm = buffer_read_int8(global.BUFFER);
            break;
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
        /*
        case "R":
            partStickerTShirt = buffer_read_uint32(global.BUFFER);
            TShirtDownload = fetch_asset(partStickerTShirt, "tshirt")
            break;
        case "S":
            partStickerShirt = buffer_read_uint32(global.BUFFER);
            ShirtDownload = fetch_asset(partStickerShirt, "shirt") 
            break;
        case "T":
            partStickerPants = buffer_read_uint32(global.BUFFER);
            PantsDownload = fetch_asset(partStickerPants, "pants") 
            break;
        */
        
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
/*        case "Q":
            partStickerFace = buffer_read_string(global.BUFFER);
            if partStickerFace != "0" {
                texture_load(partStickerFace, "face");
                Face = Texture;
            }
            break;
        case "R":
            partStickerTShirt = buffer_read_string(global.BUFFER);
            if partStickerTShirt != "0" {
                texture_load(partStickerTShirt, "tshirt");
                TShirt = Texture;
            }
            break;
        case "S":
            partStickerShirt = buffer_read_string(global.BUFFER);
            if partStickerShirt != "0" {
                texture_load(partStickerShirt, "shirt");
                Shirt = Texture;
            }
            break;
        case "T":
            partStickerPants = buffer_read_string(global.BUFFER);
            if partStickerPants != "0" {
                texture_load(partStickerPants, "pants");
                Pants = Texture;
            }
            break;
        case "U":
            partModelHat1 = buffer_read_string(global.BUFFER);
            if partModelHat1 != "0" {
                Hat1 = model_load(partModelHat1,"hat");
                Hat1_Tex = Hat_Texture;
            }
            break;
        case "V":
            partModelHat2 = buffer_read_string(global.BUFFER);
            if partModelHat2 != "0" {
                Hat2 = model_load(partModelHat2,"hat");
                Hat2_Tex = Hat_Texture;
            }
            break;
        case "W":
            partModelHat3 = buffer_read_string(global.BUFFER);
            if partModelHat3 != "0" {
                Hat3 = model_load(partModelHat3,"hat");
                Hat3_Tex = Hat_Texture;
            }
            break;*/
        case "X":
            Score = buffer_read_uint32(global.BUFFER);
            break;
        case "Y":
            team = buffer_read_uint32(global.BUFFER);
            break;
    }
}
