<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Seja bem-vinda! ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">

		<section class="app__welcome mt-5 mb-5">
			<div class="container-xl d-flex flex-column align-items-center">
				<div class="app__welcome--box">
					<img src="<?=PATH?>assets/images/logo-csa-white.png" alt="Logotipo do Canal Salto Alto" class="app__welcome--logo mb-2" />
					<h2 class="text-center">Seja bem-vinda ao Canal Salto Alto!</h2>
					<p class="text-center text-white">Você agora faz parte de uma das maiores comunidades de empreendedorismo feminino em Linhares e Região. 
					<!-- Assista ao vídeo e seja muito bem-vinda! -->
				</p>
				</div>
				<!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/gQkW1HIWAZo?si=MZdKmwcCeOa7Fop0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> -->

				<div class="app__welcome--box mt-3">
					<p>Clique no botão a seguir para cadastrar a sua empresa:</p>
					<a href="/app/welcome/new-company" class="btn btn-rose">Cadastrar minha empresa</a>
				</div>
			</div>
		</section>


		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>