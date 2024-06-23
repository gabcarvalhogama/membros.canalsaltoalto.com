<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">
		<?php include "header.phtml"; ?>

		<section class="app__notices">
			<div class="container">
				<h2>Nossos <span class="color-primary">avisos</span></h2>
				<?php
			  		$Notice = new Notice;
			  		$notices = $Notice->getNotices(5);
			  		foreach($notices->fetchAll(PDO::FETCH_ASSOC) as $notice):
			  	?>
			  	<div class="notices__item">
			  		<div class="notices__item--date"><span><?=date("d/m/Y \à\s H:i", strtotime($notice["published_at"]))?></span></div>
					<h3><?=$notice["notice_title"]?></h3>
					<p>
						<?=substr($notice["notice_content"], 0, 150)?>...
					</p>
				</div>
			    <?php endforeach; ?>
			</div>
		</section>



		<?php include "footer.phtml"; ?>



		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>