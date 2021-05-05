<?php
require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/community/class.php");

$look_for = $bop->query("SELECT community_member.*, community.postable FROM community_member INNER JOIN community ON community_member.cid=community.id AND community_member.uid=community.founder", [], true);
foreach($look_for as $r)
{
  if($r['perm'] == "0")
  {
    echo "perm equals 1, something's wrong <br>";
    if($r['postable'] == "1") {
      $getThing = $bop->look_for("community_member_tags", ["perm" => "2"]);
      $bop->update_("community_member", ["perm" => "2", "tag" => $getThing->num], ["id" => $r['id']]);
    } else {
      $getThing = $bop->look_for("community_member_tags", ["perm" => "3"]);
      $bop->update_("community_member", ["perm" => "3", "tag" => $getThing->num], ["id" => $r['id']]);
    }
  }
}
?>
