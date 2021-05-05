/// string_split(:string, delimiter:string, list<string>):list<string>
var s, d, r, p, dl;
s = argument0;
d = argument1;
r = ds_list_create();
p = string_pos(d, s);
dl = string_length(d);
if (dl) while (p) {
    p -= 1;
    ds_list_add(r, string_copy(s, 1, p));
    s = string_delete(s, 1, p + dl);
    p = string_pos(d, s);
}
ds_list_add(r, s);
return r;
