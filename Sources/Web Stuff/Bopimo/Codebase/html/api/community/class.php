<?php
require("/var/www/html/site/bopimo.php");
class community extends bopimo {

  public function get ( int $id ) //Get a community
  {
    return $this->look_for("community", ["id" => $id]);
  }

  public function member ( int $cid, int $uid ) // Fetch a member, but also check if member is in group.
  {
    return $this->look_for("community_member", ["uid" => $uid, "cid" => $cid]);
  }

  public function tags ( int $cid ) // Fetch community tags
  {
    $community = $this->get($cid);
    if(is_bool($community))
    {
      return false;
    }
    $return = array();
    if($community->postable == "1")
    {
      $return['members'] = $this->query("SELECT * FROM `community_member_tags` WHERE cid=? AND perm=0", [$cid], true);
      $return['administrators'] = $this->query("SELECT * FROM `community_member_tags` WHERE cid=? AND perm=1", [$cid], true);
      $return['founder'] = $this->query("SELECT * FROM `community_member_tags` WHERE cid=? AND perm=2", [$cid], true);
    } else {
      $return['members'] = $this->query("SELECT * FROM `community_member_tags` WHERE cid=? AND perm=0", [$cid], true);
      $return['posters'] = $this->query("SELECT * FROM `community_member_tags` WHERE cid=? AND perm=1", [$cid], true);
      $return['administrators'] = $this->query("SELECT * FROM `community_member_tags` WHERE cid=? AND perm=2", [$cid], true);
      $return['founder'] = $this->query("SELECT * FROM `community_member_tags` WHERE cid=? AND perm=3", [$cid], true);
    }

    return $return;
  }

  function isImage ($img) {
		return (getimagesize($img)) ? true : false;
  }

  function createCommunity(string $name, string $description, string $tag, $postable, $open, $founder, $image) {
	  if(strlen($name) < 5 || strlen($name) > 35)
    {
      throw new Exception ("Community name must be 5 - 35 characters.");
    }
    if($open < 0 || $postable < 0 || $open > 1 || $postable > 1)
    {
      throw new Exception ("Invalid arguments.");
    }
    if(strlen($tag) < 3 || strlen($tag) > 6)
    {
      throw new Exception ("Community tag must be 3 - 6 characters.");
    }
    if(strlen($description) < 5 || strlen($description) > 5000)
    {
      throw new Exception ("Community description must be 5 - 5000");
    }
    $stripped = strtolower(str_replace(' ', '', $name));
    if(!ctype_alnum($stripped))
    {
      throw new Exception ("Community name cannot have any special characters.");
    }
    if(!ctype_alnum($tag))
    {
      throw new Exception ("Community tag cannot have any special characters.");
    }
    $lookForName = $this->look_for("community", ["stripped_name" => $stripped]);
    if(!is_bool($lookForName)) // LMAO ITS FOUND ALREADY TAKEN LOLOLOLOLLOL
    {
      throw new Exception ("Community name has already been taken.");
    }
    $lookForTag = $this->look_for("community", ["shorthand" => $tag]);
    if(!is_bool($lookForTag))
    {
      throw new Exception ("Community tag has already been taken.");
    }

    $founderRow = $this->get_user($founder);
    if(is_bool($founderRow))
    {
      throw new Exception ("You does not exist.");
    }

    $price = 25;
    if($founderRow->bop - $price < 0)
    {
      throw new Exception ("You cannot afford creating a group.");
    }

	if (!$this->isImage($image["tmp_name"]) || $image["size"] > 1000000) {
		throw new Exception("Invalid Image");
	}

    $imageName = uniqid() . uniqid(); // PAY ATTENTION TO THIS THIS IS IMAGE NAME

	move_uploaded_file($image["tmp_name"], "/var/www/storage/community/" . $imageName . ".png");

    $this->update_("users", ["bop" => $founderRow->bop - $price], ["id" => $founder]); //Update user bopibits
    try {
      $community = $this->insert("community", [
        "name" => $name,
        "stripped_name" => $stripped,
        "postable" => $postable,
        "cache" => $imageName,
        "desc" => $description,
        "pending" => "0",
        "founder" => $founder,
        "shorthand" => $tag,
        "open" => $open
      ]);
    } catch(Exception $e) {
      throw new Exception ( $e->getMessage() );
    }
    if($postable == 1)
    {
      $this->insert("community_member_tags", [
        "name" => "Members",
        "num" => "1",
        "cid" => $community->id,
        "perm" => "0"
      ]);
      $this->insert("community_member_tags", [
        "name" => "Administrators",
        "num" => "2",
        "cid" => $community->id,
        "perm" => "1"
      ]);
      $this->insert("community_member_tags", [
        "name" => "Founders",
        "num" => "3",
        "cid" => $community->id,
        "perm" => "2"
      ]);
      $this->insert("community_member", [
        "uid" => $founder,
        "cid" => $community->id,
        "tag" => "3",
        "perm" => "2"
      ]);
    } else {

      $this->insert("community_member_tags", [
        "name" => "Members",
        "num" => "1",
        "cid" => $community->id,
        "perm" => "0"
      ]);
      $this->insert("community_member_tags", [
        "name" => "Posters",
        "num" => "2",
        "cid" => $community->id,
        "perm" => "1"
      ]);
      $this->insert("community_member_tags", [
        "name" => "Administrators",
        "num" => "3",
        "cid" => $community->id,
        "perm" => "2"
      ]);
      $this->insert("community_member_tags", [
        "name" => "Founders",
        "num" => "4",
        "cid" => $community->id,
        "perm" => "3"
      ]);
      $this->insert("community_member", [
        "uid" => $founder,
        "cid" => $community->id,
        "tag" => "4",
        "perm" => "3"
      ]);
    }
    /* IMAGE STUFF HERE*/



  }

