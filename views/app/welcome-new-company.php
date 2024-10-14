<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Cadastre sua Empresa ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">

		<section class="app__welcome mt-5 mb-5">
			<div class="container-xl d-flex flex-column align-items-center">
				<div class="app__welcome--box">
					<img src="<?=PATH?>assets/images/logo-csa-white.png" alt="Logotipo do Canal Salto Alto" class="app__welcome--logo mb-2" />
					<h2 class="text-center">Seja bem-vinda ao Canal Salto Alto!</h2>
					<p class="text-center text-white">Vamos cadastrar a sua empresa. Não se preocupe, você poderá editar essas informações posteriormente.</p>
					<p style="font-size: .8rem;"><small class="text-danger">*</small> Os campos marcados são de preenchimento obrigatório.</p>


					<form action="javascript:void(0)" method="post" onsubmit="App.newCompanyFromWelcome(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>
						
						<div class="row">
							<div class="col mb-3">
								<label for="company_name" class="form-label">Nome da empresa <small class="text-danger">*</small></label>
								<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Escreva aqui o título do conteúdo." required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="company_description" class="form-label">Descrição da Empresa <small class="text-danger">*</small></label>
								<textarea name="company_description" id="company_description" class="form-control" maxlength="150"></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="company_image">Imagem em destaque</label>
								<input type="file" name="company_image" id="company_image" class="form-control" accept="image/*" />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<input type="checkbox" name="has_place" id="has_place" onchange="$('address_group').toggle()" /> <label for="has_place">A empresa tem um endereço físico.</label>
							</div>
						</div>

						<address_group style="display: none;">
						<div class="row">
							<div class="col mb-3">
								<label for="address_zipcode">CEP</label>
								<input type="text" class="form-control" id="address_zipcode" name="address_zipcode" data-mask="00.000-000" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="address_state" class="form-label">Estado</label>
								<select name="address_state" id="address_state" class="form-control address-fields" onchange="App.loadCities(this)">
									<option value="">Selecione uma opção</option>
									<?php
										foreach(User::getStates()->fetchAll(PDO::FETCH_ASSOC) as $state)
											echo '<option value="'.$state["idstate"].'" data-uf="'.$state["uf"].'"  >'.$state["state"].'</option>';
									?>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label for="address_city" class="form-label address-fields">Cidade</label>
								<select name="address_city" id="address_city" class="form-control">
									<option value="">Selecione um estado</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8 mb-3">
								<label for="address" class="form-label address-fields">Endereço</label>
								<input type="text" class="form-control" id="address" name="address" placeholder="Av., Rua, etc." />
							</div>
							<div class="col-md-4 mb-3">
								<label for="address_number" class="form-label address-fields">Número</label>
								<input type="text" class="form-control" id="address_number" name="address_number" placeholder="" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="address_neighborhood" class="form-label address-fields">Seu Bairro</label>
								<input type="text" class="form-control" id="address_neighborhood" name="address_neighborhood" placeholder="" />
							</div>
							<div class="col-md-6 mb-3">
								<label for="address_complement" class="form-label address-fields">Complemento</label>
								<input type="text" class="form-control" id="address_complement" name="address_complement" placeholder="" />
							</div>
						</div>
						</address_group>

						<div class="row">
							<div class="col mb-3">
								<label for="cellphone" class="form-label">Celular <small class="text-danger">*</small></label>
								<input type="text" class="form-control" id="cellphone" name="cellphone" placeholder="" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="instagram_url" class="form-label">Instagram</label>
								<input type="text" class="form-control" id="instagram_url" name="instagram_url" placeholder="https://instagram.com/username" />
							</div>
							<div class="col-md-6 mb-3">
								<label for="site_url" class="form-label">Site</label>
								<input type="text" class="form-control" id="site_url" name="site_url" placeholder="https://site.com" />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="facebook_url" class="form-label">Facebook</label>
								<input type="text" class="form-control" id="facebook_url" name="facebook_url" placeholder="" />
							</div>
						</div>

						<div>
							<input type="submit" value="Criar empresa" class="btn btn-rose btn-medium btn-full btn-rounded" />
						</div>
					</form>
				</div>
			</div>
		</section>


		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<!-- <script type="text/javascript" src="<?=PATH?>assets/js/checkout.js?<?=uniqid()?>"></script> -->
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js?<?=uniqid()?>"></script>
	</body>
</html>