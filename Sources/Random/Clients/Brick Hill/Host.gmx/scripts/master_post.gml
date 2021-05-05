//Post our server to the Brick Hill master server
if(!global.LAN) {
    console("Posting to Master Server");
    postGame = httprequest_create();
    /*httprequest_set_post_parameter(postGame,"GAME",string(global.GAME_ID));
    httprequest_set_post_parameter(postGame,"PORT",string(global.PORT));
    httprequest_set_post_parameter(postGame,"PLAYERS",string(instance_number(obj_client)));*/
    httprequest_set_post_parameter(postGame, "GAME="+string(global.GAME_ID)
                                            +"&PORT="+string(global.PORT)
                                            +"&PLAYERS="+string(instance_number(obj_client))+"&","");
    
    httprequest_connect(postGame,"http://www.brick-hill.com/API/games/postServer",true);
    /*while httprequest_get_state(postGame) != 4 {
        httprequest_update(postGame);
        if(httprequest_get_state(postGame) == 5) {
            console("Error \#5: Cannot connect to Brick Hill");
            show_message("Error \#5:#Cannot connect to Brick Hill");
            break;
        }
    }
    httprequest_destroy(postGame);*/
}
POSTlast = current_time;
