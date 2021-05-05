// history_add(name,value)
obj_control.unsaved = true;
ds_list_add(obj_control.history,argument0);
ds_list_add(obj_control.hist_val,argument1);
ds_list_add(obj_control.hist_time,image_index);
if !obj_control.r {
    ds_list_clear(obj_control.redoList);
    ds_list_clear(obj_control.redoValue);
}
