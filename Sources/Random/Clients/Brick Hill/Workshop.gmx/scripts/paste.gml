// paste()
if page == page_world {
    if clipboard_has_text() {
        brick_select = paste_brick(clipboard_get_text());
    }
}
