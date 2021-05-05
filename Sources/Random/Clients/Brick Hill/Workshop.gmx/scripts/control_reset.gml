// control_reset()
var prompt;

if unsaved {
    prompt = show_message_ext("You still have unfinished changes.#Would you like to save?","Yes","No","");
    switch prompt {
        case 0:
            return false;
            break;
        case 1:
            save();
            break;
        case 2:
            break;
    }
}

with obj_loadbrick {
    instance_destroy();
}
with obj_brick {
    d3d_light_enable(id,false);
    instance_destroy();
}
with obj_team {
    instance_destroy();
}
with obj_slot {
    instance_destroy();
}
GmnDestroy(global.set);
global.set=GmnCreate();
GmnSetWorldSize(global.set,-5000,-5000,-5000,5000,5000,5000);

global.brickCount = 0;
ds_list_destroy(global.brickList);
global.brickList = ds_list_create();

ds_list_destroy(global.teamList);
global.teamList = ds_list_create();

ds_list_destroy(global.slotList);
global.slotList = ds_list_create();

ds_list_clear(history);
ds_list_clear(hist_val);
ds_list_clear(hist_time);
ds_list_clear(redoList);
ds_list_clear(redoValue);
ds_list_clear(redoTime);

paint_popup_focus = "";

col_ground=settings_color_ground;
col_sky=settings_color_sky;
col_paint=settings_color_paint;
col_ambient=settings_color_ambient;
alpha_ground=1;
sun_intensity=400;
size_base=settings_size_baseplate;

project_name = "New Project";
project_path = "";
page = page_world;
brick_select = -1;

game = true;

return true;
