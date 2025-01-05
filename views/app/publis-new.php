<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Nova Publi ‹ Área de Membros ‹ Canal Salto Alto</title>
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__newCompany mt-5 mb-5">
			<div class="container-xl">
				<h2>Faça a <span class="color-primary">sua Publi.</span></h2>
				<form action="javascript:void(0)" method="post" onsubmit="App.newPubli(this)"  accept-charset="utf-8" enctype="multipart/form-data">
					<div class="message"></div>

					<!-- <div class="row">
						<div class="col mb-3">
							<label for="publi_title" class="form-label">Título</label>
							<input type="text" class="form-control" id="publi_title" name="publi_title" placeholder="" required />
						</div>
					</div> -->
					<div class="row">
						<div class="col mb-3">
							<label for="publi_content">Conteúdo da Publi</label>
							<textarea name="publi_content" id="publi_content" class="form-control" maxlength="350"></textarea>
							<p><small><em>Limite de 350 caracteres.</em></small></p>
						</div>
					</div>

					<div class="row">
						<div class="col mb-3">
							<label for="publi_image">Imagem da Publi</label>
							<input type="file" class="form-control" id="publi_image" name="publi_image" accept="image/*" />
						</div>
					</div>
					<div class="row">
						<div class="col mb-3 text-center">
							<input type="submit" value="Cadastrar Publi" class="btn btn-rose btn-rose-light btn-medium btn-full" />
						</div>
					</div>
				</form>
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