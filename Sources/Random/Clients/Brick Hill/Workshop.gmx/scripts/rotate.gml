// rotate();
if ds_list_size(brick_selection) > 0 {
    var XS;
    get_selection();
    rotPointX = (minX+(maxX-minX)/2);
    rotPointY = (minY+(maxY-minY)/2);
    if ((maxX-minX) mod 2 != 0 && (maxY-minY) mod 2 == 0) || ((maxX-minX) mod 2 == 0 && (maxY-minY) mod 2 != 0) {
        rotPointX = round(rotPointX);
        rotPointY = round(rotPointY);
    }
    
    brick_rotation += 90;
    
    for(b = 0; b < ds_list_size(brick_selection); b += 1) {
        bront = ds_list_find_value(brick_selection,b);
        
        bront.rotation += 90;
        if(bront.rotation > 360) {
            bront.rotation -= 360;
        }
        
        radius = point_distance(rotPointX,rotPointY,bront.x+bront.xs/2,bront.y+bront.ys/2);
        phase = point_direction(rotPointX,rotPointY,bront.x+bront.xs/2,bront.y+bront.ys/2)+90;
        
        xs1 = bront.xs;
        bront.xs = bront.ys;
        bront.ys = xs1;
        
        bront.x = (rotPointX+radius*cos(degtorad(phase))-bront.xs/2); //round
        bront.y = (rotPointY-radius*sin(degtorad(phase))-bront.ys/2); //round
        
        GmnDestroyBody(global.set,bront.body);
        bront.bound = GmnCreateBox(global.set,bront.xs,bront.ys,bront.zs,bront.xs/2,bront.ys/2,bront.zs/2);
        bront.body = GmnCreateBody(global.set,bront.bound);
    }
}
