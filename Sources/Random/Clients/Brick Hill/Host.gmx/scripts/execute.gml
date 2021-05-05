// execute(script,[arg0,arg1,...])
var scr_name;
scr_name = string_lower(argument0);
with obj_script {
    if name == scr_name {
        for(i=1; i<argument_count; i+=1) {
            arg[i-1] = argument[i];
        }
        
        execute_string(script);
    }
}
