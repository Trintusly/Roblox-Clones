// frustum_culling_init(xfrom, yfrom, zfrom, xto, yto, zto, xup, yup, zup, angle, aspect, znear, zfar)
var d;

/* CUSTOM CODE */
globalvar objectscut, objectstotal;
objectscut = 0;
objectstotal = 0;
/* CUSTOM CODE */

obj_client.frustum_culling_xfrom = argument0;
obj_client.frustum_culling_yfrom = argument1;
obj_client.frustum_culling_zfrom = argument2;

obj_client.frustum_culling_xto = argument3-obj_client.frustum_culling_xfrom;
obj_client.frustum_culling_yto = argument4-obj_client.frustum_culling_yfrom;
obj_client.frustum_culling_zto = argument5-obj_client.frustum_culling_zfrom;
d = sqrt(obj_client.frustum_culling_xto*obj_client.frustum_culling_xto+obj_client.frustum_culling_yto*obj_client.frustum_culling_yto+obj_client.frustum_culling_zto*obj_client.frustum_culling_zto);
obj_client.frustum_culling_xto /= d;
obj_client.frustum_culling_yto /= d;
obj_client.frustum_culling_zto /= d;

obj_client.frustum_culling_xup = argument6;
obj_client.frustum_culling_yup = argument7;
obj_client.frustum_culling_zup = argument8;
d = obj_client.frustum_culling_xup*obj_client.frustum_culling_xto+obj_client.frustum_culling_yup*obj_client.frustum_culling_yto+obj_client.frustum_culling_zup*obj_client.frustum_culling_zto;
obj_client.frustum_culling_xup -= d*obj_client.frustum_culling_xto;
obj_client.frustum_culling_yup -= d*obj_client.frustum_culling_yto;
obj_client.frustum_culling_zup -= d*obj_client.frustum_culling_zto;
d = sqrt(obj_client.frustum_culling_xup*obj_client.frustum_culling_xup+obj_client.frustum_culling_yup*obj_client.frustum_culling_yup+obj_client.frustum_culling_zup*obj_client.frustum_culling_zup);
obj_client.frustum_culling_xup /= d;
obj_client.frustum_culling_yup /= d;
obj_client.frustum_culling_zup /= d;

obj_client.frustum_culling_xcross = obj_client.frustum_culling_yup*obj_client.frustum_culling_zto-obj_client.frustum_culling_zup*obj_client.frustum_culling_yto;
obj_client.frustum_culling_ycross = obj_client.frustum_culling_zup*obj_client.frustum_culling_xto-obj_client.frustum_culling_xup*obj_client.frustum_culling_zto;
obj_client.frustum_culling_zcross = obj_client.frustum_culling_xup*obj_client.frustum_culling_yto-obj_client.frustum_culling_yup*obj_client.frustum_culling_xto;

obj_client.frustum_culling_ytan = tan(degtorad(argument9)/2);
obj_client.frustum_culling_xtan = obj_client.frustum_culling_ytan*argument10;
obj_client.frustum_culling_xsec = sqrt(1+sqr(obj_client.frustum_culling_xtan));
obj_client.frustum_culling_ysec = sqrt(1+sqr(obj_client.frustum_culling_ytan));
obj_client.frustum_culling_znear = argument11;
obj_client.frustum_culling_zfar = argument12;
