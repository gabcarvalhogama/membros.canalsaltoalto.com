<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$club->club_title?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Editando: <?=$club->club_title?></h1>

					<form action="javascript:void(0)" method="post" onsubmit="Club.update(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>
						<div class="row">
							<div class="col mb-3">
								<label for="club_title" class="form-label">Título</label>
								<input type="text" class="form-control" id="club_title" name="club_title" placeholder="" value="<?=$club->club_title?>" required />
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<textarea name="club_description" id="club_description" class="form-control"><?=$club->club_description?></textarea>
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col-md-2 mb-3">
								<img src="/<?=$club->club_image?>" alt="" style="width: 200px;max-width: 100%;border-radius: 10px;" />
							</div>
							<div class="col-md-10 mb-3">
								<label for="club_image">Imagem em destaque</label>
								<input type="file" name="club_image" id="club_image" class="form-control" accept="image/*" data-actualimage="<?=$club->club_image?>" />
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col mb-3 text-center">
								<input type="submit" value="Atualizar Clube" class="btn btn-rose btn-medium btn-full btn-rounded" />
							</div>
							<div class="col mb-3">
								<a href="javascript:void(0)" style="margin-left:  20px;color: #000" onclick="Club.delete(<?=$club->club_id?>)">Apagar Clube</a>
							</div>
						</div>
						<input type="hidden" name="club_id" id="club_id" value="<?=$club->club_id?>" />
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