<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Novo Aviso - Painel Administrativo - Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">
	<?=Template::render(null, "after-body-tags")?>

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Novo Aviso</h1>
					<p class="subtitle">Cadastre um novo aviso na área de membros.</p>
					<form action="javascript:void(0)" method="post" onsubmit="Admin.addNotice(this)">
						<div class="message"></div>

						<div class="row">
							<div class="col mb-3">
								<label for="notice_title" class="form-label">Título do Aviso</label>
								<input type="text" class="form-control" id="notice_title" name="notice_title" placeholder="Escreva aqui o título do aviso." required />
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<label for="notice_content" class="form-label">Conteúdo do Aviso</label>
								<textarea name="notice_content" id="notice_content" class="form-control" placeholder="Escreva aqui seu aviso." maxlength="350"></textarea>
								<small>Aviso: limite de 350 caracteres.</small>
							</div>
						</div>


						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="notice_status" class="form-label">Status</label>
								<select name="notice_status" id="notice_status" class="form-control" required>
									<option value="0">Rascunho</option>
									<option value="1">Publicado</option>
								</select>
							</div>
							<!-- <div class="col-md-6 mb-3">
								<label for="notice_publish_date" class="form-label">Data de Publicação</label>
								<input type="text" name="notice_publish_date" id="notice_publish_date" class="form-control" data-mask="00/00/0000 00:00" placeholder="Imediato" />
							</div> -->
						</div>

						<div>
							<input type="submit" value="Cadastrar aviso" class="btn btn-rose btn-rose-light" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>
		<!-- <script type="text/javascript">
			
			tinymce.init({
				selector: 'textarea#notice_content',
				license_key: 'gpl',
			   	promotion: false,
			   	plugins: 'link, lists code',
			   	toolbar: 'undo redo code | styles | bold italic | numlist bullist | link',
			   	menubar: false,
		       	language: 'pt_BR',
				remove_script_host: false
			});

		</script>	 -->
	</body>
</html>