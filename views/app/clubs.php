<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Clubes ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />
		
		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__clubs mt-5 mb-5">
			<div class="container-xl">
				<h2>Aproveite nosso <span class="color-primary">clube de vantagens.</span></h2>

				<div class="clubs-list">
				<?php
					$Club = new Club;
					$getClub = $Club->getClubs(200);
						$ms = 0;

					if($getClub->rowCount() > 0):
					foreach($getClub->fetchAll(PDO::FETCH_ASSOC) as $club):
						$ms+=200;
						echo Template::render($club, "loop_clubs");
					endforeach; endif;
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