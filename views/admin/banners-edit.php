<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando Banner ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Editando banner</h1>
					
					<form action="javascript:void(0)" method="post" onsubmit="Admin.Banners.update(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>
						<div class="row mb-3">
							<div class="col-md-4">
								<img src="<?=PATH.$banner['path_desktop']?>" alt="" class="img-fluid" />
							</div>
							<div class="col-md-8">
								<label for="banner_desktop">Banner Desktop</label>
								<input type="file" class="form-control" name="banner_desktop" id="banner_desktop"  />
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-4">
								<img src="<?=PATH.$banner['path_mobile']?>" alt="" class="img-fluid" />
							</div>
							<div class="col-md-8">
								<label for="banner_mobile">Banner mobile</label>
								<input type="file" class="form-control" name="banner_mobile" id="banner_mobile"  />
							</div>
						</div>
						<div class="form-group mb-3">
							<label for="position">Posição <small class="text-danger">*</small></label>
							<select name="position" id="position" class="form-control" required>
								<?php
									$Banner = new Banner;
									foreach($Banner->positions as $key => $value):
								?>
								<option <?=(($banner['position'] == $key) ? 'selected' : '')?> value="<?=$key?>"><?=$value?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group mb-3">
							<label for="link">Link <small class="text-danger">*</small></label>
							<input type="url" id="link" class="form-control" name="link" required value="<?=$banner['link']?>" />
						</div>

						<div class="form-group mb-3">
							<label for="banner_order">Ordem <small class="text-danger">*</small></label>
							<input type="number" id="banner_order" class="form-control" name="banner_order" required min="0" value="<?=$banner['banner_order']?>" />
						</div>

						<div class="form-group mb-3">
							<label for="banner_status">Status <small class="text-danger">*</small></label>
							<select name="banner_status" id="banner_status" class="form-control" required>
								<option value="0" <?=(($banner['banner_status'] == '0') ? 'selected' : '')?> >Desativado</option>
								<option value="1" <?=(($banner['banner_status'] == '1') ? 'selected' : '')?>>Ativado</option>
							</select>
						</div>

						<div class="form-group row align-items-center">
							<div class="col-md-6">
								<input type="submit" value="Atualizar banner" class="btn btn-rose btn-rose-light btn-full btn-medium" />
							</div>
							<div class="col-md-6">
								<a href="javascript:void(0)" style="color: #000;" onclick="Admin.Banners.delete(<?=$banner['banner_id']?>)"><i class="fa-solid fa-trash"></i> Apagar banner</a>
							</div>
						</div>
						<input type="hidden" name="banner_id" value="<?=$banner['banner_id']?>">
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>
	</body>
</html>