<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$publi->publi_title?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="admin">

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Nova Publi</h1>

					<form action="javascript:void(0)" method="post" onsubmit="Publi.update(this)"  accept-charset="utf-8">
						<div class="message"></div>
						<div class="row">
							<div class="col mb-3">
								<label for="publi_creator" class="form-label">Dona da Publi</label>
								<select name="publi_creator" id="publi_creator" class="form-control">
									<option value="">Selecione uma opção</option>
									<?php
										$User = new User;
										$getUsers = $User->getUsers();

										foreach($getUsers->fetchAll(PDO::FETCH_ASSOC) as $user):
									?>
									<option <?=($user['iduser'] == $publi->user_id) ? 'selected' : ''?> value="<?=$user['iduser']?>"><?=$user['firstname']." ".$user['lastname']?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>


						<div class="row">
							<div class="col mb-3">
								<label for="publi_title" class="form-label">Título</label>
								<input type="text" class="form-control" id="publi_title" name="publi_title" placeholder="" value="<?=$publi->publi_title?>" required />
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<textarea name="publi_content" id="publi_content" class="form-control"><?=$publi->publi_content?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col mb-3 text-center">
								<input type="submit" value="Atualizar Publi" class="btn btn-rose btn-medium btn-full" />
							</div>
						</div>

						<input type="hidden" id="publi_id" name="publi_id" value="<?=$publi->publi_id?>" />
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
				selector: 'textarea#publi_content',
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