  public function deleteCommunity ( int $cid )
  {
    $community = $this->get($cid);
    if(is_bool($community))
    {
      throw new Exception ("Community not found.");
    }
    $this->delete("community", ["id" => $cid]);
    $this->delete("community_member", ["cid" => $community->id]);
  }

  public function members ( int $cid, $tag, $perm, int $page, int $limit)
  {
    if($page == 1)
    {
      $trueP = 0;
    } else {
      $trueP = $page * $limit - $limit;
    }
    $sql = "LIMIT {$trueP}," . $limit;
    $community = $this->get($cid);
    if(is_bool($community))
    {
      return false;
    }
    if($tag != false) //search for from tag
    {
      $tagR = $this->look_for("community_member_tags", [
        "cid" => $cid,
        "num" => $tag
      ]);
      if(is_bool($tagR)) //tag doesn't exist
      {
        return false;
      }
      return $this->query("SELECT * FROM `community_member` WHERE cid=? AND tag=? AND banned=0 {$sql}", [$cid, $tag], true);
    }
    if(!is_bool($perm)) {
      //return $sql;
      return $this->query("SELECT * FROM `community_member` WHERE cid=? AND perm=? AND banned=0 {$sql}", [$cid, $perm], true);
    }
  }

  public function getOwner ( int $cid ) //gets current owner
  {
    $community = $this->get($cid);
    if(is_bool($community))
    {
      return false;
    }
    if($community->postable == "1")
    {
      $member = $this->look_for("community_member", ["cid" => $cid, "perm" => "2"]);
    } else {
      $member = $this->look_for("community_member", ["cid" => $cid, "perm" => "3"]);
    }
    if(is_bool($member))
    {
      return false;
    }
    return $this->get_user($member->uid);
  }

  public function getMember ( int $cid, int $uid ) //get member in group, returns false if not in group
  {
    $community = $this->get($cid);
    if(is_bool($community))
    {
      return false;
    }
    $user = $this->get_user($uid);
    if(is_bool($user))
    {
      return false;
    }
    $member = $this->look_for("community_member", [
      "cid" => $cid,
      "uid" => $uid
    ]);
    if(is_bool($member))
    {
      return false;
    }
    return $member;
  }

  public function isCommunityBanned ( int $cid, int $uid )
  {
    $community = $this->get($cid);
    if(is_bool($community))
    {
      return false;
    }
    $member = $this->getMember($cid, $uid);
    if(is_bool($member))
    {
      return false;
    }
    return ($member->banned == "0") ? false : true;
  }

