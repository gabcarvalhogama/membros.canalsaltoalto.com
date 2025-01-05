<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Alterar Senha ‹ Área de Membros ‹ Canal Salto Alto</title>

		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__profile">
			<div class="container-xl">

				<div class="profile__header">
					<div class="profile__header--photo">
						<label for="f_profile_photo"><img src="<?=PATH?>

							<?php 
								if(empty(USER->profile_photo))
									echo 'assets/images/profile-icon.png';
								else
									echo USER->profile_photo;
							?>

						" id="profile__header--photo-image" alt="" /></label>
						<form action="javascript:void(0)" id="updateProfilePhoto">
							<input type="file" id="f_profile_photo" accept="image/*" class="d-none" onchange="App.updateProfilePhoto(this)">
						</form>
					</div>
					<div class="profile__header--presentation">
						<h2><?=USER->firstname . " ". USER->lastname?></h2>
						<div class="bio">
							<?=USER->biography?>
						</div>
					</div>
				</div>

				<div class="profile__section">
					<?php include "profile.menu.php"; ?>
					<div class="profile__section--content">
						<h3>Alterar senha</h3>
						<form action="javascript:void(0)" method="post" onsubmit="App.updatePassword(this)">
							<div class="message"></div>

							<div class="row mb-3">
								<div class="col">
									<label for="new_password">Nova senha</label>
									<input type="password" name="new_password" id="new_password" class="form-control" />
								</div>
								<div class="col">
									<label for="r_new_password">Repita a nova senha</label>
									<input type="password" name="r_new_password" id="r_new_password" class="form-control" />
								</div>
							</div>

							
							<div class="row">
								<div class="col">
									<button class="btn btn-rose btn-rounded btn-full">ATUALIZAR SENHA</buton>
								</div>
							</div>
						</form>
					</div>
				</div>


			</div>
		</section>

		<?=Template::render(null, "footer_app")?>

		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js?<?=uniqid()?>"></script>
	</body>
</html>