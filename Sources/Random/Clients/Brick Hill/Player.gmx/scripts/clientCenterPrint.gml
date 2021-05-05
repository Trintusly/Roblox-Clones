// clientCenterPrint(message,time);
var centerPrint;
if instance_number(obj_centerPrint) == 0 {
    centerPrint = instance_create(0,0,obj_centerPrint);
    centerPrint.text = argument0;
    centerPrint.stop = current_time+1000*argument1;
} else {
    obj_centerPrint.text = argument0;
    obj_centerPrint.stop = current_time+1000*argument1;
}
