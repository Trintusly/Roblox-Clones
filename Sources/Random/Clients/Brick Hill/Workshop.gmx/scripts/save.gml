// save()
if(project_path == "") {
    save_file(get_save_filename("brick file|*.brk", ""));
} else {
    save_file(project_path);
}
