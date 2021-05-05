<?php
//BOPIMO CLASS 2018 COMMENTED
require_once("/var/www/html/render-testing/render-class.php");
class bopimo {
	public $pdo = false;

	public function __construct () {
		$this->pdo = new PDO( 'mysql:host=127.0.0.1;dbname=bopimo', 'root', ',kn9x2?.!\mfJAW?' ); //declare PDO
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
			return $e;
		}
	}

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


	public function look_for ( string $table, array $values )
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
		$query = "SELECT * FROM `{$table}` WHERE {$binds_sql};";
		$query_debug = "SELECT * FROM `{$table}` WHERE {$values_sql};";
		$exec = $this->query($query, $true_values, false);
		return ($exec->rowCount() == 0) ? false : (object) $exec->fetchAll(PDO::FETCH_ASSOC)[0];
	}

	public function user_exists ( $value )
	{
		if(is_int($value))
		{
			$query = $this->query("SELECT id FROM users WHERE id=?", [$value], false);
		} else {
			$query = $this->query("SELECT id FROM users WHERE username=?", [$value], false);
		}


		return ($query->rowCount() == 0) ? false : true;
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

		if($query->rowCount() == 0)
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

	public function isAdmin () {
		if ($this->loggedIn()) {
			if ($this->local_info("admin")->admin > 0) {
				return true;
			}
		}
		return false;
	}

	public function tooFast ()
	{
		$user = $this->local_info ( [ "lastaction" ] );
		return (time() - $user->lastaction < 15) ? true : false;
	}


	public function timeAgo($ptime)
	{
	    $etime = time() - $ptime;

	    if ($etime < 1)
	    {
	        return '0 seconds';
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

	public function footer ()
	{
		require("/var/www/html/site/footer.php");
	}

	public function notFound()
	{
		require("/var/www/html/error/404.php");
	}

	public function isAllowed ( $req = 1 )
	{
		$user = $this->local_info();

		return ($user->admin >= $req) ? true : false;
	}
}

$bop = new bopimo;
?>
