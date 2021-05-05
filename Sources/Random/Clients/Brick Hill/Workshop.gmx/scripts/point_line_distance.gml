/*
**  Usage:
**      point_line_distance(x1,y1,x2,y2,x3,y3,segment)
**
**  Arguments:
**      x1,y1      first end point of line
**      x2,y2      second end point of line
**      x3,y3      point to measuring from
**      segment    set to true to limit to the line segment
**
**  Returns:
**      the distance from the given point to a given line
**
**  GMLscripts.com
*/
{
    var x0,y0,x1,y1,x2,y2,x3,y3,dx,dy,t,segment;
    x1 = argument0;
    y1 = argument1;
    x2 = argument2;
    y2 = argument3;
    x3 = argument4;
    y3 = argument5;
    segment = argument6;
    dx = x2 - x1;
    dy = y2 - y1;
    if ((dx == 0) && (dy == 0)) {
        x0 = x1;
        y0 = y1;
    }else{
        t = ((x3 - x1) * dx + (y3 - y1) * dy) / (dx * dx + dy * dy);
        if (segment) t = min(max(0,t),1);
        x0 = x1 + t * dx;
        y0 = y1 + t * dy;
    }
    return point_distance(x3,y3,x0,y0);
}
