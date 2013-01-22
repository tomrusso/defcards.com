<?
	include "/home/wanderin/defcard-src/php_include/card.php";
	$id = $_REQUEST['id'];
	$page = intval($_REQUEST['page']);
	if(!$page || $page < 1) { $page = 1; }
	$per_page = 10;

	$db = get_db();
	$sql = 	"SELECT user_id, name, DATE_FORMAT(time, '%e %b %Y at %l:%i %p') as date ".
			"FROM events LEFT JOIN users ON user_id=user_id_ref " .
			"WHERE type='" . db_quote(CREATED) . "' " . "AND card_id_ref='" . db_quote($id) . "'";
	
	$result = mysql_query($sql);
	$create_event = mysql_fetch_array($result);
?>
<%%% template-top.html %%%>
<%%% spiffy-top.html %%%>
<h1 style="margin:0px;">Card <? echo $id; ?></h1>
<div class="postedBy">
<hr>
	<?
		if($create_event['user_id'] and $create_event['name'])
		{
	?>
			<img style="vertical-align:middle;" src="<? echo "https://graph.facebook.com/" . $create_event['user_id'] . "/picture"; ?>">
			&nbsp;&nbsp;&nbsp;&nbsp;
			created by
			<a href="profile.php?userID=<? echo $create_event['user_id']; ?>"><? echo $create_event['name']; ?></a>
			on <? echo $create_event['date']; ?>
	<?
		}
		else
		{
	?>
			created by Anonymous on <? echo $create_event['date']; ?>
	<?
		}
	?>
</div>
<%%% spiffy-bottom.html %%%>
<?
	$sql = 	"SELECT user_id, card_id_ref as card_id, body, " .
			"DATE_FORMAT(time, '%e %b %Y at %l:%i %p') as date, name " .
			"FROM events LEFT JOIN users ON user_id_ref=user_id " .
			"WHERE card_id_ref='" . db_quote($id) . "' " .
			"AND type='" . db_quote(POST) . "' " .
			"ORDER BY time DESC LIMIT " . ($page - 1) * $per_page . ",$per_page";

	$result = mysql_query($sql);
	$count = 0;

	while($event = mysql_fetch_array($result))
	{
		$count++;
?>
			<%%% spiffy-top.html %%%>
			<h2>
				<? echo $event['date']; ?>
			</h2>
			<? echo $event['body']; ?>
			<div class="postedBy">
				<hr>
				<?
					if($event['user_id'] and $event['name'])
					{
				?>
						<img style="vertical-align:middle" src="https://graph.facebook.com/<? echo $event['user_id']; ?>/picture">
						&nbsp;&nbsp;&nbsp;&nbsp; posted by
						<a href="profile.php?userID=<? echo $event['user_id']; ?>"><? echo $event['name']; ?></a>
				<?
					}
					else
					{
				?>
						posted by Anonymous
				<?
					}
				?>
			</div>
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
					<h2><a href="card.php?id=<? echo $id; ?>&page=<? echo ($page - 1); ?>">&lt;&lt; Prev</a></h2>
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
		<td style="text-align:right;">
			<?
				if($count == $per_page)
				{
			?>
				<h2><a href="card.php?id=<? echo $id; ?>&page=<? echo ($page + 1); ?>">Next &gt;&gt;</a></h2>
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
