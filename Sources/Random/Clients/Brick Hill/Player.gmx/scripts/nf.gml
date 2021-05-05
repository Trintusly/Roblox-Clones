//argument0 - name
//Argument1 - args

var dllpath;
dllpath="C:\Program Files (x86)\Brick Hill\BRICK.dll" //working_directory+"\BRICK.dll";

str="global.__"+argument0+"__ = external_define("+'"'+dllpath+'"'+","+'"'+argument0+'"'+",dll_stdcall,ty_real,"+string(argument1);
for(i=0;i<argument1;i+=1){
   str+=",ty_real";
}
str+=");";
//get_string("Generated Code:",str);
//execute_string(str);
