// delete()
if page == page_world {
    var b,brick,brickID;
    for(b = 0; b < ds_list_size(brick_selection); b += 1) {
        brick = ds_list_find_value(brick_selection,b);
        with brick {
            brickID = ds_list_find_index(global.brickList,self.id);
            ds_list_delete(global.brickList,brickID);
            GmnDestroyBody(global.set,body);
            instance_destroy();
        }
    }
    /*if instance_exists(brick_select) {
        with brick_select && ds_list_find_index(global.brickList,brick_select) != -1 {
            brickID = ds_list_find_index(global.brickList,self.id);
            ds_list_delete(global.brickList,brickID);
            GmnDestroyBody(global.set,body);
            instance_destroy();
        }
    }*/
    ds_list_destroy(brick_selection);
    brick_selection = ds_list_create();
    brick_select = -1;
    brick_hover = -1;
}
