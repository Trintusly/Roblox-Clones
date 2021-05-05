var fig;
fig = argument0

if power(fig.xPos-xPos,2)+power(fig.yPos-yPos,2)+power(fig.zPos-zPos,2) <= 10000 {
    if GmnWorldRayCastDist(global.set,CamXPos,CamYPos,CamZPos,fig.xPos,fig.yPos,fig.zPos+6*fig.zScale) == -1 {
        convert_3d(fig.xPos,fig.yPos,fig.zPos+6*fig.zScale);
        var xText,yText;
        xText = round(x_2d-string_width(fig.Speech)/2);
        yText = round(y_2d-string_height(fig.Speech)-10);
        draw_set_color(0);
        draw_set_alpha(0.4);
        draw_roundrect(xText-10,yText-10,xText+string_width(fig.Speech)+10,yText+string_height(fig.Speech)+10,0);
        draw_sprite_ext(spr_speech,0,xText+string_width(fig.Speech)/2,yText+string_height(fig.Speech)+11,1,1,0,1,0.4);
        
        draw_set_color(c_white);
        draw_set_alpha(1);
        draw_chat(xText,yText,fig.Speech);
    }
}
