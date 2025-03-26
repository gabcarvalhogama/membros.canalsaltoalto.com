<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Novo Cupom ‹ Painel Administrativo ‹ Canal Salto Alto</title>		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">
	<?=Template::render(null, "after-body-tags")?>

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Criar um novo cupom</h1>
					
					<form action="javascript:void(0)" method="post" onsubmit="Admin.Coupons.new(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>
						<div class="row mb-3">
							<div class="col">
								<label for="coupon_code" class="form-label">Código do Cupom</label>
								<input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Digite o código do cupom." required onkeyup="this.value=this.value.replace(/\s+/g, '');" />
								<small>Não utilize espaços no código do cupom.</small>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="coupon_discount_type">Tipo de Desconto</label>
								<select name="coupon_discount_type" id="coupon_discount_type" class="form-control">
									<option value="percent">Porcentagem (%)</option>
									<option value="value">Valor (R$)</option>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label for="coupon_discount_value">Valor de Desconto</label>
								<input type="text" name="coupon_discount_value" id="coupon_discount_value" class="form-control" data-mask="#.##0,00" data-mask-reverse="true">
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="expiration_date">Data de Expiração</label>
								<input type="text" name="expiration_date" id="expiration_date" class="form-control" data-mask="00/00/0000 00:00" />
							</div>
							<div class="col-md-6 mb-3">
								<label for="status">Status do Cupom</label>
								<select name="status" id="status" class="form-control">
									<option value="1">Ativo</option>
									<option value="0">Inativo</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<input type="submit" value="Cadastrar" class="btn btn-rose btn-rose-light btn-full btn-medium" />
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