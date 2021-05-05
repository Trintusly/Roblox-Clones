// open
if control_reset() {
    load_file(get_open_filename("brick file|*.brk", ""));
    unsaved = 0;
}
