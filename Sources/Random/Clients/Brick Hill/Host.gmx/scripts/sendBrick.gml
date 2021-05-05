// sendBrick(brick)
with argument0 {
    var brickTemp;
    brickTemp = string(xPos)+" "+string(yPos)+" "+string(zPos)+" ";
    brickTemp += string(xScale)+" "+string(yScale)+" "+string(zScale)+" ";
    brickTemp += string(round(1000*color_get_red(Color)/255)/1000)+" ";
    brickTemp += string(round(1000*color_get_green(Color)/255)/1000)+" ";
    brickTemp += string(round(1000*color_get_blue(Color)/255)/1000)+" ";
    brickTemp += string(Alpha);
    buffer_write_string(global.BUFFER, brickTemp+eol);
    if(Name != "") {
        buffer_write_string(global.BUFFER, chr(9)+"+NAME "+string(brickID)+eol);
    }
    if(Rotation != 0) {
        buffer_write_string(global.BUFFER, chr(9)+"+ROT "+string(Rotation)+eol);
    }
    if(Shape != "") {
        buffer_write_string(global.BUFFER, chr(9)+"+SHAPE "+string(Shape)+eol);
    }
    
    if(NorthSticker != "") {
        buffer_write_string(global.BUFFER, chr(9)+"+NSTICKER "+string(NorthSticker)+eol);
    }
    if(NorthSticker != "") {
        buffer_write_string(global.BUFFER, chr(9)+"+ESTICKER "+string(EastSticker)+eol);
    }
    if(SouthSticker != "") {
        buffer_write_string(global.BUFFER, chr(9)+"+SSTICKER "+string(SouthSticker)+eol);
    }
    if(WestSticker != "") {
        buffer_write_string(global.BUFFER, chr(9)+"+WSTICKER "+string(WestStiker)+eol);
    }
    
    if(Model != "") {
        buffer_write_string(global.BUFFER, chr(9)+"+MODEL "+string(Model)+eol);
    }
    
    if(LightRange > 0) {
        var r,g,b;
        r = string(round(1000*color_get_red(LightColor)/255)/1000)+" ";
        g = string(round(1000*color_get_green(LightColor)/255)/1000)+" ";
        b = string(round(1000*color_get_blue(LightColor)/255)/1000)+" ";
        buffer_write_string(global.BUFFER, chr(9)+"+LIGHT "+r+g+b+string(LightRange)+eol);
    }
    
    if(Collision == false) {
        buffer_write_string(global.BUFFER, chr(9)+"+NOCOLLISION"+eol);
    }
}
