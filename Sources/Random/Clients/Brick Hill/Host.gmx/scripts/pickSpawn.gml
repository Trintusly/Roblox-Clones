// pickSpawn(client) - Returns "x y z"
execute("pickSpawn",argument0);
/*
var brick, client, spawnCol, possSpawnCount, s;
client = argument0; //for teams in future
if client.team != -1 {
    spawnCol = client.team.Color;
    possSpawnCount = 0;
    for(s = 0; s < obj_server.spawnBrickCount; s += 1) {
        brick = obj_server.spawnBrick[s];
        if brick.Color == spawnCol {
            possSpawn[possSpawnCount] = brick;
            possSpawnCount += 1;
        }
    }
    if possSpawnCount > 0 {
        brick = possSpawn[floor(random(possSpawnCount))];
        return string(brick.xPos+brick.xScale/2)+" "+string(brick.yPos+brick.yScale/2)+" "+string(brick.zPos+brick.zScale);
    }
}

if obj_server.spawnBrickCount > 0 {
    brick = obj_server.spawnBrick[floor(random(obj_server.spawnBrickCount))];
    
    return string(brick.xPos+brick.xScale/2)+" "+string(brick.yPos+brick.yScale/2)+" "+string(brick.zPos+brick.zScale);
} else {
    return  string(random_range(-obj_server.BasePlateSize/2,obj_server.BasePlateSize/2))+" "+
            string(random_range(-obj_server.BasePlateSize/2,obj_server.BasePlateSize/2))+" "+
            string(random(obj_server.BasePlateSize/2));
}
