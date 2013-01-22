<?
	# Constants for the event types.
	define("CREATED", 0);
	define("FOUND", 1);
	define("POST", 2);

	function get_db()
	{
		# Constants that control the connection process.
		$address = 'localhost';
		$user = 'wanderin_db';
		$password = 'hothead';
		$database_name = 'wanderin_def';

		# Connect to the db, select the right database, and return the db object.
		$db = mysql_connect($address, $user, $password);
		mysql_select_db($database_name, $db);
		return $db;
	}

	function db_quote($str)
	{
		# Quote if not a number or a numeric string.
		if (!is_numeric($mysql_string))
		{
			$str = mysql_real_escape_string($str);
		}
		return $str;
	}

	# TODO: Might want to put $user_id = "NULL" if not $user_id at the top of these functions.
	$event_sql = "INSERT INTO events (type, card_id_ref, user_id_ref, body) VALUES (%s, %s, %s, %s)";

	function create_card($user_id = "NULL")
	{
		global $event_sql;
		$db = get_db();
		mysql_query("START TRANSACTION");

		try
		{
			$sql = "INSERT INTO cards (private_id)  VALUES ('%s')";
			do
			{
				$priv_id = new_private_id();
				mysql_query(sprintf($sql, db_quote($priv_id)));
			}
			while(mysql_errno($db) == 1062);

			$card_public_id = mysql_insert_id();

			mysql_query(sprintf($event_sql, db_quote(CREATED), db_quote($card_public_id), db_quote($user_id), db_quote("NULL")));
		}
		catch(Exception $e)
		{
			mysql_query("ROLLBACK");
			throw $e;
		}

		mysql_query("COMMIT");
		return $priv_id;
	}

	function found($card_private_id, $user_id = "NULL")
	{
		global $event_sql;

		if(!confirm_private_id($card_private_id))
		{
			throw new Exception("Invalid ID");
		}

		$card_public_id = get_public_id($card_private_id);

		$db = get_db();
		mysql_query(sprintf($event_sql, db_quote(FOUND), db_quote($card_public_id), db_quote($user_id), db_quote("NULL")));
	}

	function save_post($text, $card_private_id, $user_id = "NULL")
	{
		global $event_sql;

		if(!confirm_private_id($card_private_id))
		{
			throw new Exception("Invalid ID");
		}

		$card_public_id = get_public_id($card_private_id);

		$sql = sprintf($event_sql, db_quote(POST), db_quote($card_public_id), db_quote($user_id), "'" . db_quote($text) . "'");

		$db = get_db();
		mysql_query($sql);
	}

	function new_private_id()
	{
		# The array of characters to make the private ID out of.  We leave out I, L, letter O, number 1
		# and number 0 to avoid confusion.
		$characters =	array('A','B','C','D','E','F','G','H','J','K','M','N','P','Q','R','S','T','U','V',
						      'W','X','Y','Z','2','3','4','5','6','7','8','9');
		
		$priv_id = "";
		for($i = 0; $i < 9; $i++)
		{
			$priv_id .= $characters[array_rand($characters)];
		}

		return $priv_id;
	}

	function confirm_private_id($priv_id)
	{
		$db = get_db();
		$sql = sprintf("SELECT * FROM cards WHERE private_id='%s'", db_quote($priv_id));
		$result = mysql_query($sql);
		return mysql_num_rows($result) == 1;
	}

	function get_public_id($priv_id)
	{
		$db = get_db();
		$sql = sprintf("SELECT public_id FROM cards WHERE private_id='%s'", db_quote($priv_id));
		$result = mysql_query($sql);
		$row = mysql_fetch_row($result);
		return $row[0];
	}
?>
