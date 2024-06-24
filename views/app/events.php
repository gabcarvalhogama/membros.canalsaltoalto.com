<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Eventos ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">
		<?php include "header.phtml"; ?>

		<section class="app__contents">
			<div class="container">
				<h2>Nossos <span class="color-primary">Eventos</span></h2>
				<div class="events-list">
					<?php
				  		$Event = new Event;
				  		$events = $Event->getEvents();
				  		foreach($events->fetchAll(PDO::FETCH_ASSOC) as $event):
				  	?>
				  	<a href="<?=PATH?>app/events/<?=$event['slug']?>">
					  	<div class="events__item">
							<div class="events__item--photo" style="background-image: url('/<?=$event["event_poster"]?>')"></div>
							<div class="events__item--content">
								<h3><?=$event["event_title"]?></h3>
								<a href="<?=PATH?>app/events/<?=$event['slug']?>" class="cta">INSCREVA-SE »</a>
							</div>
						</div>
					</a>
				    <?php endforeach; ?>
			    </div>
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