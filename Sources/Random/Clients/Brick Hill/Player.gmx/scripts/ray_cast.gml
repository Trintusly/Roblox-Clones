// ray_cast();
var pointx,pointy,pointz,dist;
MxRay = obj_client.CamXPos+(MxRay-obj_client.CamXPos)*100;
MyRay = obj_client.CamYPos+(MyRay-obj_client.CamYPos)*100;
MzRay = obj_client.CamZPos+(MzRay-obj_client.CamZPos)*100;
dist = GmnWorldRayCastDist(global.set,obj_client.CamXPos,obj_client.CamYPos,obj_client.CamZPos,MxRay,MyRay,MzRay);
pointx = obj_client.CamXPos+(MxRay-obj_client.CamXPos)*dist;
pointy = obj_client.CamYPos+(MyRay-obj_client.CamYPos)*dist;
pointz = obj_client.CamZPos+(MzRay-obj_client.CamZPos)*dist;

ray_x = pointx+0.1*(MxRay-obj_client.CamXPos)/max(1,abs(MxRay-obj_client.CamXPos));
ray_y = pointy+0.1*(MyRay-obj_client.CamYPos)/max(1,abs(MyRay-obj_client.CamYPos));
ray_z = pointz+0.1*(MzRay-obj_client.CamZPos)/max(1,abs(MzRay-obj_client.CamZPos));
