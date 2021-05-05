// rayCast()
convertPrepare(obj_client.CamXPos,obj_client.CamYPos,obj_client.CamZPos,obj_client.CamXTo,obj_client.CamYTo,obj_client.CamZTo,0,0,1,obj_client.FOV,room_width/room_height);
convert_2d_z(mouse_x,mouse_y,obj_client.CamZPos-1);
MxRay1 = x_3d;
MyRay1 = y_3d;
MzRay1 = obj_client.CamZPos-1;
convert_2d_z(mouse_x,mouse_y,obj_client.CamZPos+1);
MxRay2 = x_3d;
MyRay2 = y_3d;
MzRay2 = obj_client.CamZPos+1;
if !ray_find(MxRay1,MyRay1,MzRay1,MxRay2,MyRay2,MzRay2) {MxRay = 0; MyRay = 0; MzRay = 0;}
ray_cast();
MxRay = ray_x;
MyRay = ray_y;
MzRay = ray_z;

obj_client.lookingAtXPos = MxRay;
obj_client.lookingAtYPos = MyRay;
obj_client.lookingAtZPos = MzRay;
