<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title><?=$event->event_title?> ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__single-event single-event mt-5 mb-5">
			<div class="container-xl">
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
					<div class="col-md-6 mt-4 mb-4">
						<img src="/<?=$event->event_poster?>" alt="" class="img-fluid" style="border-radius: 15px;">
					</div>
				</div>
			</div>
		</section>

		<section class="single-event__content">
			<div class="container-xl">
				<?=$event->event_content?>
			</div>
		</section>


		<section class="related-posts mb-3 mt-3">
			<div class="container-xl">
				<h2>Você também pode se interessar...</h2>
				<div class="events-list hide-on-mobile">
					<?php
				  		$Event = new Event;
				  		$events = $Event->getEvents(7);
				  		foreach($events->fetchAll(PDO::FETCH_ASSOC) as $event_loop){
				  			if($event_loop['idevent'] == $event->idevent) continue;
				  			echo Template::render($event_loop, "loop_events");
				  		}
				  	?>
				</div>

				<!-- MOBILE -->
				<div class="hide-on-desktop swiper">
					<div class="swiper-wrapper">
					<?php
				  		$Event = new Event;
				  		$events = $Event->getEvents(7);
				  		foreach($events->fetchAll(PDO::FETCH_ASSOC) as $event_loop){
				  			if($event_loop['idevent'] == $event->idevent) continue;

				  			echo "<div class='swiper-slide'>";
				  			echo Template::render($event_loop, "loop_events");
				  			echo "</div>";
				  		}
				  	?>
				  	</div>
				</div>
			</div>
		</section>


		<?=Template::render(null, "footer_app")?>



		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
		<script type="text/javascript">
			
			const swiper = new Swiper('.swiper', {
				direction: 'horizontal',
				spaceBetween: 20,
				slidesPerView: 1,
				loop: true
			});
		</script>
	</body>
</html>