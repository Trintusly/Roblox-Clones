ce = GmnCollisionGet();

while(ce!=0){

    global.xxobj1 = GmnCollisionGetObject(ce,0);

    global.xxobj2 = GmnCollisionGetObject(ce,1);
    
    if(global.xxobj1*global.xxobj2 != 0){
       if((instance_exists(global.xxobj1))and(instance_exists(global.xxobj1))){
              (global.xxobj1).colobj=global.xxobj2;
              (global.xxobj2).colobj=global.xxobj1;
              with(global.xxobj1){
                 if(instance_exists(colobj))   event_perform(ev_collision,colobj.object_index);
              }
              with(global.xxobj2){
                 if(instance_exists(colobj))   event_perform(ev_collision,colobj.object_index);
              }
       }
    }
    ce=GmnCollisionGetNext(ce);

}
