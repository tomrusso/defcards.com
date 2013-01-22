<%%% template-top.html %%%>
<%%% spiffy-top.html %%%>
<h2>Card found</h2>
<div style="text-align:center;">
	<?
		if($_REQUEST['error'])
		{
	?>
			<div class="error">The ID you entered couldn't be found.  Please try again.</div>
			<br>
	<?
		}
	?>
	Please enter the card's ID:
	<form action="post.php" method="POST">
		<input name="userID" id="userID" type="hidden">
		<input style="text-align:center;" name="id1" type="text" size="3" maxlength="3"
		 onkeyup="if(this.value.length >= 3) { document.getElementById('id2').focus(); }">
		 -
		<input style="text-align:center;" name="id2" type="text" size="3" maxlength="3"
		 onkeyup="if(this.value.length >= 3) { document.getElementById('id3').focus(); }">
		 -
		<input style="text-align:center;" name="id3" type="text" size="3" maxlength="3">
		&nbsp;&nbsp;
		<input type="submit" value="Submit">
	</form>
</div>
<br/>
<%%% spiffy-bottom.html %%%>
<%%% template-bottom.html %%%>
