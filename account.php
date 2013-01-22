<?
	include "/home/wanderin/defcard-src/php_include/card.php";
	$page = intval($_REQUEST['page']);
	if(!$page || $page < 1) { $page = 1; }
	$per_page = 10;

	$user_id = intval($_REQUEST['userID']);
?>
<%%% template-top.html %%%>
<%%% spiffy-top.html %%%>
<h1 style="margin:0px;">
	<img style="vertical-align:middle;" src="https://graph.facebook.com/<? echo $_REQUEST['userID']; ?>/picture">
	&nbsp;Your Cards
</h1>
<%%% spiffy-bottom.html %%%>
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
		<%%% spiffy-top.html %%%>
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
		<%%% spiffy-bottom.html %%%>
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
					<h2><a href="account.php?page=<? echo ($page - 1); ?>&userID=<? echo $user_id; ?>">&lt;&lt; Prev</a></h2>
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
					<h2><a href="account.php?page=<? echo ($page + 1); ?>&userID=<? echo $user_id; ?>">Next &gt;&gt;</a></h2>
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
<%%% template-bottom.html %%%>
