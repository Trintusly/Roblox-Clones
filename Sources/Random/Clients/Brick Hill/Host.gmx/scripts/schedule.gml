// schedule(int milliseconds, string script, [arg1, arg2...])
var sch,arg;
sch = instance_create(0,0,obj_schedule);
sch.object = id;
sch.start = current_time;
sch.stop = current_time+argument0;
sch.script = argument1;/*+"(";
for(arg = 2; arg < argument_count; arg += 1) {
    sch.script += argument[arg+2];
}
sch.script += ")";*/
return sch;
