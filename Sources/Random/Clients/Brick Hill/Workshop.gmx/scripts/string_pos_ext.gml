//argument0 - substring
//argument1 - string
//argument2 - number (1=first;2=second,3=third,etc.)

var i,count;
count=0;

if(string_count(argument0,argument1)<argument2) return(-1);

for(i=1;i<=string_length(argument1);i+=1){
   if(string_char_at(argument1,i)==argument0){
      count+=1;
      if(count==argument2){
         return(i);
      }
   }
}

return(-1);
