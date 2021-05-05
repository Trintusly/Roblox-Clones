// clientBottomPrint(message,time);
var bottomPrint;
if instance_number(obj_bottomPrint) == 0 {
    bottomPrint = instance_create(0,0,obj_bottomPrint);
    bottomPrint.text = argument0;
    bottomPrint.stop = current_time+1000*argument1;
} else {
    obj_bottomPrint.text = argument0;
    obj_bottomPrint.stop = current_time+1000*argument1;
}
