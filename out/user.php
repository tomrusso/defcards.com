<?
	# TODO: Figure out if we want to send expires / cache-control
	# headers.  For now we'll just let the browser decide.
	include "/home/wanderin/defcard-src/php_include/card.php";
	$user_id = $_REQUEST['id'];

	# Make sure the id we're given is a number.
	if(!is_numeric($user_id))
	{
		exit("FAILURE: user ID not numeric");
	}

	# Check to see if the user exists, and if so exit without
	# querying facebook.
	$db = get_db();
	$sql = "SELECT * FROM users where user_id=%s";
	$result = mysql_query(sprintf($sql, db_quote($user_id)));

	if(mysql_num_rows($result))
	{
		exit("USER EXISTS");
	}

	# Make a query to facebook to get the user's info.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/" . $user_id);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);

	if(!$response)
	{
		exit("FAILED TO CONTACT FACEBOOK");
	}

	$user_info = json_decode($response, true);
	$user_name = $user_info['name'];

	if(!$user_name)
	{
		exit("FAILURE: No user name returned");
	}

	# Insert the user's ID# and name into the DB.
	$sql = "INSERT INTO users (user_id, name) VALUES (%s, '%s')";
	mysql_query(sprintf($sql, db_quote($user_id), db_quote($user_name)));

	# Output the result.
	if(mysql_error())
	{
		exit("FAILURE: " . mysql_error());
	}
	else
	{
		exit("SUCCESS " . $user_id . " " . $user_name);
	}
?>
