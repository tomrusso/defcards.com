<?
    include "/home/wanderin/defcard-src/php_include/card.php";
	$user_id = $_REQUEST['userID'];
?>
<%%% template-top.html %%%>
<%%% spiffy-top.html %%%>
<h2>New card created</h2>
Print out this page, cut out the card and laminate it.
Then leave it somewhere others will find it.
<div style="width:100%; text-align:center; padding-top:15pt; padding-bottom:15pt;">
	<table style="border-collapse:collapse; text-align:center; margin-left:auto; margin-right:auto;">
		<tr style="text-align:center;">
			<?
				if($user_id)
				{
					$priv_id = create_card($user_id);
				}
				else
				{
					$priv_id = create_card();
				}
				$id1 = substr($priv_id, 0, 3);
				$id2 = substr($priv_id, 3, 3);
				$id3 = substr($priv_id, 6, 3);

				$card_url = "http://www.defcards.com/post.php?id=$id1$id2$id3";
				$img_url =  "http://chart.apis.google.com/chart?cht=qr&chs=100x100&chld=L|0&choe=UTF-8&chl=";
				$img_url .= urlencode($card_url);
			?>
			<td class="card">
				<table>
					<tr>
						<td>
							<img src="<? echo $img_url; ?>"/>
						</td>
						<td style="text-align:center">
							<div class="smallLabel">Please take this card and visit:</div>
							<div class="largeLabel">defcards.com</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center; padding:0.2cm;">
							<div class="largeLabel"><?  echo $id1 . "-" . $id2 . "-" . $id3; ?></div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<?
	$post_url = "post.php?id=$id1$id2$id3";
	if($user_id) $post_url .= "&userID=$user_id";
?>
To write something about this card, click <a href="<? echo $post_url; ?>">here</a>.
<%%% spiffy-bottom.html %%%>
<%%% template-bottom.html %%%>
