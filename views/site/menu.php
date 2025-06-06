<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto - Menu do Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="site">
		<?=Template::render(null, "header_site")?>

		<!-- <main class="hero">
			<img src="<?=PATH?>uploads/2024/08/site-seja-membro-hero.png" class="site__hero--image" />
		</main>
 -->

		<section class="m-5" style="min-height: 50vh;">
			<div class="container">
				<h1 class="mb-3 text-center">Escolha uma opção para navegar pelo nosso ecossistema:</h1>
				<div class="row">
					<div class="col-md-4 mb-3">
						<a href="https://canalsaltoalto.com/app"><img src="<?=PATH?>assets/images/banner-ja-sou-membro.jpg" alt="" class="navigationpage--item" style="max-width: 100%;border-radius: 5px;"></a>
					</div>
					<div class="col-md-4 mb-3">
						<a href="https://canalsaltoalto.com/seja-membro"><img src="<?=PATH?>assets/images/banner-ainda-nao-sou-membro.jpg" alt="" class="navigationpage--item" style="max-width: 100%;border-radius: 5px;"></a>
					</div>
					<div class="col-md-4 mb-3">
						<a href="https://canalsaltoalto.com/checkout"><img src="<?=PATH?>assets/images/banner-renovar-assinatura.jpg" alt="" class="navigationpage--item" style="border: solid 2px #e54c8e;max-width: 100%;border-radius: 5px;"></a>
					</div>
				</div>
			</div>
		</section>

		<style>
			.navigationpage--item{
				transition: all 300ms;
				border: solid 1px #ddd;
			}
			.navigationpage--item:hover{
				transform: translateY(-20px);
			}
		</style>

		<?=Template::render(null, "footer_site")?>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/site.js"></script>
	</body>
</html>