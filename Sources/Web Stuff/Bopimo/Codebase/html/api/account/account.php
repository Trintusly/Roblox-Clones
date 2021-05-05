<?php

require("../shop/shop.php");
class account extends shop {

	function searchUsers($username = "", $page = 1, $perPage = 26, $total = false) {

		$this->pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

		$page = $this->page($page, $perPage);

		if ($total) {
			$query = $this->query("SELECT COUNT(id) as total FROM users WHERE username LIKE ?", ["%" . $username . "%"]);
		} else {
			$query = $this->query("SELECT u.username,u.id,u.bio, a.cache, a.headshot, u.lastseen FROM users as u, avatar as a WHERE  a.user_id = u.id AND u.username LIKE ? ORDER BY lastseen DESC LIMIT ?,? ", ["%" . $username . "%", $page[0], $page[1]]);
		}

		if ($query) {
			if ($query->rowCount() > 0) {
				$result = ($total) ? $query->fetchColumn() : $query->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			}
		}

		throw new Exception("No results");

	}

}

$account = new account();
