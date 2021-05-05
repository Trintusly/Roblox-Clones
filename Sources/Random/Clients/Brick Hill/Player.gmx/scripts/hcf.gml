// hcf(a,b)
var a,b,t,gcm,lcm;
a = argument0;
b = argument1;

while (b != 0) {
    t = b;
    b = a mod b;
    a = t;
}

gcm = a;
lcm = (argument0*argument1)/gcm;

return gcm;
