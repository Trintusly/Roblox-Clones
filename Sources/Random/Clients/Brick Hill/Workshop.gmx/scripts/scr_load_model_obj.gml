
/*
    scr_load_model_obj(model_file,material_file[optional]);
 
    argument0: Path to the obj file (.obj)
    argument1: (optional): Path to the materialfile (.mtl)
   
returns: 3D model
 
    Make sure that the imported model only consists of triangles!
*/
var file;
file = file_text_open_read(argument[0]);
 
var v_listX,v_listY,v_listZ,vt_listX,vt_listY,vn_listX,vn_listY,vn_listZ;
 
var vertexColor;
vertexColor = c_white;
 
v_listX = ds_list_create();
v_listY = ds_list_create();
v_listZ = ds_list_create();
 
vt_listX = ds_list_create();
vt_listY = ds_list_create();
vt_listZ = ds_list_create();
 
vn_listX = ds_list_create();
vn_listY = ds_list_create();
vn_listZ = ds_list_create();
 
var model;
model = d3d_model_create();
d3d_model_primitive_begin(model,pr_trianglelist);
 
var row,nx,ny,nz,tx,ty,sx,vx,vy,vz;
 
while (file_text_eof(file)==false){
    row = file_text_read_string(file);
   
    if(string_char_at(row,1) != '#'){ //if the first character is not a comment
 
        switch(string_char_at(row,1)){
            case 'v':
           
                switch(string_char_at(row,2)){
                    case 'n':
                        row=string_delete(row,1,string_pos(" ",row));
                        nx=real(string_copy(row,1,string_pos(" ",row)));
                        row=string_delete(row,1,string_pos(" ",row));
                        ny=real(string_copy(row,1,string_pos(" ",row)));
                        row=string_delete(row,1,string_pos(" ",row));
                        nz=real(string_copy(row,1,string_length(row)));
                   
                        ds_list_add(vn_listX,nx);
                        ds_list_add(vn_listY,ny);
                        ds_list_add(vn_listZ,nz);  
                        break;
               
                    case 't':
                        row=string_delete(row,1,string_pos(" ",row));
                        tx=real(string_copy(row,1,string_pos(" ",row)));
                        row=string_delete(row,1,string_pos(" ",row));
                        ty=1-real(string_copy(row,1,string_length(row)));
                   
                        ds_list_add(vt_listX,tx);
                        ds_list_add(vt_listY,ty);
                        break;
               
               
                    default:
                        row=string_delete(row,1,string_pos(" ",row));
                        vx=real(string_copy(row,1,string_pos(" ",row)));
                        row=string_delete(row,1,string_pos(" ",row));
                        vy=real(string_copy(row,1,string_pos(" ",row)));
                        row=string_delete(row,1,string_pos(" ",row));
                        vz=real(string_copy(row,1,string_length(row)));
                   
                        ds_list_add(v_listX,vx);
                        ds_list_add(v_listY,vy);
                        ds_list_add(v_listZ,vz);
                        break;
               
                }
            break;
           
            case 'f':
           
                var points;
                
                points=real_string_split(row, " ");
                
                var i;
                for(i = 2; i < ds_list_size(points)-1; i+=1) {
                    var f;
                    f[0] = ds_list_find_value(points, 1);
                    f[1] = ds_list_find_value(points, i);
                    f[2] = ds_list_find_value(points, i+1);

                    var p,z,e1,e2,e3;
                    p=0;
                    repeat(3) {
                        z = f[p];
    
                        z=string_delete(z,0,string_pos("/",z));
                        e1=string(string_copy(z,1,string_pos("/",z)-1));
                        z=string_delete(z,1,string_pos("/",z));
                        e2=string(string_copy(z,1,string_pos("/",z)-1));
                        z=string_delete(z,1,string_pos("/",z));
                        e3=string(string_copy(z,1,string_length(z)));
                    
                        p+=1;
                        
                        e1 = real(e1)-1;
                        e2 = real(e2)-1;
                        e3 = real(e3)-1;
                    
                        d3d_model_vertex_normal_texture_color(
                            model,
                            ds_list_find_value(v_listX,e1),
                            ds_list_find_value(v_listY,e1),
                            ds_list_find_value(v_listZ,e1),
                            ds_list_find_value(vn_listX,e3),
                            ds_list_find_value(vn_listY,e3),
                            ds_list_find_value(vn_listZ,e3),
                            ds_list_find_value(vt_listX,e2),
                            ds_list_find_value(vt_listY,e2),
                            vertexColor,
                            1
                        );
                    }
                }
                
                break;
        }
       
    }
    file_text_readln(file);
 
}
 
file_text_close(file);
 
d3d_model_primitive_end(model);
 
//delete lists
ds_list_destroy(v_listX);
ds_list_destroy(v_listY);
ds_list_destroy(v_listZ);
ds_list_destroy(vt_listX);
ds_list_destroy(vt_listY);
ds_list_destroy(vn_listX);
ds_list_destroy(vn_listY);
ds_list_destroy(vn_listZ);
 
return model;


