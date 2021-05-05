// playerAddDamage(id player, int damage)
with argument0 {
    Health = max(0,Health-argument1);
    if(Health <= 0) {
        playerKill(id);
    }
}
