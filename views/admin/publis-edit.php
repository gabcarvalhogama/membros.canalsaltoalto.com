<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$publi->publi_title?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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


						<!-- <div class="row">
							<div class="col mb-3">
								<label for="publi_title" class="form-label">Título</label>
								<input type="text" class="form-control" id="publi_title" name="publi_title" placeholder="" value="<?=$publi->publi_title?>" required />
							</div>
						</div> -->




						<div class="row align-items-center">
							<div class="col-md-4 mb-3">
								<img src="<?=PATH.$publi->publi_image?>" alt="" class="img-fluid" />
							</div>
							<div class="col-md-8 mb-3">
								<label for="publi_image">Imagem da Publi</label>
								<input type="file" class="form-control" id="publi_image" name="publi_image" accept="image/*" />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<textarea name="publi_content" id="publi_content" class="form-control"><?=$publi->publi_content?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="publi_status">Status da Publi</label>
								<select name="publi_status" id="publi_status" class="publi_status form-control">
									<option value="0" <?=($publi->publi_status == 0) ? 'selected' : '' ?>>Pendente de Aprovação</option>
									<option value="1" <?=($publi->publi_status == 1) ? 'selected' : '' ?>>Aprovada</option>
									<option value="2" <?=($publi->publi_status == 2) ? 'selected' : '' ?>>Reprovada</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="d-flex mb-3 flex-row align-items-center">
								<input type="submit" value="Atualizar publi" class="btn btn-rose" />
								<a href="javascript:void(0)" style="margin-left:  20px;color: #000" onclick="Publi.delete(<?=$publi->publi_id?>)">Apagar publi</a>
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
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>
		<script type="text/javascript">
			
			tinymce.init({
				selector: 'textarea#publi_content',
				license_key: 'gpl',
			   	promotion: false,
			   	plugins: 'image, link, lists',
			   	toolbar: 'undo redo | styles | bold italic | numlist bullist | link',
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