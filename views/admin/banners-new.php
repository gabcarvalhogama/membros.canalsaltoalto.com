<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Novo Banner ‹ Painel Administrativo ‹ Canal Salto Alto</title>		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">
		<?=Template::render(null, "after-body-tags")?>

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Criar um novo banner</h1>
					
					<form action="javascript:void(0)" method="post" onsubmit="Admin.Banners.create(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>
						<div class="form-group mb-3">
							<label for="banner_desktop">Banner Desktop <small class="text-danger">*</small></label>
							<input type="file" class="form-control" name="banner_desktop" id="banner_desktop" required />
						</div>
						<div class="form-group mb-3">
							<label for="banner_mobile">Banner Mobile <small class="text-danger">*</small></label>
							<input type="file" class="form-control" name="banner_mobile" id="banner_mobile" required />
						</div>
						<div class="form-group mb-3">
							<label for="position">Posição <small class="text-danger">*</small></label>
							<select name="position" id="position" class="form-control" required>
								<?php
									$Banner = new Banner;
									foreach($Banner->getPositions() as $position):
								?>
								<option value="<?=$position['position_value']?>"><?=$position['position_title']?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group mb-3">
							<label for="link">Link <small class="text-danger">*</small></label>
							<input type="url" id="link" class="form-control" name="link" required />
						</div>

						<div class="form-group mb-3">
							<label for="banner_order">Ordem <small class="text-danger">*</small></label>
							<input type="number" id="banner_order" class="form-control" name="banner_order" required min="0" />
						</div>

						<div class="form-group mb-3">
							<label for="banner_status">Status <small class="text-danger">*</small></label>
							<select name="banner_status" id="banner_status" class="form-control" required>
								<option value="0">Desativado</option>
								<option value="1">Ativado</option>
							</select>
						</div>

						<div class="form-group">
							<input type="submit" value="Cadastrar banner" class="btn btn-rose btn-rose-light btn-full btn-medium" />
						</div>
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