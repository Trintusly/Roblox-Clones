<?php

require("/var/www/html/api/rest.php");
require("/var/www/html/api/shop/shop.php");

class admin extends shop {

	function approve ( $itemId, $adminId ) {
		if ($this->itemExists($itemId)) {
			/*if($this->tooFast(0))
			{
				throw new Exception("You are approving items too fast");
			}*/
			$this->updateFast();
			$update =  $this->update_("items", ["verified" => "1"], ["id" => $itemId]);

				if ($update) {
					$this->updateAdminPoints(1);
					return $this->log($adminId,$itemId,"approved", "item");
				}
			return false;
		}
		throw new Exception ("Invalid item");
	}

	function decline ( $itemId, $adminId ) {
		if ($this->itemExists($itemId)) {
			$update = $this->update_("items", ["verified" => "-1"], ["id" => $itemId]);
			if ($update) {
				$this->updateAdminPoints(1);
				return $this->log($adminId,$itemId,"declined","item");
			}
			return false;
		}
		throw new Exception ("Invalid item");
	}

	function deleteComment($commentId, $adminId = -1) {
		$comment = $this->getComment($commentId);
		if ($comment) {
			$update = $this->update_("comments", ["deleted" => "1"], ["id" => $comment['id']]);

			if ($update) {
				return $this->log($adminId,$commentId,"deleted","comment");
			}
		} else {
			Throw new Exception("Comment does not exist");
		}
	}

	/*
	Action messages should be formatted like so
		- past tense verb
		EX:
		- banned
		- approved
		- declined
	*/
	function log ($adminId, $affectedId, $action, $type = "unknown") {
		//return ["user" => $adminId, "affected" => $affectedId, "msg" => $action, "type" => $type ];
		return $this->insert("admin_logs", ["user" => $adminId, "affected" => $affectedId, "msg" => $action, "type" => $type ]);
	}

	function getLogs ( array $where = [], $page = 1, $perPage = 10, $total = false) {

		$limit = $this->page($page, $perPage);
		$sql = ($total) ? "SELECT COUNT(*) as total FROM admin_logs " : "SELECT * FROM admin_logs ";
		$values = [];

		if (!empty($where)) {

			$sql .="WHERE ";
			$count = 0;
			//var_dump($where);
			foreach ($where as $column => $value) {
				if (is_array($value)) {
					$sql .= (($count > 0) ? "AND " : "") . $value[0] . " ".$value[1]." ? ";
					$values[] = $value[2];
				} else {
					$sql .= (($count > 0) ? "AND " : "") . $column . " = ? ";
					$values[] = $value;
				}
				$count++;
			}

			$sql .=  (!$total) ? "LIMIT ".$limit[0] . "," . $limit[1] . ";" : "";
			$result = $this->query($sql, $values)->fetchAll(PDO::FETCH_ASSOC);
		} else {
			//return "SELECT * FROM admin_logs LIMIT " .$limit[0] . "," . $limit[1] . " ORDER BY id DESC;";

			$sql = ($total) ? "SELECT COUNT(*) as total FROM admin_logs" : "SELECT * FROM admin_logs ORDER BY id DESC LIMIT " .$limit[0] . "," . $limit[1] . ";";
			$result = $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		}
		return $result;

	}

	function ban () {

	}

}

$admin = new admin;
