// world_create()
GmnInit();
global.set = GmnCreate();
GmnSetWorldSize(global.set,-5000,-5000,-5000,5000,5000,5000);

GroundCol = GmnCreateBox(global.set,100,100,1,0,0,0);
Ground = GmnCreateBody(global.set,GroundCol);
GmnReleaseCollision(global.set,GroundCol);
GmnBodySetMassMatrix(Ground,0,0,0,0);
GmnBodySetPosition(Ground,0,0,-0.5);
