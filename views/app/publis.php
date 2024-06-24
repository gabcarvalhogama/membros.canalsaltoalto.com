<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Divulgue Aqui ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">
		<?php include "header.phtml"; ?>

		<section class="app__publis">
			<div class="container">
				<h1>Faça aqui sua <span class="color-primary">publis!</span></h1>
				<p>Atenção, empreendedoras membros! Agora é possível fazer divulgações em nossa Plataforma de Membros! Basta preencher o formulário acima, utilizar as Tags para facilitar na busca e publicar!</p>
				<div class="publis-list">
					<?php
						$Publi = new Publi;
						$ms = 0;

						$getPubli = $Publi->getPublis(200);
						if($getPubli->rowCount() > 0):
							foreach($getPubli->fetchAll(PDO::FETCH_ASSOC) as $publi):
								$ms+=100;
					?>
					<div class="publis-list__item animate__animated animate__faster animate__fadeInDown" style="animation-delay: <?=$ms?>ms ">
						<div class="publis-list__item--header">
							<img src="/<?=(!empty($publi['profile_photo'])) ? $publi['profile_photo'] : 'assets/images/default-pfp.png';?>" style="width:
							 60px;" alt="" />
							<div class="d-flex flex-column">
								<span class="profile-name">
									<?=$publi['firstname']." ".$publi['lastname']?>
								</span>
								<small>
									<?=date("d/m/Y \à\s H:i", strtotime($publi["published_at"]))?>
								</small>
							</div>
							
						</div>
						<div class="publis-list__item--content">
							<h3><?=$publi['publi_title']?></h3>
							<?=$publi['publi_content']?>
						</div>
					</div>

					<?php endforeach; endif; ?>
			    </div>
			</div>
		</section>



		<?php include "footer.phtml"; ?>



		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
	</body>
</html>