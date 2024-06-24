<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Clubes ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">
		<?php include "header.phtml"; ?>

		<section class="app__clubs mt-5 mb-5">
			<div class="container">
				<h2>Aproveite nosso <span class="color-primary">clube de vantagens.</span></h2>

				<div class="clubs-list">
				<?php
					$Club = new Club;
					$getClub = $Club->getClubs(200);
						$ms = 0;

					if($getClub->rowCount() > 0):
					foreach($getClub->fetchAll(PDO::FETCH_ASSOC) as $club):
								$ms+=200;
				?>
					<div class="clubs-list__item animate__animated animate__faster animate__fadeInDown"  style="animation-delay: <?=$ms?>ms ">
			  			<div class="clubs-list__item--image" style="background-image: url('/<?=$club["club_image"]?>')"></div>
			  			<div class="clubs-list__item--content">
			  				<h3 class="mt-3"><?=$club["club_title"]?></h3>
			  				<div class="description"><?=$club["club_description"]?></div>
			  			</div>
			  		</div>
				<?php 
					endforeach; endif;
				?>
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