// clientTopPrint(message,time);
var topPrint;
if instance_number(obj_topPrint) == 0 {
    topPrint = instance_create(0,0,obj_topPrint);
    topPrint.text = argument0;
    topPrint.stop = current_time+1000*argument1;
} else {
    obj_topPrint.text = argument0;
    obj_topPrint.stop = current_time+1000*argument1;
}
