<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Divulgue Aqui ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__publis">
			<div class="container-xl">
				<div class="d-flex flex-column flex-md-row justify-content-between">
					<h2>Faça aqui sua <span class="color-primary">publi!</span></h2>
					<div>
						<a href="/app/publis/new"><button class="btn btn-rose btn-rounded">Faça uma Publi</button></a>
					</div>
				</div>
				<p>Atenção, empreendedora! Agora é possível fazer divulgações em nossa Plataforma de Membros! Basta clicar no botão e utilizar as Tags para facilitar na busca e publicar!</p>
				<div class="publis-list">
					<?php
						$Publi = new Publi;
						$ms = 0;

						$getPubli = $Publi->getPublisByStatus(200, 1);
						if($getPubli->rowCount() > 0):
							foreach($getPubli->fetchAll(PDO::FETCH_ASSOC) as $publi):
								if ((new DateTime())->diff(new DateTime($publi['published_at']))->days > 30 && (new DateTime() > new DateTime($publi['published_at']))) continue;

								$ms+=100;
								echo Template::render($publi, "loop_publis");
							endforeach; endif; ?>
			    </div>
			</div>
		</section>



		<?=Template::render(null, "footer_app")?>



		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js?<?=uniqid()?>"></script>
	</body>
</html>