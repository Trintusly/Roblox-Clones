//Find PORT and GAME ID based on CMD parameters
var i,next_param,param;
global.GAME_ID = -1;
global.PORT = 42480;
global.LAN = false;

next_param = "";
for(i=0;i<=parameter_count();i+=1) {
    param[i] = parameter_string(i);
    if(param[i] == "-port") {
        next_param = "PORT";
    } else if(param[i] == "-game") {
        next_param = "GAME";
    } else if(param[i] == "-map") {
        next_param = "MAP";
    } else if(param[i] == "-lan") {
        global.LAN = true;
    } else {
        switch(next_param) {
            case "PORT":
                if(string_digits(param[i]) == param[i]) {
                    global.PORT = real(param[i]);
                } else {
                    console("Error \#1: Bad Port ("+param[i]+")");
                }
                break;
            case "GAME":
                if(string_digits(param[i]) == param[i]) {
                    global.GAME_ID = real(param[i]);
                } else {
                    console("Error \#2: Invalid Game Data; quitting");
                    show_message("Error \#1:#Invalid Game Data; quitting");
                    game_end();
                    exit;
                }
                break;
            case "MAP":
                var ext_pos;
                ext_pos = string_length(param[i]) - 3;
                if string_pos("http://www.brick-hill.com/API/games/", param[i]) == 1 && string_pos(".brk",param[i]) == ext_pos {
                    download(param[i], global.APPDATA+"\download.brk");
                    loadBRK(global.APPDATA+"\download.brk");
                } else {
                    if file_exists(param[i]) {
                        loadBRK(param[i]);
                    } else {
                        show_message("File '" + param[i] + "' does not exist.");
                        game_end();
                    }
                }
                break;
        }
    }
}
console("Picked Port: "+string(global.PORT));
console("Picked Game: "+string(global.GAME_ID));
