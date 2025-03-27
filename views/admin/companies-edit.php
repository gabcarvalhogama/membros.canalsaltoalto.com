<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Editando: <?=$company->company_name?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">
	<?=Template::render(null, "after-body-tags")?>

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Editando: <?=$company->company_name?></h1>
					
					<form action="javascript:void(0)" method="post" onsubmit="Companies.update(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>

						

						<div class="row">
							<div class="col mb-3">
								<label for="status" class="form-label">Status da Empresa</label>
								<select name="status" id="status" class="form-control" required>
									<option value="0" <?=($company->status == "0") ? "selected" : ""?> >Desativada</option>
									<option value="1" <?=($company->status == "1") ? "selected" : ""?>>Ativada</option>
									<option value="2" <?=($company->status == "2") ? "selected" : ""?>>Pendente (Nova Empresa)</option>
									<option value="3" <?=($company->status == "3") ? "selected" : ""?>>Pendente (Edição)</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="company_owner" class="form-label">Dona da empresa</label>
								<select name="company_owner" id="company_owner" class="form-control" data-selected="<?=$company->company_id?>">
									<option value="">Selecione uma opção</option>
									<?php
										$User = new User;
										$getUsers = $User->getUsers();

										foreach($getUsers->fetchAll(PDO::FETCH_ASSOC) as $user):
									?>
									<option <?=($company->iduser == $user['iduser']) ? 'selected' : '' ?> value="<?=$user['iduser']?>"><?=$user['firstname']." ".$user['lastname']?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="company_name" class="form-label">Nome da empresa</label>
								<input type="text" class="form-control" id="company_name" name="company_name" value="<?=$company->company_name?>" required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="company_description" class="form-label">Descrição da Empresa</label>
								<textarea name="company_description" id="company_description" class="form-control"><?=$company->company_description?></textarea>
							</div>
						</div>

						<div class="row align-items-center">
							<div class="col-md-3 mb-3">
								<img src="/<?=$company->company_image?>" style="max-width:  100%" alt="">
							</div>
							<div class="col-md-9 mb-3">
								<label for="company_image">Imagem em destaque</label>
								<input type="file" name="company_image" data-actual_company_image="<?=$company->company_image?>" id="company_image" class="form-control" accept="image/*" />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<input type="checkbox" name="has_place" id="has_place"  <?=($company->has_place == 0) ? '' : 'checked' ?> onchange="$('address_group').toggle()" /> <label for="has_place">A empresa tem um endereço físico.</label>
							</div>
						</div>

						<address_group style="display: <?=($company->has_place == 0) ? 'none' : 'block' ?>;">
						<div class="row">
							<div class="col mb-3">
								<label for="address_zipcode">CEP</label>
								<input type="text" class="form-control" id="address_zipcode" name="address_zipcode" value="<?=$company->address_zipcode?>" data-mask="00.000-000" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="address_state" class="form-label">Estado</label>
								<select name="address_state" id="address_state" class="form-control address-fields" >
									<option value="">Selecione uma opção</option>
									<?php
										foreach(User::getStates()->fetchAll(PDO::FETCH_ASSOC) as $state)
											echo '<option '. (($state["idstate"] == $company->address_state) ? "selected" : "") .' value="'.$state["idstate"].'" data-uf="'.$state["uf"].'"  >'.$state["state"].'</option>';
									?>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label for="address_city" class="form-label address-fields">Cidade</label>
								<select name="address_city" id="address_city" class="form-control">
									<option value=""></option>
									<?php
										foreach(User::getCitiesByUf($company->address_state)->fetchAll(PDO::FETCH_ASSOC) as $city)
											echo '<option '. (($city["idcity"] == $company->address_city) ? "selected" : "") .' value="'.$city["idcity"].'" data-uf="'.$city["uf"].'"  >'.$city["city"].'</option>';
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

						<div class="d-flex flex-row align-items-center">
							<input type="submit" value="Atualizar empresa" class="btn btn-rose btn-rose-light" />
							<a href="javascript:void(0)" style="margin-left:  20px;color: #000" onclick="Companies.delete(<?=$company->company_id?>)">Apagar empresa</a>
						</div>
						<input type="hidden" name="company_id" id="company_id" value="<?=$company->company_id?>">
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