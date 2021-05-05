// environmentSetWeather(weather)
switch argument0 {
    case "snow":
        with obj_client {
            buffer_clear(global.BUFFER);
            buffer_write_uint8(global.BUFFER, 7);
            buffer_write_string(global.BUFFER, "WeatherSnow");
            socket_write_message(SOCKET, global.BUFFER);
        }
        obj_server.Weather = "snow";
        break;
    case "rain":
        with obj_client {
            buffer_clear(global.BUFFER);
            buffer_write_uint8(global.BUFFER, 7);
            buffer_write_string(global.BUFFER, "WeatherRain");
            socket_write_message(SOCKET, global.BUFFER);
        }
        obj_server.Weather = "rain";
        break;
    case "sun":
        with obj_client {
            buffer_clear(global.BUFFER);
            buffer_write_uint8(global.BUFFER, 7);
            buffer_write_string(global.BUFFER, "WeatherSun");
            socket_write_message(SOCKET, global.BUFFER);
        }
        obj_server.Weather = "sun";
        break;
}
