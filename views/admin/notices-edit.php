<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$notice->notice_title?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Editando: <?=$notice->notice_title?></h1>
					<p class="subtitle">Edite o seu aviso no formulário abaixo.</p>
					<form action="javascript:void(0)" method="post" onsubmit="Admin.Notices.update(this)">
						<div class="message"></div>

						<div class="row">
							<div class="col mb-3">
								<label for="notice_title" class="form-label">Título do Aviso</label>
								<input type="text" class="form-control" id="notice_title" name="notice_title" placeholder="Escreva aqui o título do aviso." required value="<?=$notice->notice_title?>" />
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<label for="notice_content" class="form-label">Conteúdo do Aviso</label>
								<textarea name="notice_content" id="notice_content" class="form-control" placeholder="Escreva aqui seu aviso.">
								<?=$notice->notice_content?>
								</textarea>
							</div>
						</div>


						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="notice_status" class="form-label">Status</label>
								<select name="notice_status" id="notice_status" class="form-control" required>
									<option value="0" <?=(($notice->status == 0) ? 'selected' : '')?>>Rascunho</option>
									<option value="1" <?=(($notice->status == 1) ? 'selected' : '')?>>Publicado</option>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label for="notice_publish_date" class="form-label">Data de Publicação</label>
								<input type="text" name="notice_publish_date" id="notice_publish_date" class="form-control" data-mask="00/00/0000 00:00" placeholder="Imediato" value="<?=DateTime::createFromFormat('Y-m-d H:i:s', $notice->published_at)->format('d-m-Y H:i')?>" />
							</div>
						</div>



						<div class="form-group row align-items-center">
							<div class="col-md-6">
								<input type="submit" value="Atualizar aviso" class="btn btn-rose btn-rose-light btn-full btn-medium" />
							</div>
							<div class="col-md-6">
								<a href="javascript:void(0)" style="color: #000;" onclick="Admin.Notices.delete(<?=$notice->idnotice?>)"><i class="fa-solid fa-trash"></i> Apagar notícia</a>
							</div>
						</div>

						<input type="hidden" name="idnotice" id="idnotice" value="<?=$notice->idnotice?>" />
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>
		<script type="text/javascript">
			
			tinymce.init({
				selector: 'textarea#notice_content',
				license_key: 'gpl',
			   	promotion: false,
			   	plugins: 'image, link, lists',
			   	toolbar: 'undo redo | styles | bold italic | numlist bullist | link image | link',
			   	menubar: false,
		       	language: 'pt_BR',
	         	images_upload_url: '<?=PATH?>upload/image',
         	  	images_upload_base_path: '/',
         	  	relative_urls: false,
				remove_script_host: false,
         	  	image_dimensions: false,
         	  	image_class_list: [
		            {title: 'Responsive', value: 'img-responsive'}
		        ]
			});

		</script>	
	</body>
</html>