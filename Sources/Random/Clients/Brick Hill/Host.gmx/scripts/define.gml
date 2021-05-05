// define(name)
with obj_script {
    if name == string_lower(argument0) {
        script = "";
        return id;
    }
}

var s;
s = instance_create(0,0,obj_script);
s.name = string_lower(argument0);
s.script = "";

return s;
