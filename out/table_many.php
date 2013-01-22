<?
    include "/home/wanderin/defcard-src/php_include/card.php";
?>
<html>
	<head>
		<title>Test</title>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
	</head>
	<body style="text-align:center;">
		<table style="border-collapse:collapse;">
			<?
				for($i = 0; $i < 4; $i++)
				{
			?>
			<tr>
				<?
					for($j = 0; $j < 2; $j++)
					{
						$priv_id = create_card();
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
				<?
					}
				?>
			</tr>
			<?
				}
			?>
	</body>
</html>
