<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<main id="app__hero">
			
			<div class="swiper">
			  <div class="swiper-wrapper">
			    <div class="swiper-slide">
			    	<!-- <div class="container-xl">
			    		<a href="javascript:void(0)">
			    			<img src="<?=PATH?>assets/images/app-banner-bem-vinda.jpg" class="app__hero--image" />
			    		</a>
			    	</div> -->
					<?php 
						$Banner = new Banner;
						$getBanners = $Banner->getBannersByPosition('app_home_hero');

						foreach($getBanners->fetchAll(PDO::FETCH_ASSOC) as $banner):
					?>
					<div class="swiper-slide">
						<a href="<?=$banner['link']?>" target="_blank">
							<img src="<?=PATH.$banner['path_desktop']?>" class="app__hero--image d-none d-md-block" />
							<img src="<?=PATH.$banner['path_mobile']?>" class="app__hero--image d-block d-md-none" />
						</a>
					</div>

					<?php endforeach; ?>
			    </div>
			  </div>
			  <div class="swiper-pagination"></div>

			  <div class="swiper-button-prev"></div>
			  <div class="swiper-button-next"></div>
			</div>
		</main>

		<section class="banner mt-3 mb-3">
			<div class="container-xl">
				<?php 
			  		$getBanners01 = $Banner->getBannersByPosition('app_below_hero');

			  		foreach($getBanners01->fetchAll(PDO::FETCH_ASSOC) as $banner):
			  	?>
				<a href="<?=$banner['link']?>" target="_blank" style="display: block">
					<img src="<?=PATH.$banner['path_desktop']?>" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="app__events mt-5 mb-5">
			<div class="container-xl">
				<h2 class="mb-3">Conheça <span class="color-primary">nossos eventos</span></h2>

				<div class="events-list">
				<?php
			  		$Event = new Event;
			  		$events = $Event->getEvents(6);
			  		foreach($events->fetchAll(PDO::FETCH_ASSOC) as $event)
			  			echo Template::render($event, "loop_events");
				?>
			    </div>
			</div>
		</section>


		<section class="app__contents mt-4 mb-4 pt-5 pb-5">
			<div class="container-xl">
				<h2>Nossos <span class="color-primary">conteúdos</span></h2>
				<div class="contents">
				<?php
			  		$Content = new Content;
			  		$contents = $Content->getContents(6);
			  		foreach($contents->fetchAll(PDO::FETCH_ASSOC) as $content)
			  			echo Template::render($content, "loop_contents");
			  	?>
			    </div>
			</div>
		</section>

		<!-- <section class="adbanner">
			<div class="container-xl">
				<img src="<?=PATH?>assets/images/Banner-900x100-Light-transparent.png" alt="" />
			</div>
		</section> -->

		<!-- <section class="app__notices mt-4 mb-4">
			<div class="container-xl">
				<h2>Nossos <span class="color-primary">avisos</span></h2>
				<?php
			  		$Notice = new Notice;
			  		$notices = $Notice->getNotices(5);
			  		foreach($notices->fetchAll(PDO::FETCH_ASSOC) as $notice)
			  			echo Template::render($notice, "loop_notices");
			  	?>
			</div>
		</section> -->



		<?=Template::render(null, "footer_app")?>



		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<!-- <script type="text/javascript" src="<?=PATH?>assets/js/track.js"></script> -->
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>