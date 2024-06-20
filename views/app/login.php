<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto - Seja Membro</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">

		<div class="app__auth">
			<div class="app__auth--bg" style="background-image: url('<?=PATH?>assets/images/auth-image.jpg');">
				BG
			</div>
			<div class="app__auth--sidebar">
				<img src="<?=PATH?>assets/images/logo-csa-white.png" alt="Logotipo do Canal Salto Alto" class="logo" />
				<h1>Faça login na sua conta</h1>
				<form action="javascript:void(0)" method="get" onsubmit="App.login(this)">
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
							<a href="<?=PATH?>app/recover">Esqueci minha senha</a>
						</div>
					</div>
				</form>
			</div>
		</div>


		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>