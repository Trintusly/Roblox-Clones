// frustum_culling(x, y, z, radius)
// x, y, z = de positie van het object
// radius = de straal van de bounding sphere (stel dit groot genoeg in zodat je hele object erin past)
var xx, yy, zz;

if !hide_bricks {return true;}

/* CUSTOM CODE */ objectstotal += 1;

zz = global.frustum_culling_xto*(argument0-global.frustum_culling_xfrom)
    +global.frustum_culling_yto*(argument1-global.frustum_culling_yfrom)
    +global.frustum_culling_zto*(argument2-global.frustum_culling_zfrom);
if zz<global.frustum_culling_znear-argument3 or zz>global.frustum_culling_zfar+argument3 { /* CUSTOM CODE */ objectscut += 1;
    return false;
}

xx = global.frustum_culling_xcross*(argument0-global.frustum_culling_xfrom)
    +global.frustum_culling_ycross*(argument1-global.frustum_culling_yfrom)
    +global.frustum_culling_zcross*(argument2-global.frustum_culling_zfrom);
if abs(xx)>zz*global.frustum_culling_xtan+argument3*global.frustum_culling_xsec { /* CUSTOM CODE */ objectscut += 1;
    return false;
}

yy = global.frustum_culling_xup*(argument0-global.frustum_culling_xfrom)
    +global.frustum_culling_yup*(argument1-global.frustum_culling_yfrom)
    +global.frustum_culling_zup*(argument2-global.frustum_culling_zfrom);
if abs(yy)>zz*global.frustum_culling_ytan+argument3*global.frustum_culling_ysec { /* CUSTOM CODE */ objectscut += 1;
    return false;
}

return true;
