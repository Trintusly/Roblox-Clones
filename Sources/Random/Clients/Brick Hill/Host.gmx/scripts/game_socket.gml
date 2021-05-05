//Create and test a TCP socket
var listeningsocket,socket,s,connected,try;
console("Creating sockets and sleeping...");
listeningsocket = listeningsocket_create();
listeningsocket_start_listening(listeningsocket, false, global.PORT, global.LAN);

postGame = -1;

socket = socket_create();
for(try = 0; try <= 3; try += 1) {
    socket_connect(socket, global.IP, global.PORT);
    s = socket_get_state(socket);
    while(s == socket_state_connecting) {
        socket_update_read(socket);
        s = socket_get_state(socket);
    }
    socket_destroy(socket);
    if s == socket_state_connected {
        console("Connected; Port "+string(global.PORT)+" open");
        break;
    } else {
        if(try == 3) {
            console("Couldn't connect; Port"+string(global.PORT)+" closed");
            show_message("Error \#4:#Port "+string(global.PORT)+" closed, attempting to find UPNP devices");
            
            devices = upnp_discover(0);
            if(devices == 0) {
                get_string("No UPNP devices found. You may have to port forward. You can follow our guide by visiting this URL.", "https://blog.brick-hill.com/how-to-portforward-and-host-games/");
                game_end();
                exit;
            } else {
                forward = upnp_forward_port(global.PORT,global.PORT,"TCP","0");
                if(forward != 0) {
                    show_message("Binding failed");
                    game_end();
                    exit;
                }
            }
        } else {
            console("Couldn't connect; retrying ("+string(try)+")");
        }
    }
}

global.BUFFER = buffer_create();

return listeningsocket;
