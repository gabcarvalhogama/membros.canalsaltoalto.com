<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Comece Aqui ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__tutorials">
			<div class="container-xl">
				<h2>Comece <span class="color-primary">aqui.</span></h2>
				<?php
			  		$Tutorial = new Tutorial;
			  		$tutorials = $Tutorial->getTutorials(20);
			  		foreach($tutorials->fetchAll(PDO::FETCH_ASSOC) as $tutorial)
			  			echo Template::render($tutorial, "loop_tutorials");
			  	?>
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