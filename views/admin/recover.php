<?php
if(!empty($_GET["token"])){
	$User = new User;

	$isTokenValid = $User->isTokenValid($_GET["token"]);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto ‹ Painel Administrativo</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">

		<div class="admin__auth">
			
			<div class="admin__auth--form">
				<img src="<?=PATH?>assets/images/logo-csa.png" alt="Logotipo do Canal Salto Alto" class="logo" />
				<h1>Redefina sua senha do painel administrativo</h1>

				<form action="javascript:void(0)" method="get" onsubmit="Admin.recover(this)" data-inprogress="<?=((isset($isTokenValid)) ? $isTokenValid : '')?>">
					<div class="message"></div>

					<?php if(!empty($_GET["token"]) AND $isTokenValid == true): ?>
					<div class="row mb-3">
						<div class="col">
							<span for="recover_password" class="form-label">Digite sua nova senha</span>
							<input type="password" class="form-control" id="recover_password" name="recover_password" placeholder="" required />
						</div>
					</div>
					<div class="row mb-3">
						<div class="col">
							<span for="recover_confirmation_password" class="form-label">Confirme sua nova senha</span>
							<input type="password" class="form-control" id="recover_confirmation_password" name="recover_confirmation_password" placeholder="" required />
						</div>
					</div>
					<div class="row mt-5">
						<div class="col text-center">
							<button class="btn btn-rose btn-full mb-2">ATUALIZAR SENHA</button>
						</div>
					</div>
					<input type="hidden" name="recovery_token" id="recovery_token" value="<?=$_GET["token"]?>" />


					<?php else: ?>
					<div class="row mb-3">
						<div class="col">
							<label for="recover_email" class="form-label">E-mail</label>
							<input type="email" class="form-control" id="recover_email" name="recover_email" placeholder="Seu e-mail" required />
						</div>
					</div>
					<div class="row mt-5">
						<div class="col text-center">
							<button class="btn btn-rose btn-full mb-2">ENVIAR E-MAIL DE RECUPERAÇÃO</button>
						</div>
					</div>

					<?php endif; ?>
				</form>

			</div>
		</div>


		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>
	</body>
</html>