  public function isPending ( int $cid, int $uid )
  {
    $pending = $this->look_for("community_join_requests", ["uid" => $uid, "cid" => $cid]);
    return (is_bool($pending)) ? false : true;
  }

  public function numPerms ( int $cid, int $perm ) //Number of tags that have a specific permission
  {
    $count = $this->query("SELECT COUNT(*) FROM community_member_tags WHERE cid=? AND perm=?", [$cid, $perm])->fetchColumn();
    return $count;
  }

  public function getTag ( int $tid )
  {
    return $this->look_for("community_member_tags", ["id" => $tid]);
  }

  public function deleteTag ( int $tid )
  {
    $tag = $this->getTag($tid);
    if(is_bool($tag))
    {
      return false;
    }
    $community = $this->get($tag->cid);
    if($community->default_tag == $tag->num)
    {
      return false;
    }
    $count = $this->numPerms($tag->cid, $tag->perm);
    if($count - 1 <= 0)
    {
      return false;
    }

    $this->update_("community_member", ["tag" => $community->default_tag], ["tag" => $tag->num]);
    $this->delete("community_member_tags", ["id" => $tid]);
    return true;
  }

  public function updateTagPerm ( int $tid, int $perm )
  {
    $tag = $this->getTag($tid);
    if(is_bool($tag))
    {
      return false;
    }
    $count = $this->numPerms($tag->cid, $tag->perm);
    if($count - 1 <= 0)
    {
      return false;
    } else {
      $community = $this->get($tag->cid);
      if($community->postable == 1 && $perm > 2)//postable
      {
        return false;
      } elseif($community->postable == 0 && $perm > 3)
      {
        return false;
      }
      $this->update_("community_member_tags", ["perm" => $perm], ["id" => $tid]);
      $this->update_("community_member", ["perm" => $perm], ["tag" => $tag->num]);
      return true;
    }
  }

  public function createTag ( int $cid, string $name, string $perm )
  {
    $community = $this->get($cid);
    if(is_bool($community))
    {
      return false;
    }
    $count = $this->query("SELECT COUNT(*) FROM community_member_tags WHERE cid=?", [$cid])->fetchColumn();
    if($count > 15)
    {
      return false;
    }
    $count = $count + 1;
    $look = $this->look_for("community_member_tags", ["name" => $name, "cid" => $cid]);
    if(!is_bool($look))
    {
      return false;
    }
    $tag = $this->insert("community_member_tags", [
      "name" => $name,
      "num" => $count,
      "cid" => $cid,
      "perm" => $perm
    ]);
    return $tag;
  }

  public function approveMember ( int $pending )
  {
    $pend = $this->look_for("community_join_requests",
    [
      "id" => $pending
    ]);
    if(is_bool($pend))
    {
      return false;
    }
    $community = $this->get($pend->cid);
    $look = $this->look_for("community_member", [
      "uid" => $pend->uid,
      "cid" => $pend->cid
    ]);
    if(!is_bool($look))
    {
      return false;
    }
    $this->insert("community_member",
    [
      "uid" => $pend->uid,
      "cid" => $pend->cid,
      "tag" => $community->default_tag,
      "perm" => "0"
    ]);
    $this->delete("community_join_requests",
    [
      "id" => $pending
    ]);
    return true;
  }

  public function declineMember ( int $pid )
  {
    $pend = $this->look_for("community_join_requests",
    [
      "id" => $pid
    ]);
    if(is_bool($pend))
    {
      return false;
    }
    $community = $this->get($pend->cid);
    $look = $this->look_for("community_member", [
      "uid" => $pend->uid,
      "cid" => $pend->cid
    ]);
    if(!is_bool($look))
    {
      return false;
    }

    $this->delete("community_join_requests", ["id" => $pid]);
  }

  public function changeMemberTag ( int $uid, int $cid, int $tid )
  {
    $community = $this->get($cid);
    if(is_bool($community))
    {
      return false;
    }
    $tag = $this->getTag($tid);
    $this->update_("community_member", [
      "tag" -> $tag->num,
      "perm" -> $tag->perm
    ], [
      "uid" => $uid,
      "cid" => $community->id
    ]);
    return true;
  }
}

if(!isset($com))
{
  $com = new community;
}

?>
