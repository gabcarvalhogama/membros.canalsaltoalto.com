<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Novo Post ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Novo Post</h1>
					<p class="subtitle">Cadastre um novo post no site público do CSA.</p>
					<form action="javascript:void(0)" method="post" onsubmit="Post.create(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>

						<div class="row">
							<div class="col mb-3">
								<label for="post_title" class="form-label">Título do Conteúdo</label>
								<input type="text" class="form-control" id="post_title" name="post_title" placeholder="Escreva aqui o título do post." required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="post_excerpt" class="form-label">Resumo do Conteúdo</label>
								<textarea name="post_excerpt" id="post_excerpt" class="form-control" placeholder=""></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<textarea name="post_content" id="post_content" class="form-control" placeholder="Escreva aqui seu conteúdo."></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="post_featured_image">Imagem em destaque</label>
								<input type="file" name="post_featured_image" id="post_featured_image" class="form-control" accept="image/*" />
							</div>
						</div>


						<!-- <div class="row">
							<div class="col-md-6 mb-3">
								<label for="post_status" class="form-label">Status</label>
								<select name="post_status" id="post_status" class="form-control" required>
									<option value="0">Rascunho</option>
									<option value="1">Publicado</option>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label for="post_publish_date" class="form-label">Data de Publicação</label>
								<input type="text" name="post_publish_date" id="post_publish_date" class="form-control" data-mask="00/00/0000 00:00" placeholder="Imediato" />
							</div>
						</div> -->

						<div>
							<input type="submit" value="Publicar Post" class="btn btn-rose btn-medium" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
		<script type="text/javascript">
			
			tinymce.init({
				selector: 'textarea#post_content',
				license_key: 'gpl',
			   	promotion: false,
			   	plugins: 'image, link, lists, code',
			   	toolbar: 'undo redo code | styles | bold italic | numlist bullist | link image | link',
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