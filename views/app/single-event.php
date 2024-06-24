<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title><?=$event->event_title?> ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">
		<?php include "header.phtml"; ?>

		<section class="app__single-event single-event mt-5 mb-5">
			<div class="container">
				<div class="row align-items-center single-event__hero">
					<div class="col-md-6">
						<h1><?=$event->event_title?></h1>
						<div class="single-event__hero--excerpt"><?=$event->event_excerpt?></div>
						<div class="single-event__hero--details">
							<ul class="mt-2">
								<li><i class="fa-solid fa-calendar"></i> <?=date("d/m/Y \à\s H:i", strtotime($event->event_datetime))?></li>
							</ul>
						</div>
					</div>
					<div class="col-md-6">
						<img src="/<?=$event->event_poster?>" alt="" class="img-fluid" style="border-radius: 15px;">
					</div>
				</div>
			</div>
		</section>

		<section class="single-event__content">
			<div class="container">
				<?=$event->event_content?>
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