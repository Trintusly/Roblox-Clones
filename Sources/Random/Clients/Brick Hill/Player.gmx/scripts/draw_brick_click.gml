var brick;
brick = argument0

if (brick.clickable == 1) {
    if (brick.hovered == true) {
        with obj_client {
            convert_3d(brick.x+(brick.xs/2),brick.y+(brick.ys/2),brick.z+(brick.zs/2));
            draw_sprite(spr_hand, 0, x_2d, y_2d)
        }
    }
}
