<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$content->title?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Editando: <?=$content->title?></h1>
					<form action="javascript:void(0)" method="post" onsubmit="Admin.updateContent(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>

						<div class="row">
							<div class="col mb-3">
								<label for="content_title" class="form-label">Título do Conteúdo</label>
								<input type="text" class="form-control" id="content_title" name="content_title" placeholder="Escreva aqui o título do conteúdo." value="<?=$content->title?>" required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="content_excerpt" class="form-label">Resumo do Conteúdo</label>
								<textarea name="content_excerpt" id="content_excerpt" class="form-control" placeholder=""><?=$content->excerpt?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<textarea name="content_content" id="content_content" class="form-control" placeholder="Escreva aqui seu conteúdo."><?=$content->content?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="content_featured_image">Imagem em destaque</label>
								<input type="hidden" name="content_featured_image_actual" id="content_featured_image_actual" value="<?=$content->featured_image?>">
								<input type="file" name="content_featured_image" id="content_featured_image" class="form-control" accept="image/*" />
								<img src="/<?=$content->featured_image?>" alt="" style="width: 150px;">
							</div>
							<div class="col-md-6 mb-3">
								<label for="content_featured_video_url">Vídeo em destaque (URL)</label>
								<input type="url" class="form-control" name="content_featured_video_url" id="content_featured_video_url" value="<?=$content->featured_video?>" />
							</div>
						</div>


						<div class="row">
							<!-- <div class="col-md-6 mb-3">
								<label for="content_status" class="form-label">Status</label>
								<select name="content_status" id="content_status" class="form-control" required data-selected="<?=$content->status?>">
									<option value="0">Rascunho</option>
									<option value="1">Publicado</option>
								</select>
							</div> -->
							<div class="col-md-6 mb-3">
								<label for="content_publish_date" class="form-label">Data de Publicação</label>
								<input type="text" name="content_publish_date" id="content_publish_date" class="form-control" data-mask="00/00/0000 00:00" placeholder="Imediato" value="<?=date("d/m/Y \à\s H:i", strtotime($content->published_at))?>" />
							</div>
						</div>
						<input type="hidden" name="content_id" id="content_id" value="<?=$content_id?>">

						<div>
							<input type="submit" value="Atualizar conteúdo" class="btn btn-rose btn-medium" />
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
				selector: 'textarea#content_content',
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

			// $(document).ready(function(){

			// 	$('select[data-selected]').map(function(item, value){
				    
			// 	})

			// })

		</script>	
	</body>
</html>