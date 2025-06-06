<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Novo Clube ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Novo Clube</h1>

					<form action="javascript:void(0)" method="post" onsubmit="Club.new(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>
						<div class="row">
							<div class="col mb-3">
								<label for="club_title" class="form-label">Título</label>
								<input type="text" class="form-control" id="club_title" name="club_title" placeholder="" required />
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<textarea name="club_description" id="club_description" class="form-control"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<label for="club_image">Imagem em destaque</label>
								<input type="file" name="club_image" id="club_image" class="form-control" accept="image/*" />
							</div>
						</div>
						<div class="row">
							<div class="col mb-3 text-center">
								<input type="submit" value="Cadastrar Clube" class="btn btn-rose btn-medium btn-full btn-rounded" />
							</div>
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
				selector: 'textarea#club_description',
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