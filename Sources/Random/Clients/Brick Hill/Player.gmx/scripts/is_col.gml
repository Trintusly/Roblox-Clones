// is_col(x,y,height1,height2,xs  ,ys)
var fcol, bcol, dcol, h, i, j, isCol;
fcol = argument4/2;
bcol = argument5/2;
dcol = 0;
for (h = argument2; h <= argument3; h += 1/3;) {
    for (i = argument0-fcol; i <= argument0+fcol; i += 1) {
        for (j = argument1-bcol; j <= argument1+bcol; j += 1) {
            isCol = GmnWorldRayCastDist(global.set,i,j,h,i,j,h);
            if isCol != -1 {dcol = h-argument2; return true;}
        }
    }
    /*isCol[0] = GmnWorldRayCastDist(global.set,argument0+fcol,argument1+bcol,h,argument0+fcol,argument1+bcol,h);
    isCol[1] = GmnWorldRayCastDist(global.set,argument0-fcol,argument1-bcol,h,argument0-fcol,argument1-bcol,h);
    isCol[2] = GmnWorldRayCastDist(global.set,argument0+fcol,argument1-bcol,h,argument0+fcol,argument1-bcol,h);
    isCol[3] = GmnWorldRayCastDist(global.set,argument0-fcol,argument1+bcol,h,argument0-fcol,argument1+bcol,h);
    for (i = 0; i < 4; i += 1) {
        if isCol[i] != -1 {dcol = h-argument2; return true;}
    }*/
}
return false;
