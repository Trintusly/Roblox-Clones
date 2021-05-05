// control_create()
message_background(bkg_message);
message_caption(1,"Brick Hill Workshop");
message_text_font("Montserrat",11,c_white,0)
message_input_font("Montserrat",11,c_black,0)
message_input_color(c_white)
message_button_font("Montserrat",11,c_white,0)
message_button(spr_popupbutton);
message_size(350,150);

instance_create(0,0,obj_setsize);
window_set_size(display_get_width()-100,display_get_height()-100);
window_set_position((display_get_width()-display_get_width()+100)/2,50);

global.APPDATA = environment_get_variable("APPDATA")+"\Brick Hill";
if !directory_exists(global.APPDATA) {directory_create(global.APPDATA);}
global.SAVEPATH = environment_get_variable("USERPROFILE")+"\Documents";

properties_w=320;
settings_h=116;
script_shortcut = "";
right_panel_size=room_height;
scroll_top_size=room_width;
lighting=settings_lighting;
col_main=settings_color_background;
col_main_bar=settings_color_bar;
col_ground=settings_color_ground;
col_sky=settings_color_sky;
col_paint=settings_color_paint;
col_ambient=settings_color_ambient;
alpha_ground=1;
sun_intensity=400;
size_base=settings_size_baseplate;
page = page_world;
brick_xsize = 4;
brick_ysize = 4;
brick_zsize = 4;
brick_control = brick_transform;
camera_light = 0;
backup = current_time;

hide_bricks = true;

unsaved = false;
history = ds_list_create();
hist_val = ds_list_create();
hist_time = ds_list_create();
redoList = ds_list_create();
redoValue = ds_list_create();
redoTime = ds_list_create();
r = false;
u = false;

popup = true;
popup_drag = false;
popup_x = room_width/2;
popup_y = room_height/2;
popup_frame = "splash";

//paint
paint_popup_focus = "";
paint_popup_color = $0d00de;

//publish
account_username = "";
account_password = "";
publish_result = "";
gameCount = 0;
dropdown_publish = dropdown_create();

//splash
splash_popup = "Workshop V0.2.0.2 is released!"

splash_image = bkg_splash

/*
if splash_popup == "" {
    popup = false;
} else if splash_popup == "kill" {
    game_end();
    exit;
}
*/

//


brick_make_visible = true;
brick_rotation = 0;

game = true;

define_script_keywords();

script_editor = "";

scroll_up = scrollbar_create(1);
scroll_right = scrollbar_create(1);
scroll_script = scrollbar_create(1);
scroll_teams = scrollbar_create(1);
scroll_slots = scrollbar_create(1);
scroll_newbrick = 0;

scroll_top = scrollbar_create(0);

tab_bricks = true;
tab_world = false;
tab_teams = false;
tab_slots = false;

window_hover = "";
window_drag = "";
window_dragging = false;
window_drag_x = -1;
window_drag_y = -1;

project_name = "New Project";
project_path = "";
brick_select = -1;
brick_hover = -1;
slot_select = -1;

brick_selection = ds_list_create();

bkg_world = -1;
bkg_preview = -1;

script_textbox = textbox_create();

camera_create();

global.brickCount = 0;
global.brickList = ds_list_create();

global.teamList = ds_list_create();

global.slotList = ds_list_create();

GmnInit();

global.set=GmnCreate();
GmnSetWorldSize(global.set,-5000,-5000,-5000,5000,5000,5000);

baseplate_bound = GmnCreateBox(global.set,-size_base/2,-size_base/2,-0.1,0,0,0);
baseplate_body = GmnCreateBody(global.set,baseplate_bound);

//cmd stuff
var backup_loaded;
backup_loaded = false;
if file_exists(global.APPDATA+"\backup.brk") {
    prompt = show_message_ext("Workshop didn't close properly!#Would you like to recover your file?","Yes","No","");
    if prompt == 1 {
        load_file(global.APPDATA+"\backup.brk");
        project_name = "New Project";
        project_path = "";
        backup_loaded = true;
    }
}

if !backup_loaded {
    var i;
    for(i=0;i<=parameter_count();i+=1) {
        param[i] = parameter_string(i);
        if string_split_last(param[i],".",0) == "brk" {
            if string_pos("http",param[i]) == 0 {
                load_file(param[i]);
            } else {
                download(param[i], global.APPDATA+"\backup.brk");
                load_file(global.APPDATA+"\backup.brk");
                project_name = httprequest_urldecode(string_split_last(param[i],"/",0));
            }
            popup = false;
        }
    }
} else {
    popup = false;
}
