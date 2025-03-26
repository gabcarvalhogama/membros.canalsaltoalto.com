<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$company->company_name?> ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__newCompany mt-5 mb-5">
			<div class="container-xl">
				<h2>Editando: <span class="color-primary"><?=$company->company_name?>.</span></h2>
				<form action="javascript:void(0)" method="post" onsubmit="App.updateCompany(this)"  accept-charset="utf-8" enctype="multipart/form-data">
					<div class="message">
						<?php 
							if(!empty($_GET["updated"]) AND $_GET["updated"] == 1){
								echo '<div class="alert alert-success" role="alert">Sua empresa foi atualizada, <strong>mas ainda não está visível. Aguarde a aprovação da edição pela equipe Canal Salto Alto!</strong></div>';
							}
						?>
					</div>
					
					<div class="row">
						<div class="col mb-3">
							<label for="company_name" class="form-label">Nome da empresa</label>
							<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Escreva aqui o título do conteúdo." required value="<?=$company->company_name?>" />
						</div>
					</div>

					<div class="row">
						<div class="col mb-3">
							<label for="company_description" class="form-label">Descrição da Empresa</label>
							<textarea name="company_description" id="company_description" class="form-control"><?=$company->company_description?></textarea>
						</div>
					</div>

					<div class="row align-items-center mb-5">
                        <div class="col-3">
                            <img src="<?=PATH.$company->company_image?>" alt="" style="width: 100%;" />
                        </div>
						<div class="col-9 mb-3">
							<label for="company_image">Imagem em destaque</label>
							<input type="file" name="company_image" id="company_image" class="form-control" accept="image/*" />
						</div>
					</div>

					<div class="row">
						<div class="col mb-3">
							<input type="checkbox" name="has_place" id="has_place" onchange="$('address_group').toggle()" <?=($company->has_place == 1) ? "checked" : ""?> /> <label for="has_place">A empresa tem um endereço físico.</label>
						</div>
					</div>

					<address_group style="display: <?=($company->has_place == 1) ? "block" : "none"?>;">
					<div class="row">
						<div class="col mb-3">
							<label for="address_zipcode">CEP</label>
							<input type="text" class="form-control" id="address_zipcode" name="address_zipcode" data-mask="00.000-000" value="<?=$company->address_zipcode?>" />
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="address_state" class="form-label">Estado</label>
							<select name="address_state" id="address_state" class="form-control address-fields" onchange="App.loadCities(this)">
								<option value="">Selecione uma opção</option>
								<?php
									foreach(User::getStates()->fetchAll(PDO::FETCH_ASSOC) as $state)
										echo '<option value="'.$state["idstate"].'" data-uf="'.$state["uf"].'" '.(($state["idstate"] == $company->address_state) ? "selected" : "").' >'.$state["state"].'</option>';
								?>
							</select>
						</div>
						<div class="col-md-6 mb-3">
							<label for="address_city" class="form-label address-fields">Cidade</label>
							<select name="address_city" id="address_city" class="form-control">
                                <option value="">Selecione um estado</option>
                                <?php
                                    foreach(User::getCitiesByUf($company->address_state)->fetchAll(PDO::FETCH_ASSOC) as $city)
                                        echo '<option '.(($company->address_city == $city["idcity"]) ? "selected" : "").' value="'.$city["idcity"].'">'.$city["city"].'</option>';

                                ?>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 mb-3">
							<label for="address" class="form-label address-fields">Endereço</label>
							<input type="text" class="form-control" id="address" name="address" placeholder="Av., Rua, etc." value="<?=$company->address?>" />
						</div>
						<div class="col-md-4 mb-3">
							<label for="address_number" class="form-label address-fields">Número</label>
							<input type="text" class="form-control" id="address_number" name="address_number" placeholder="" value="<?=$company->address_number?>" />
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="address_neighborhood" class="form-label address-fields">Seu Bairro</label>
							<input type="text" class="form-control" id="address_neighborhood" name="address_neighborhood" placeholder="" value="<?=$company->address_neighborhood?>" />
						</div>
						<div class="col-md-6 mb-3">
							<label for="address_complement" class="form-label address-fields">Complemento</label>
							<input type="text" class="form-control" id="address_complement" name="address_complement" placeholder="" value="<?=$company->address_complement?>" />
						</div>
					</div>
					</address_group>

					<div class="row">
						<div class="col mb-3">
							<label for="cellphone" class="form-label">Celular</label>
							<input type="text" class="form-control" id="cellphone" name="cellphone" placeholder="" value="<?=$company->cellphone?>" />
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="instagram_url" class="form-label">Instagram</label>
							<input type="text" class="form-control" id="instagram_url" name="instagram_url" placeholder="https://instagram.com/username" value="<?=$company->instagram_url?>" />
						</div>
						<div class="col-md-6 mb-3">
							<label for="site_url" class="form-label">Site</label>
							<input type="text" class="form-control" id="site_url" name="site_url" placeholder="https://site.com" value="<?=$company->site_url?>" />
						</div>
					</div>

					<div class="row">
						<div class="col mb-3">
							<label for="facebook_url" class="form-label">Facebook</label>
							<input type="text" class="form-control" id="facebook_url" name="facebook_url" placeholder="" value="<?=$company->facebook_url?>" />
						</div>
					</div>

					<div>
						<input type="submit" value="Atualizar empresa" class="btn btn-rose btn-medium btn-full btn-rounded" />
					</div>

                    <input type="hidden" name="company_id" id="company_id" value="<?=$company->company_id?>" />
				</form>
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