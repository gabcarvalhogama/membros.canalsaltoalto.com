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

		<main id="app__hero">
			
			<div class="swiper">
			  <div class="swiper-wrapper">
			    <div class="swiper-slide">
			    	<div class="container">
			    		<a href="javascript:void(0)">
			    			<img src="<?=PATH?>assets/images/app-banner-bem-vinda.jpg" class="app__hero--image" />
			    		</a>
			    	</div>
			    </div>
			  </div>
			  <div class="swiper-pagination"></div>

			  <div class="swiper-button-prev"></div>
			  <div class="swiper-button-next"></div>
			</div>
		</main>

		<section class="app__events">
			<div class="container">
				<h2>Conheça <span class="color-primary">nossos eventos</span></h2>
				<?php
			  		$Event = new Event;
			  		$events = $Event->getEvents();
			  		foreach($events->fetchAll(PDO::FETCH_ASSOC) as $event):
			  	?>
			  	<a href="<?=PATH?>app/event/<?=$event['slug']?>">
				  	<div class="events__item">
						<div class="events__item--photo" style="background-image: url('<?=$event["event_poster"]?>')"></div>
						<div class="events__item--content">
							<h3><?=$event["event_title"]?></h3>
							<a href="<?=PATH?>app/event/<?=$event['slug']?>" class="cta">INSCREVA-SE »</a>
						</div>
					</div>
				</a>
			    <?php endforeach; ?>
			</div>
		</section>


		<section class="app__contents">
			<div class="container">
				<h2>Nossos <span class="color-primary">conteúdos</span></h2>
				<div class="contents">
				<?php
			  		$Content = new Content;
			  		$contents = $Content->getContents();
			  		foreach($contents->fetchAll(PDO::FETCH_ASSOC) as $content):
			  	?>
				  	<div class="contents__item">
						<div class="contents__item--photo" style="background-image: url('<?=$content["featured_image"]?>')"></div>
						<div class="contents__item--content">
							<h3><?=$content["title"]?></h3>
							<a href="<?=PATH?>app/content/<?=$content['slug']?>" class="cta">LEIA MAIS »</a>
						</div>
					</div>
			    <?php endforeach; ?>
			    </div>
			</div>
		</section>

		<!-- <section class="adbanner">
			<div class="container">
				<img src="<?=PATH?>assets/images/Banner-900x100-Light-transparent.png" alt="" />
			</div>
		</section> -->

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