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
				<h1>Faça login na área do administrador</h1>
				<form action="javascript:void(0)" method="get" onsubmit="Admin.login(this)">
					<div class="message"></div>
					<div class="row mb-3">
						<div class="col">
							<label for="login_email" class="form-label">E-mail</label>
							<input type="email" class="form-control" id="login_email" name="login_email" placeholder="Seu e-mail" required />
						</div>
					</div>
					<div class="row mb-3">
						<div class="col">
							<label for="login_password" class="form-label">Senha</label>
							<input type="password" class="form-control" id="login_password" name="login_password" placeholder="Sua senha" required />
						</div>
					</div>
					<div class="row mt-5">
						<div class="col text-center">
							<button class="btn btn-rose btn-full mb-2">ENTRAR</button>
							<a href="<?=PATH?>admin/recover">Recupere sua conta</a>
						</div>
					</div>
				</form>
			</div>
		</div>


		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
	</body>
</html>