global.IP = "127.0.0.1";

global.PORT = 42480;

//Get game parameters

var param_num, params, host;

param_num = parameter_count();

if (param_num == 1) {
    params = parameter_string(1);

    token = string_split(params, "/", 0)
    
    host = string_split(params, "/", 1)
    
    if (host == "local") {
        global.IP = "127.0.0.1"
    } else {
        global.IP = host
    }
    
    global.PORT = real(string_digits(string_split(params, "/", 2)))
    
    return true
} else {
    show_message("Please launch from the site!")
    return false
}

/*
for(p=0; p < params; p+=1) {
    show_message(params[p])
}
*/


    /*
    if(string_pos("%20",param[i]) == 0) {
        if(param[i] == "-port") {
            next_param = "PORT";
        } else if(param[i] == "-ip") {
            next_param = "IP";
        } else if(param[i] == "-name") {
            next_param = "NAME";
        } else if(param[i] == "-user") {
            next_param = "USER";
        } else {
            switch(next_param) {
                case "PORT":
                    if(string_digits(param[i]) == param[i]) {
                        global.PORT = real(param[i]);
                    }
                    break;
                case "IP":
                    global.IP = param[i];
                    break;
                case "NAME":
                    name = param[i];
                    break;
                case "USER":
                    if(string_digits(param[i]) == param[i]) {
                        user_id = real(param[i]);
                    }
                    break;
            }
        }
    } else {
        httprequest_urldecode(param[i]);
        var i;
        for(p=0;p<string_count(" ",param[i]);p+=1) {
            param[i] = string_split(param[i]," ",i);
            if(param[i] == "-port") {
                next_param = "PORT";
            } else if(param[i] == "-ip") {
                next_param = "IP";
            } else if(param[i] == "-name") {
                next_param = "NAME";
            } else if(param[i] == "-user") {
                next_param = "USER";
            } else {
                switch(next_param) {
                    case "PORT":
                        if(string_digits(param[i]) == param[i]) {
                            global.PORT = real(param[i]);
                        }
                        break;
                    case "IP":
                        global.IP = param[i];
                        break;
                    case "NAME":
                        name = param[i];
                        break;
                    case "USER":
                        if(string_digits(param[i]) == param[i]) {
                            user_id = real(param[i]);
                        }
                        break;
                }
            }
        }
    }
    */
