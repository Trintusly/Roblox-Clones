// new_team(name,color)
var team;
team = instance_create(0,0,obj_team);
team.name = argument0;
team.color = argument1;
ds_list_add(global.teamList,team);
history_add("team",team);
return team;
