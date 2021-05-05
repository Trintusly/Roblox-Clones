// new_item(name)
var slot;
slot = instance_create(0,0,obj_slot);
slot.name = argument0;
slot.script = "";
slot.sticker = 0;
slot.onSpawn = 1;
ds_list_add(global.slotList,slot);
history_add("item",slot);
return slot;
