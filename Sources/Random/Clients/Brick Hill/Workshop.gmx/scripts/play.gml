// execute_program(prog,arg,wait)
var pn,pp;
pn = project_name;
pp = project_path;

save_file(temp_directory+"\backup.brk");

project_name = pn;
project_path = pp;

execute_program("Player.exe", "local/local/42480", 0)
