<?
	include "/home/wanderin/defcard-src/php_include/card.php";
	// ***TODO***: Should potentially do some error checking here.

	if($_REQUEST['userID'])
	{
		save_post($_REQUEST['body'], $_REQUEST['id'], $_REQUEST['userID']);
	}
	else
	{
		save_post($_REQUEST['body'], $_REQUEST['id']);
	}
?>
<%%% template-top.html %%%>
<%%% spiffy-top.html %%%>
<h2>Post saved</h2>
Your post has been saved.  Click
<a href="card.php?id=<? echo get_public_id($_REQUEST['id']); ?>">here</a>
to see this card's history.
<br/>
<%%% spiffy-bottom.html %%%>
<%%% template-bottom.html %%%>
