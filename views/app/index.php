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


		
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary display-none" style="display: none;" data-bs-toggle="modal" data-bs-target="#ultimosDiasModal">
		Launch demo modal
		</button>

		<!-- Modal -->
		<div class="modal fade" id="ultimosDiasModal" tabindex="-1" aria-labelledby="ultimosDiasLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content p-4 text-center" style="background-color: #ffffff;" c>
				<h3>Sua assinatura está prestes a vencer!</h3>
				<p>Não perca a oportunidade de continuar crescendo com a gente.</p>
				<div class="card" style="color: #333">
					<div class="card-body">
						<div class="row text-center" style="font-size: 12px;">
							<div class="col-3">
								<h3 id="days" class="display-6">00</h3>
								<p class="mb-0">Dias</p>
							</div>
							<div class="col-3">
								<h3 id="hours" class="display-6">00</h3>
								<p class="mb-0">Horas</p>
							</div>
							<div class="col-3">
								<h3 id="minutes" class="display-6">00</h3>
								<p class="mb-0">Minutos</p>
							</div>
							<div class="col-3">
								<h3 id="seconds" class="display-6">00</h3>
								<p class="mb-0">Segundos</p>
							</div>
						</div>
					</div>
				</div>
				<a href="/checkout/renewall" class="mt-3"><button class="btn btn-primary">RENOVAR INSCRIÇÃO</button></a>

				<a href="javascript:void(0)" class="mt-2" data-bs-dismiss="modal">Fechar janela</a>

				<script type="text/javascript">

					const countDownDate = new Date('<?=(USER->membership_ends_at)?>').getTime();

					const x = setInterval(function() {
						const now = new Date().getTime();

						const distance = countDownDate - now;

						const days = Math.floor(distance / (1000 * 60 * 60 * 24));
						const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
						const seconds = Math.floor((distance % (1000 * 60)) / 1000);

						document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
						document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
						document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
						document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');

						if (distance < 0) {
							clearInterval(x);
							document.getElementById("days").innerHTML = "00";
							document.getElementById("hours").innerHTML = "00";
							document.getElementById("minutes").innerHTML = "00";
							document.getElementById("seconds").innerHTML = "00";
						}
					}, 1000);


					window.onload = function(){
						const timeToShow = (30 * 24 * 60 * 60 * 1000); // 5 dias

					
						const now = new Date().getTime();

						const distance = countDownDate - now;

						if(distance < timeToShow){
							const myModal = new bootstrap.Modal(document.getElementById('ultimosDiasModal'), {
							keyboard: false
							});
							myModal.show();
						}
					}
				</script>
			</div>
		</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<!-- <script type="text/javascript" src="<?=PATH?>assets/js/track.js"></script> -->
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>