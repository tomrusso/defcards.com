<?
	include "/home/wanderin/defcard-src/php_include/card.php";

	if($_REQUEST['id'])
	{
		$priv_id = strtoupper($_REQUEST['id']);
	}
	else
	{
		$priv_id = (strtoupper($_REQUEST['id1'] . $_REQUEST['id2'] . $_REQUEST['id3']));
	}

	if(!confirm_private_id($priv_id))
	{
		header("Location: found.php?error=true");
		exit();
	}

	$user_id = $_REQUEST['userID'];

	if($user_id)
	{
		found($priv_id, $user_id);
	}
	else
	{
		found($priv_id);
	}
?>
<%%% template-top.html %%%>
<%%% spiffy-top.html %%%>
					<h2>Write a post</h2>
					Write something about this card, and then leave it
					somewhere others will find it.  Think of it
					as a digital message in a bottle to people who've
					found this card in the past or will find it in the 
					future.
					<br><br>
					<form action="save.php" method="POST">
						<input type="hidden" name="id" value="<? echo $priv_id; ?>">
						<input type="hidden" name="userID" id="userID">
						<div style="width:100%;">
							<textarea name="body" style="width:100%;" rows="10"></textarea>
						</div>
						<br/>
						<div style="width:100%; text-align:right;"><input type="submit" value="Submit"></div>
					</form>
<%%% spiffy-bottom.html %%%>
<%%% template-bottom.html %%%>
