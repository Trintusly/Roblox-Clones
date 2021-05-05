// dropdown_create()
var d;
if (!variable_global_exists("drop_count")) {
    globalvar drop_count;
    drop_count = 0;
}
drop_val[drop_count] = 0;
drop_open[drop_count] = 0;
drop_count += 1;
return drop_count-1;
