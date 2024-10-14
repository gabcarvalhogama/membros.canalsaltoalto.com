<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Eventos ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__contents">
			<div class="container-xl">
				<h2>Nossos <span class="color-primary">Eventos</span></h2>
				<div class="events-list">
					<?php
				  		$Event = new Event;
				  		$events = $Event->getEvents();
				  		foreach($events->fetchAll(PDO::FETCH_ASSOC) as $event)
				  			echo Template::render($event, "loop_events");
				  	?>
			    </div>
			</div>
		</section>



		<?=Template::render(null, "footer_app")?>



		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>