<?php
//echo "window.location = '/maintenance.php'";
if (isset($session)) {
	if ($session) {
		session_start();
	}
} else {
	session_start();
}
//BOPIMO CLASS 2018 COMMENTED
require_once("/var/www/html/render-testing/render-class.php");
if(!isset($bop)) {
	class bopimo {
		public $pdo = false;

		public function __construct () {
			try {
				$this->pdo = new PDO( 'mysql:host=127.0.0.1;dbname=bopimo', 'root', ',kn9x2?.!\mfJAW?' ); //declare PDO
			} catch (Exception $e) {
				die();
			}
		}
		/*
		BASIC FUNCTIONS
		*/
		public function query( string $query, $values = false, bool $fetch_all = false )
		{
			//$bop->query("SELECT * FROM test WHERE column1 = ?", [1], false);
			try {
				$pdo = $this->pdo;
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //idk

				if( $values ) //if values exist, bind to query
				{
					$query = $pdo->prepare($query); //prepare statement
					$query->execute($values); //execute and bind
				} else {
					$query = $pdo->query($query); //just execute plain
				}

				if( $fetch_all )
				{
					return $query->fetchAll(PDO::FETCH_ASSOC); //return array with result
				} else {
					return $query; //return just query for other things
				}
			} catch ( PDOException $e )
			{
				return false;
			}

		}

		public function insert ( string $table, array $values )
		{
			$pdo = new PDO( 'mysql:host=127.0.0.1;dbname=bopimo', 'root', ',kn9x2?.!\mfJAW?' ); //declare PDO

			$binds = [];

			foreach($values as $row)
			{
				array_push($binds, "?");
			}
			unset($row);

			$columns_array = [];
			$values_array = [];

			foreach ($values as $a=>$b)
			{
				if($b == NULL)
				{
					array_push($values_array, "NULL");
				} else {
					array_push($values_array, $b);
				}
				array_push($columns_array, $a);
			}

			$columns_string = "`" . implode("`, `", $columns_array) . "`";
			$values_string = "'" . implode("', '", $values_array) . "'";
			$binds_string = implode(", ", $binds);

			$query = $pdo->prepare("INSERT INTO {$table} ({$columns_string}) VALUES({$binds_string});");
			try {
				$query->execute( $values_array );
				$id = $pdo->lastInsertId();
				$find = $this->query("SELECT {$columns_string} FROM {$table} WHERE id=?", [$id], false);
				$obj = (object) $find->fetchAll(PDO::FETCH_ASSOC);
				$obj->id = $id;

				return $obj;

			} catch( PDOException $e ) {
				throw new Exception( $e->getMessage() );
			}
		}

		/*public function update (string $table, array $where) {

			$columns = array_keys($where);
			$values = array_values($where);
			var_dump($values);
			return $this->update_($table, $columns, $where);

		}*/

		public function update_ ( string $table, array $values, array $where )
		{
			$pdo = new PDO( 'mysql:host=127.0.0.1;dbname=bopimo', 'root', ',kn9x2?.!\mfJAW?' );

			$binds = [];

			unset($count);

			$values_sql = [];
			$where_sql = [];
			$where_values = [];
			$all_values = [];
			foreach ($values as $a=>$b)
			{
				array_push($all_values, $b);
				array_push($values_sql, "`{$a}`=?");
			}
			unset($a, $b);

			foreach ($where as $a=>$b)
			{
				array_push($all_values, $b);
				array_push($where_sql, "`{$a}`='{$b}'");
				array_push($binds, "`{$a}`=?");

			}

			$values_query = implode(", ", $values_sql);
			$where_query = implode(" AND ", $where_sql);
			$binds_query = implode(" AND ", $binds);

			$query = $pdo->prepare("UPDATE {$table} SET {$values_query} WHERE {$binds_query}");
			return $query->execute($all_values);
		}

		public function avatar ( int $user_id )
		{
			return $this->look_for ("avatar", ["user_id" => $user_id]);
		}

		/*
		FUNCTIONS FOR BOPIMO
		*/


		public function look_for ( string $table, array $values, $limit = false )
		{
			$pdo = new PDO( 'mysql:host=127.0.0.1;dbname=bopimo', 'root', ',kn9x2?.!\mfJAW?' );
			$values_fixed = [];
			$true_values = [];
			$columns_fixed = [];
			$binds = [];
			$limit = (is_array($limit)) ? "LIMIT " . $limit[0] . "," . $limit[1] : ""; // Isaiah added (this sorry if you dislike it !! remove the comment if you are ok with it)

			foreach ($values as $a=>$b)
			{
				array_push($columns_fixed, "`{$a}`");
				array_push($true_values, $b);
				array_push($values_fixed, "`{$a}`='{$b}'"); //prepare sql
				array_push($binds, "{$a}=?"); //add question marks to bind paramaters
			}
			$values_sql = implode(" AND ", $values_fixed);
			$columns_sql = implode(", ", $columns_fixed);
			$binds_sql = implode(" AND ", $binds);
			$query = "SELECT * FROM `{$table}` WHERE {$binds_sql};";
			$query_debug = "SELECT * FROM `{$table}` WHERE {$values_sql} {$limit};";
			//return [$query];
			$exec = $this->query($query, $true_values, false);
			return ($exec->rowCount() == 0) ? false : (object) $exec->fetchAll(PDO::FETCH_ASSOC)[0];
		}

		public function delete ( string $table, array $values)
		{
			$pdo = new PDO( 'mysql:host=127.0.0.1;dbname=bopimo', 'root', ',kn9x2?.!\mfJAW?' );
			$values_fixed = [];
			$true_values = [];
			$columns_fixed = [];
			$binds = [];

			foreach ($values as $a=>$b)
			{
				array_push($columns_fixed, "`{$a}`");
				array_push($true_values, $b);
				array_push($values_fixed, "`{$a}`='{$b}'"); //prepare sql
				array_push($binds, "{$a}=?"); //add question marks to bind paramaters
			}
			$values_sql = implode(" AND ", $values_fixed);
			$columns_sql = implode(", ", $columns_fixed);
			$binds_sql = implode(" AND ", $binds);
			$query = "DELETE FROM `{$table}` WHERE {$binds_sql};";
			$query_debug = "DELETE FROM `{$table}` WHERE {$values_sql};";
			//return [$query];
			$exec = $this->query($query, $true_values, false);
			return true;
		}

		public function user_exists ( $value )
		{
			if(is_numeric($value))
			{
				$query = $this->query("SELECT COUNT(id) total FROM users WHERE id=?", [$value], true);
			} else {
				$query = $this->query("SELECT COUNT(id) as total FROM users WHERE username=?", [$value], true);
			}


			return ($query[0]['total'] > 0) ? true : false;
		}

		public function get_user ( int $id, $props = false )
		{
			//for getting all properties, user $bop->get_user(1);
			//for selecting columns, use $bop->get_user(1, ["username", "password"]);

			if(is_array($props)) //if it's an array then it's set
			{
				$props_query = implode(", ", $props); //combine props for query
				$query = $this->query("SELECT {$props_query} FROM users WHERE id=?;", [$id], false);
			} else {
				$query = $this->query("SELECT * FROM users WHERE id=?;", [$id], false);
			}

			if( !$this->user_exists($id) || !$query)
			{
				return false; //return false if user doesn't exist
			} else {
				$real = $query->fetchAll(PDO::FETCH_ASSOC);
				$real = $real[0];

				if(isset($real['id']))
				{
					$avatar = $this->avatar($real['id']);
					$real['avatar'] = $avatar->cache;
				}

				return (object) $real; //return array of user
			}

		}

		/*
		LOCAL FUNCTIONS FOR BOPIMO
		*/
		public function logged_in ()
		{
			if(!isset($_SESSION))
			{
				session_start();
			}
			return isset($_SESSION['id']);
		}
		// after changing every page that uses logged_in to loggedIn we will switch (camelCase better)
		function loggedIn() {
			return $this->logged_in();
		}

		public function local_info ( $props = false )
		{
			if ( $this->logged_in() )
			{
				return $this->get_user ( $_SESSION['id'], $props );
			}
		}

		public function usernameToId (string $username) {
			$pdo = $this->pdo;
			$username = $this->query("SELECT id FROM users WHERE username = ?", [$username], true);

			return ($username) ? $username[0]['id'] : false;
		}

		public function isAdmin () {
			if ($this->loggedIn()) {
				if ($this->local_info("admin")->admin > 0) {
					return true;
				}
			}
			return false;
		}

		public function tooFast ( int $limit = 35 )
		{
			$user = $this->local_info ( [ "lastaction" ] );
			return (time() - $user->lastaction < $limit) ? true : false;
		}

		public function updateFast ()
		{
			$user = $this->local_info ( [ "id" ] );
			$this->update_("users", ["lastaction" => time()], ["id" => $user->id]);
			return true;
		}

		public function timeAgo($ptime)
		{
		    $etime = time() - $ptime;

		    if ($etime < 1)
		    {
		        return 'Just now';
		    }

		    $a = array( 365 * 24 * 60 * 60  =>  'year',
		                 30 * 24 * 60 * 60  =>  'month',
		                      24 * 60 * 60  =>  'day',
		                           60 * 60  =>  'hour',
		                                60  =>  'minute',
		                                 1  =>  'second'
		                );
		    $a_plural = array( 'year'   => 'years',
		                       'month'  => 'months',
		                       'day'    => 'days',
		                       'hour'   => 'hours',
		                       'minute' => 'minutes',
		                       'second' => 'seconds'
		                );

		    foreach ($a as $secs => $str)
		    {
		        $d = $etime / $secs;
		        if ($d >= 1)
		        {
		            $r = round($d);
		            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
		        }
		    }
		}

		public function timeLeft($ptime)
		{
		    $etime = $ptime - time();

		    if ($etime < 1)
		    {
		        return 'Now';
		    }

		    $a = array( 365 * 24 * 60 * 60  =>  'year',
		                 30 * 24 * 60 * 60  =>  'month',
		                      24 * 60 * 60  =>  'day',
		                           60 * 60  =>  'hour',
		                                60  =>  'minute',
		                                 1  =>  'second'
		                );
		    $a_plural = array( 'year'   => 'years',
		                       'month'  => 'months',
		                       'day'    => 'days',
		                       'hour'   => 'hours',
		                       'minute' => 'minutes',
		                       'second' => 'seconds'
		                );

		    foreach ($a as $secs => $str)
		    {
		        $d = $etime / $secs;
		        if ($d >= 1)
		        {
		            $r = round($d);
		            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' left';
		        }
		    }
		}

		public function footer ()
		{
			require("/var/www/html/site/footer.php");
		}

		public function notFound()
		{
			require("/var/www/html/error/404.php");
		}

		public function adminLevel ( int $req )
		{
			return intval($this->get_user($req, ["admin"])->admin);
		}

		public function isAllowed (int $user, $req = 1 )
		{
			$user = $this->get_user($user, ["admin"]);
			return ($user->admin >= $req) ? true : false;
		}

		public function modString ( int $req )
		{
			(array) $levels = array(
				"Regular User",
				"Trial Moderator",
				"Moderator",
				"Administrator",
				"Major Administrator"
			);
			return $levels[$req];
		}

		public function bbCode($text) {
			// BBcode array
			$text = htmlentities($text);
			$find = array(
				'~\[b\](.*?)\[/b\]~s',
				'~\[i\](.*?)\[/i\]~s',
				'~\[u\](.*?)\[/u\]~s',

			);
			$replace = array(
				'<b>$1</b>',
				'<i>$1</i>',
				'<u>$1</u>',
			);

			$text = preg_replace($find,$replace,$text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(www.bopimo.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(www.gyazo.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(www.twitter.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(www.discord.gg)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(www.google.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(www.reddit.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(www.imgur.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(bopimo.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(gyazo.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(twitter.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(discord.gg)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(google.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(reddit.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$text = preg_replace('|([\w\d]*)\s?(https?://(imgur.com)[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2">$2</a>', $text);
			$emojis = array(
				":smile:",
				":sad:",
				":glasses:",
				":racing:",
				":mad:",
			);
			$emojis_r = array(
				"<i height='25' style='background-image:url(/emojis/smile-32.png);padding:5px 16px;margin:1px 2px;' title=':smile:'></i> ",
				"<i height='25' style='background-image:url(/emojis/sad-32.png);padding:5px 16px;margin:1px 2px;' title=':sad:'></i> ",
				"<i height='25' style='background-image:url(/emojis/glasses-32.png);padding:5px 16px;margin:1px 2px;' title=':glasses:'></i> ",
				"<i height='25' style='background-image:url(/emojis/racing-32.png);padding:5px 16px;margin:1px 2px;' title=':racing:'></i> ",
				"<i height='25' style='background-image:url(/emojis/mad-32.png);padding:5px 16px;margin:1px 2px;' title=':mad:'></i> ",
			);
			$text = str_replace($emojis, $emojis_r, $text);
			return $text;
		}

		/* csrf */

		public function generateCsrfToken () {
			$_SESSION['csrf'] = bin2hex(random_bytes(32));
			return true;
		}

		public function getCsrfToken() {
			if (isset($_SESSION["csrf"])) {
				return $_SESSION["csrf"];
			} else {
				return $this->generateCsrfToken();
			}
		}

		public function checkToken($check) {
			if (!is_array($check)) {
				if (hash_equals($_SESSION['csrf'], $check)) {
					return true;
				} else {
					return false;
				}
			}
		}

		public function ipInfo ($ip) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://v2.api.iphub.info/ip/' . $ip);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Key: NDAzODpNSWtJcllvZE1wQzZmQlRSaWtSWDQ3ZDQ4V3Z4clVzQg=="]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			return curl_exec($ch);
		}

		public function antiJake ( $string )
		{
			return (empty($string) || !is_string($string));
		}

		public function isInteger ( $int )
		{
			return(ctype_digit(strval($int)) || empty($int));
		}

		public function getCategories ( bool $adminOnly = false ) {
			if ($adminOnly) {
				return $this->pdo->query("SELECT * FROM item_categories WHERE admin_only = 0 ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return $this->pdo->query("SELECT * FROM item_categories ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
			}
		}

		public function cat2name ($cat) {

		$query = $this->query("SELECT * FROM item_categories WHERE id = ?",[$cat])->fetch(PDO::FETCH_ASSOC);
		if ($query) {
			return $query["name"];
		}

		return false;
		}

		public function cat2dir ($cat) {
			$category = $this->cat2name($cat);
			if ($category) {
				return str_replace('-', '', strtolower($category));
			}

			return false;
		}

		function getItem ($id) {
			$id = (int) $id;
			return $this->query("SELECT * FROM items WHERE id = ?", [$id])->fetchAll()[0];
		}

		public function isBanned ( int $uid )
		{
			if(!$this->user_exists( $uid ))
			{
				return true;
			}
			$find = $this->query("SELECT * FROM punishment WHERE user=? AND ended=0 ORDER BY level ASC LIMIT 0,1", [$uid]);
			if($find->rowCount() == 0)
			{
				return false;
			} else {
				return (object) $find->fetchAll()[0];
			}
		}

		public function isVerified ( int $uid )
		{
			$user = $this->get_user($uid);
			return ($user->verified == "1") ? true : false;
		}

		public function trueUsername ( int $uid )
		{
			if(!$this->user_exists($uid))
			{
				return false;
			}
			$user = $this->get_user($uid, ["username", "id", 'hidden']);
			if($user->hidden == 0 && !$this->isBanned($uid))
			{
				return htmlentities($user->username);
			} else {
				return "[bopimo " . $user->id . "]";
			}
		}
		public function updateAdminPoints( int $amount )
		{
			$user = $this->local_info(["id", "admin_points"]);
			$admin_points = (int) $user->admin_points;
			$this->update_("users", ["admin_points" => $admin_points + $amount], ["id" => $user->id]);
			return true;
		}
		public function uuid() {
		    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		        // 32 bits for "time_low"
		        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

		        // 16 bits for "time_mid"
		        mt_rand( 0, 0xffff ),

		        // 16 bits for "time_hi_and_version",
		        // four most significant bits holds version number 4
		        mt_rand( 0, 0x0fff ) | 0x4000,

		        // 16 bits, 8 bits for "clk_seq_hi_res",
		        // 8 bits for "clk_seq_low",
		        // two most significant bits holds zero and one for variant DCE1.1
		        mt_rand( 0, 0x3fff ) | 0x8000,

		        // 48 bits for "node"
		        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		    );
		}

		public function mail ( string $to, string $subject, string $message )
		{
			$headers .= "Organization: Bopimo\r\n";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			$headers .= "From: Bopimo Verification <noreply@bopimo.com>" . "\r\n" .
			"Reply-To: <noreply@bopimo.com>" . "\r\n" .
			"Errors-to: <noreply@bopimo.com>" . "\r\n" .
			"Return-Path: <noreply@bopimo.com>" . "\r\n" .
			"X-Mailer: PHP/" . phpversion() . "\r\n";

			mail($to, $subject, $message, $headers);
			return true;
		}

		public function notify ( int $userTo, string $msg, string $img, string $redirect)
		{
			$notification = $this->insert("notifications", [
				"user" => $userTo,
				"msg" => $msg,
				"img" => $img,
				"redirect" => $redirect,
				"time" => time()
			]);
		}
	}


	$bop = new bopimo;
}
?>
