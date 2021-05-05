// publish(game_id)
var httprequest, st, buffer, game;
game = argument0;

//Image
background_save(bkg_world, temp_directory+"\thumbnail.png");

buffer = buffer_create();
buffer_read_from_file(buffer, temp_directory+"\thumbnail.png");

httprequest = httprequest_create();
httprequest_set_post_parameter(httprequest, "game="+string(game)+"&", "");
httprequest_set_post_parameter_file(httprequest, "&", "&thumb=image.png", buffer);
httprequest_connect(httprequest, "http://www.brick-hill.com/API/games/publish", true);

while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
}

buffer_clear(buffer);
buffer_destroy(buffer);

//BRK
var old_name,old_path;
old_name = project_name;
old_path = project_path;
save_file(global.APPDATA+"\backup.brk");
project_name = old_name;
project_path = old_path;

buffer = buffer_create();
buffer_read_from_file(buffer, global.APPDATA+"\backup.brk");

httprequest = httprequest_create();
httprequest_set_post_parameter(httprequest, "game="+string(game)+"&", "");
httprequest_set_post_parameter_file(httprequest, "&", "&build=save.brk", buffer);
httprequest_connect(httprequest, "http://www.brick-hill.com/API/games/upload", true);

while true {
    httprequest_update(httprequest);
    st = httprequest_get_state(httprequest);
    if st=4 or st=5 {
        break;
    }
}

buffer_clear(buffer);
buffer_destroy(buffer);
