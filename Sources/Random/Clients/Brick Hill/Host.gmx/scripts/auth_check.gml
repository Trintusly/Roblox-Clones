// auth_check(username, ip, user_id);
var authCheck,response,user_id,authURL,ip;
console("Auth Check: "+argument0);
if argument1 == "127.0.0.1" || string_pos("192.168.",argument1) == 1 {
    ip = global.IP;
} else {
    ip = argument1;
}

if(!global.LAN) {
    authURL = "http://brick-hill.com/API/games/auth2?USERNAME="+argument0+"&IP="+ip;
    
    authCheck = httprequest_create();
    httprequest_connect(authCheck,authURL,false);
    while httprequest_get_state(authCheck) != 4 {
        httprequest_update(authCheck);
        if(httprequest_get_state(authCheck) == 5) {
            console("Error \#5: Cannot connect to Brick Hill");
            break;
        }
    }
    
    response = httprequest_get_message_body(authCheck);
    if(string_pos("TRUE ",response) == 1) {
        user_id = string_split(response," ",1);
        if(string(argument2) == user_id) {
            console("Verified user!");
            if string_split(response," ",2) == "1" {
                Admin = true;
            }
            return true;
        } else {
            console("Could not verify user! (2)");
            return false;
        }
    } else if(string_pos("FALSE ",response) == 1) {
        console("Could not verify user! (1)");
        return false;
    } else {
        console("Could not verify user! (0)");
        return false;
    }
    
    httprequest_destroy(authCheck);
} else {
    console("LAN user");
    name = "(LAN)"+name;
    return true;
}
