<?php
require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/community/class.php");

$look_for = $bop->query("SELECT community_member.id, community_member_tags.perm FROM community_member_tags INNER JOIN community_member ON community_member.tag=community_member_tags.num AND community_member.perm <> community_member_tags.perm AND community_member.cid = community_member_tags.cid", [], true);
foreach($look_for as $r)
{
  $bop->update_("community_member", ["perm" => $r['perm']], ["id" => $r['id']]);
}
?>
