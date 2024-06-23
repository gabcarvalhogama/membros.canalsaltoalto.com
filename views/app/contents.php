<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Conteúdos ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">
		<?php include "header.phtml"; ?>

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
						<div class="contents__item--photo" style="background-image: url('/<?=$content["featured_image"]?>')"></div>
						<div class="contents__item--content">
							<h3><?=$content["title"]?></h3>
							<a href="<?=PATH?>app/content/<?=$content['slug']?>" class="cta">LEIA MAIS »</a>
						</div>
					</div>
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