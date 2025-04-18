<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Novo Evento ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Novo Evento</h1>
					<form action="javascript:void(0)" method="post" onsubmit="CSAEvent.create(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>

						<div class="row">
							<div class="col mb-3">
								<label for="event_title" class="form-label">Título do Evento <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="event_title" name="event_title" placeholder="Escreva aqui o título do evento." required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="event_excerpt" class="form-label">Resumo do Evento <span class="text-danger">*</span></label>
								<textarea name="event_excerpt" id="event_excerpt" class="form-control" required></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<textarea name="event_content" id="event_content" class="form-control" ></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="event_poster">Imagem em destaque <span class="text-danger">*</span></label>
								<input type="file" name="event_poster" id="event_poster" class="form-control" accept="image/*" required />
							</div>
							<div class="col-md-6 mb-3">
								<label for="event_datetime" class="form-label">Data e Hora do Evento <span class="text-danger">*</span></label>
								<input type="text" name="event_datetime" id="event_datetime" class="form-control" data-mask="00/00/0000 00:00"  placeholder="DD/MM/AAAA HH:MM" required />
							</div>
						</div>

						<div class="form-row">
							<div class="col">
								<label for="event_status" class="form-label">Status do Evento <span class="text-danger">*</span></label>
								<select name="event_status" id="event_status" class="form-control">
									<option value="0">Rascunho</option>
									<option value="1">Publicado</option>
								</select>
							</div>
						</div>



						<div>
							<input type="submit" value="Cadastrar evento" class="btn btn-full btn-rose btn-medium" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
		<script type="text/javascript">
			
			tinymce.init({
				selector: 'textarea#event_content',
				license_key: 'gpl',
			   	// promotion: false,
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