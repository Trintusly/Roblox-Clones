// frustum_culling(x, y, z, radius)
// x, y, z = de positie van het object
// radius = de straal van de bounding sphere (stel dit groot genoeg in zodat je hele object erin past)
var xx, yy, zz;

//if !hide_bricks {return true}
/* CUSTOM CODE */ objectstotal += 1;

zz = obj_client.frustum_culling_xto*(argument0-obj_client.frustum_culling_xfrom)
    +obj_client.frustum_culling_yto*(argument1-obj_client.frustum_culling_yfrom)
    +obj_client.frustum_culling_zto*(argument2-obj_client.frustum_culling_zfrom);
if zz<obj_client.frustum_culling_znear-argument3 or zz>obj_client.frustum_culling_zfar+argument3 { /* CUSTOM CODE */ objectscut += 1;
    return false;
}

xx = obj_client.frustum_culling_xcross*(argument0-obj_client.frustum_culling_xfrom)
    +obj_client.frustum_culling_ycross*(argument1-obj_client.frustum_culling_yfrom)
    +obj_client.frustum_culling_zcross*(argument2-obj_client.frustum_culling_zfrom);
if abs(xx)>zz*obj_client.frustum_culling_xtan+argument3*obj_client.frustum_culling_xsec { /* CUSTOM CODE */ objectscut += 1;
    return false;
}

yy = obj_client.frustum_culling_xup*(argument0-obj_client.frustum_culling_xfrom)
    +obj_client.frustum_culling_yup*(argument1-obj_client.frustum_culling_yfrom)
    +obj_client.frustum_culling_zup*(argument2-obj_client.frustum_culling_zfrom);
if abs(yy)>zz*obj_client.frustum_culling_ytan+argument3*obj_client.frustum_culling_ysec { /* CUSTOM CODE */ objectscut += 1;
    return false;
}

return true;
