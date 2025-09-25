<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$coupon->code?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">
	<?=Template::render(null, "after-body-tags")?>

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Editando: <?=$coupon->code?></h1>
					
					<form action="javascript:void(0)" method="post" onsubmit="Admin.Coupons.update(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>
						<div class="row mb-3">
							<div class="col">
								<label for="coupon_code" class="form-label">Código do Cupom</label>
								<input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Digite o código do cupom." required onkeyup="this.value=this.value.replace(/\s+/g, '');" value="<?=$coupon->code?>" />
								<small>Não utilize espaços no código do cupom.</small>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="coupon_discount_type">Tipo de Desconto</label>
								<select name="coupon_discount_type" id="coupon_discount_type" class="form-control">
									<option value="percent" <?=($coupon->discount_type == 'percent') ? 'selected' : ''?>>Porcentagem (%)</option>
									<option value="value" <?=($coupon->discount_type == 'value') ? 'selected' : ''?>>Valor (R$)</option>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label for="coupon_discount_value">Valor de Desconto</label>
								<input type="text" name="coupon_discount_value" id="coupon_discount_value" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" value="<?=$coupon->discount_value?>">
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="expiration_date">Data de Expiração</label>
								<?php
									$expirationDate = $coupon->expiration_date ? date('d/m/Y H:i', strtotime($coupon->expiration_date)) : '';
								?>
								<input type="text" name="expiration_date" id="expiration_date" class="form-control" data-mask="00/00/0000 00:00" value="<?=$expirationDate?>" />
							</div>
							<div class="col-md-6 mb-3">
								<label for="status">Status do Cupom</label>
								<select name="status" id="status" class="form-control">
									<option value="1" <?=($coupon->status == 1) ? 'selected' : ''?>>Ativo</option>
									<option value="0" <?=($coupon->status == 0) ? 'selected' : ''?>>Inativo</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<input type="submit" value="Atualizar" class="btn btn-rose btn-rose-light btn-full btn-medium" />
						</div>
                        <input type="hidden" name="coupon_id" id="coupon_id" value="<?=$coupon->coupon_id?>" />
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