//This script is used to initialize gmi script links
//and set up gmi dll calls


nf("DLLInit",0);

external_call(global.__DLLInit__);

nf("set_script_transform_body",1);
gmi_set_script_transform_body(gmi_update_body);
