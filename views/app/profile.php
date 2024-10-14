<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Meu Perfil ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
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
								if(empty($user->profile_photo))
									echo 'assets/images/profile-icon.png';
								else
									echo $user->profile_photo;
							?>

						" id="profile__header--photo-image" alt="" /></label>
						<form action="javascript:void(0)" id="updateProfilePhoto">
							<input type="file" id="f_profile_photo" accept="image/*" class="d-none" onchange="App.updateProfilePhoto(this)">
						</form>
					</div>
					<div class="profile__header--presentation">
						<h2><?=$user->firstname . " ". $user->lastname?></h2>
						<div class="bio">
							<?=$user->biography?>
						</div>
					</div>
				</div>

				<div class="profile__section">
					<?php include "profile.menu.php"; ?>
					<div class="profile__section--content">
						<h3>Informações Básicas</h3>
						<form action="javascript:void(0)" method="post" onsubmit="App.updateUser(this)">
							<div class="message"></div>

							<div class="row">
								<div class="mb-3">
									<label for="f_biography" class="form-label">Sua biografia</label>
									<textarea name="f_biography" id="f_biography" class="form-control"><?=$user->biography?></textarea>
								</div>
							</div>

							<div class="row">
								<div class="mb-3 col-md-6">
									<label for="f_firstname" class="form-label">Seu nome</label>
									<input type="text" class="form-control" id="f_firstname" name="f_firstname" placeholder="Seu nome" required value="<?=$user->firstname?>" />
								</div>
								<div class="mb-3 col-md-6">
									<label for="f_lastname" class="form-label">Seu sobrenome</label>
									<input type="text" class="form-control" id="f_lastname" name="f_lastname" placeholder="Seu sobrenome" required value="<?=$user->lastname?>" />
								</div>
							</div>
							<div class="row">
								<div class="mb-3 col-md-6">
									<label for="f_cpf" class="form-label">Seu CPF</label>
									<input type="text" class="form-control" id="f_cpf" name="f_cpf" placeholder="Seu CPF" required data-mask="000.000.000-00" value="<?=$user->cpf?>" />
								</div>
								<div class="mb-3 col-md-6">
									<label for="f_birthdate" class="form-label">Sua Data de Nascimento</label>
									<input type="date" class="form-control" id="f_birthdate" name="f_birthdate" placeholder="Sua data de nascimento" required value="<?=$user->birthdate?>" />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_zipcode" class="form-label">CEP</label>
									<input type="text" class="form-control" id="f_zipcode" name="f_zipcode" placeholder="Digite seu CEP" required data-mask="00.000-000" onkeyup="Checkout.getCep(this)"  value="<?=$user->zipcode?>" />
								</div>
								<div class="col-md-6 d-flex align-items-end">
									<a href="" class="dont-know-cep">Não sei meu CEP</a>
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_state" class="form-label">Estado</label>
									<select name="f_state" id="f_state" class="form-control address-fields" required onchange="App.loadCities(this)">
										<option value="">Selecione uma opção</option>
										<?php
											foreach(User::getStates()->fetchAll(PDO::FETCH_ASSOC) as $state)
												echo '<option value="'.$state["idstate"].'" data-uf="'.$state["uf"].'"'. (($state["idstate"] == $user->address_state) ? "selected" : "") .'>'.$state["state"].'</option>';
										?>
									</select>
								</div>
								<div class="col-md-6">
									<label for="f_city" class="form-label address-fields">Cidade</label>
									<select name="f_city" id="f_city" class="form-control" required>
										<?php 
											foreach(User::getCitiesByUf($user->address_state)->fetchAll(PDO::FETCH_ASSOC) as $city):
										?>
											<option value="<?=$city['idcity']?>" <?=(($city["idcity"] == $user->address_city) ? "selected" : "")?>  ><?=$city['city']?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_address" class="form-label address-fields">Seu Endereço</label>
									<input type="text" class="form-control" id="f_address" name="f_address" placeholder="Av., Rua, etc." required  value="<?=$user->address?>" />
								</div>
								<div class="col-md-6">
									<label for="f_address_number" class="form-label address-fields">Número</label>
									<input type="text" class="form-control" id="f_address_number" name="f_address_number" placeholder=""  value="<?=$user->address_number?>" required />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_neighborhood" class="form-label address-fields">Seu Bairro</label>
									<input type="text" class="form-control" id="f_neighborhood" name="f_neighborhood" placeholder="" required  value="<?=$user->address_neighborhood?>" />
								</div>
								<div class="col-md-6">
									<label for="f_complement" class="form-label address-fields">Complemento</label>
									<input type="text" class="form-control" id="f_complement" name="f_complement" placeholder=""  value="<?=$user->address_complement?>" />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col">
									<label for="f_cellphone" class="form-label">Seu Celular</label>
									<input type="text" class="form-control" id="f_cellphone" name="f_cellphone" placeholder="(__) _ ____-____" required  value="<?=$user->cellphone?>" />
								</div>
							</div>

							<div class="row">
								<div class="col">
									<button class="btn btn-rose btn-rounded btn-full">ATUALIZAR DADOS</buton>
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
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>