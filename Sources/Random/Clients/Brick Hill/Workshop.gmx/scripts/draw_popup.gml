// draw_popup()
if popup {
    if keyboard_check_pressed(vk_escape) {
        popup = 0;
    }
    
    switch popup_frame {
        case "color":
            popup_paint();
            break;
        case "publish":
            show_message("Publishing to the site has been removed.")
            popup = 0
            exit;
            break;
        case "splash":
            popup_splash();
            break;
    }
}
