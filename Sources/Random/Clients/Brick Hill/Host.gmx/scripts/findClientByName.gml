// findClientByName(string name)
with obj_client {
    if(string_pos(argument0,name) == 1) {
        return id;
    }
}
return 0;
