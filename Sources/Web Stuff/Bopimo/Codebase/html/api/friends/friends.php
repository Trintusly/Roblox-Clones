<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("/var/www/html/site/bopimo.php");
require("../rest.php");

class friends extends bopimo {
	
	public function acceptFriendRequest ( $to, $from ) {
		
	}
	
	public function declineFriendRequest ( $to, $from ) {
		//$this->friendRequest( $to, $from, "-1" );
	}
	
	public function friendRequest ( $to, $from, $status ) {
		$requestRow = $this->friendRequestExists($to, $from);
		if ($requestRow) {
			$update = $this->update_("friends", ["status" => $status, "to" => $to, "from" => $from], ["id" => $requestRow["id"]]);
			if ($update) {
				return true;
			}
		} else {
			$insert = $this->insert("friends", ["status" => $status, "to" => $to, "from" => $from]);
			if ($insert) {
				return true;
			}
		}
		return false;
	}
	
	public function friendRequestRow ($to, $from, $status = 1) {
		$friendRequest = $this->query("SELECT * FROM `friends` WHERE status = ? AND friends.from = ? AND friends.to = ?;", [$status, $from, $to]);
			if ($friendRequest) {
				if ($friendRequest->rowCount() > 0) {
					return $friendRequest->fetch(PDO::FETCH_ASSOC);
				}
			}
		return false;
	}
	
	public function friendRequestExists ( $to, $from ) {
		$friendRequest = $this->query("SELECT * FROM `friends` WHERE (friends.from = ? AND friends.to = ?) OR (friends.from = ? AND friends.to = ?);", [$to, $from, $from, $to]);
		if ($friendRequest) {
			if ($friendRequest->rowCount() > 0) {
				return $friendRequest->fetch(PDO::FETCH_ASSOC);
			}
		}
		return false;
	}
	
	public function getFriends ( $userId, $status = "accepted" ) {
		if ($this->user_exists($userId)) {
			switch ($status) {
				case "accepted":
					$getFriends = $this->query("SELECT * FROM friends WHERE friends.status = 1  AND (friends.to = ? OR friends.from = ?)", [ $userId, $userId]);
					break;
				case "pending":
					$getFriends = $this->query("SELECT * FROM friends WHERE friends.status = 0  AND friends.to = ?", [ $userId]);
					break;
				case "sent":
					$getFriends = $this->query("SELECT * FROM friends WHERE friends.status = 0  AND friends.from = ?", [ $userId]);
					break;
				case "any":
					$getFriends = $this->query("SELECT * FROM friends WHERE (friends.to = ? OR friends.from = ?)", [$userId,$userId]);
					break;
				case "declined":
					$getFriends = $this->query("SELECT * FROM friends WHERE friends.status = -1  AND (friends.to = ? OR friends.from = ?)", [ $userId, $userId]);
					break;
				default:
					throw new Exception("Invalid status type");
					break;
			}
			if ($getFriends) {
				if ($getFriends->rowCount() > 0) {
					return $getFriends->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			throw new Exception("No results");
		} 
		throw new Exception("Invalid User");
	}
	
	public function getFriendRequests ( $userId, $type = "outgoing" ) {
		
	}
	
}

$friends = new friends;