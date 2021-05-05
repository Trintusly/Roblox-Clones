// playerRespawn(id player)
var spawnPos, client;
client = argument0;
client.alive = true;

spawnPos = pickSpawn(client);
playerTranslate(client, string_split(spawnPos," ",0), string_split(spawnPos," ",1), real(string_split(spawnPos," ",2))+1);
onSpawn(client);
