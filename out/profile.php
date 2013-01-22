<?
	include "/home/wanderin/defcard-src/php_include/card.php";
	$page = intval($_REQUEST['page']);
	if(!$page || $page < 1) { $page = 1; }
	$per_page = 10;

	$user_id = intval($_REQUEST['userID']);

	$db = get_db();
	$sql = "SELECT name FROM users WHERE user_id='" . db_quote($user_id) . "'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
?>
<html>
	<head>
		<title>defcards.com</title>
		<link href="styles.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="fb-root"></div>
		<script>
			// Hide the facebook login button and show the account link.
			function show_login()
			{
				document.getElementById('account').style.display = 'none';
				document.getElementById('fb-login').style.display = 'block';
			}

			// Hide the account link and show the facebook login button.
			function show_account()
			{
				document.getElementById('account').style.display = 'block';
				document.getElementById('fb-login').style.display = 'none';
			}

			// Set up the page when there is a logged in user.
			function user_logged_in(response)
			{
				// Show the account link and append the user id info to
				// its href.  TODO: May want to change this ...
				show_account();
				var account_link = document.getElementById('account_link');
				account_link.href += "?userID=" + response.authResponse.userID;

				// Add the user ID to the new card link if it exists.
				var new_card_link = document.getElementById('new_card_link');
				if(new_card_link)
				{
					new_card_link.href += "?userID=" + response.authResponse.userID;
				}

				// Store the user ID into the element w/ id=userID if it exists.
				var userID = document.getElementById("userID");
				if(userID)
				{
					userID.value = response.authResponse.userID;
				}

				// Save the user ID to the database.
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", "user.php?id=" + response.authResponse.userID, false);
				xmlhttp.send(null);
			}
			
			// Set up the page when there is no logged in user.
			function no_user()
			{
				show_login();
			}

			// Handle the login event.
			function handle_login(response)
			{
				if(response.status === 'connected')
				{
					user_logged_in(response);
				}
				else
				{
					no_user();
				}
			}

			// Callback function to set things up based on whether the
			// user is logged in / the app is authorized.
			function check_login_status(response)
			{
				if(response.status === 'connected')
				{
					user_logged_in(response);
				}
				else
				{
					no_user();
				}
			}

			window.fbAsyncInit = function() {
				FB.init({
					appId      : '232466140177059', // App ID
					//channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
					status     : true, // check login status
					cookie     : true, // enable cookies to allow the server to access the session
					xfbml      : true  // parse XFBML
				});

				// Additional initialization code here
				FB.Event.subscribe('auth.login', handle_login);
				FB.getLoginStatus(check_login_status);
			};

			// Load the SDK Asynchronously
			(function(d){
				var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
				js = d.createElement('script'); js.id = id; js.async = true;
				js.src = "//connect.facebook.net/en_US/all.js";
				d.getElementsByTagName('head')[0].appendChild(js);
			}(document));
		</script>
		<div class="container">
			<div id="header">
				<hr/>
				<h1>def&nbsp;&nbsp;cards&nbsp;&nbsp;.&nbsp;&nbsp;com</h1>
				<hr/>
				<table id="topLinks" style="border-collapse:collapse;">
					<tr>
						<td style="text-align:left; width:40%;">
							<h2><a href="found.php">I found a card</a></h2>
						</td>
						<td style="text-align:center; vertical-align:center;" rowspan="2">
							<h2><a href="index.php">Home</a></h2>
						</td>
						<td style="text-align:right; width:40%;">
							<h2><a href="create.html">Create a card</a></h2>
						</td>
					</tr>
					<tr>
						<td valign="top" style="text-align:left; padding:0px;">
							<table>
								<tr>
									<td style="padding:0px;">
										<div id="fb-login" class="fb-login-button">
											Login with Facebook
										</div>
										<h2 id="account" style="display:none">
											<a id="account_link" href="account.php">Your account</a>
										</h2>
									</td>
								</tr>
							</table>
						</td>
						<td style="text-align:right;">
							<h2><a href="about.html">About the site</a></h2>
						</td>
					</tr>
				</table>
			</div>
			<!-- Begin page-specific content -->

			<div class="entry">
				<b class="spiffy">
					<b class="spiffy1"><b></b></b>
					<b class="spiffy2"><b></b></b>
					<b class="spiffy3"></b>
					<b class="spiffy4"></b>
					<b class="spiffy5"></b>
				</b>
				<div class="spiffyfg">

<h1 style="margin:0px;">
	<img style="vertical-align:middle;" src="https://graph.facebook.com/<? echo $_REQUEST['userID']; ?>/picture">
	&nbsp;<? echo $row['name'] . "'s Cards"; ?>
</h1>
				</div>
				<b class="spiffy">
					<b class="spiffy5"></b>
					<b class="spiffy4"></b>
					<b class="spiffy3"></b>
					<b class="spiffy2"><b></b></b>
					<b class="spiffy1"><b></b></b>
				</b>
			</div>

<?
	$db = get_db();
	$sql = 	"SELECT user_id, card_id_ref as card_id, body, type, " . 
			"DATE_FORMAT(time, '%e %b %Y at %l:%i %p') as date, name " .
			"FROM events LEFT JOIN users ON user_id_ref=user_id " .
			"WHERE user_id='" . db_quote($user_id) . "' " .
			"ORDER BY time DESC LIMIT " . (($page - 1) * $per_page) . "," . $per_page;

	$result = mysql_query($sql);
	$count = 0;

	while($event = mysql_fetch_array($result))
	{
		$count++;
?>
					<div class="entry">
				<b class="spiffy">
					<b class="spiffy1"><b></b></b>
					<b class="spiffy2"><b></b></b>
					<b class="spiffy3"></b>
					<b class="spiffy4"></b>
					<b class="spiffy5"></b>
				</b>
				<div class="spiffyfg">

		<h2><a href="card.php?id=<? echo $event['card_id']; ?>">Card <? echo $event['card_id']; ?></a></h2>
		<?
			if($event['type'] == FOUND)
			{
				echo "Found on " . $event['date'];
			}
			else if($event['type'] == CREATED)
			{
				echo "Created on " . $event['date'];
			}
			else
			{
				echo $event['body'];
				?>
					<div class="postedBy">
						<hr>
						posted on <? echo $event['date']; ?>
					</div>
				<?
			}
		?>		
						</div>
				<b class="spiffy">
					<b class="spiffy5"></b>
					<b class="spiffy4"></b>
					<b class="spiffy3"></b>
					<b class="spiffy2"><b></b></b>
					<b class="spiffy1"><b></b></b>
				</b>
			</div>

<?
	}
?>
<table id="bottomLinks" style="width:100%;">
	<tr>
		<td style="text-align:left;">
			<?
				if($page > 1)
				{
			?>
					<h2><a href="profile.php?page=<? echo ($page - 1); ?>&userID=<? echo $user_id; ?>">&lt;&lt; Prev</a></h2>
			<?
				}
				else
				{
			?>
					<? echo $counter; ?>
					&nbsp;
			<?
				}
			?>
		</td>
		<td style="text-align:right;">
			<?
				if($count == $per_page)
				{
			?>
					<h2><a href="profile.php?page=<? echo ($page + 1); ?>&userID=<? echo $user_id; ?>">Next &gt;&gt;</a></h2>
			<?
				}
				else
				{
			?>
					&nbsp;
			<?
				}
			?>
		</td>
	</tr>
</table>
			<!-- End page-specific content -->
			<div id="footer">
				All content &copy; 2011 - 2012 defcards.com.  All rights reserved.
			</div>
		</div>
	</body>
</html>

