<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Visualizando: <?=$user->firstname?> ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Visualizando: <?=$user->firstname?></h1>
					<form action="javascript:void(0)" method="post" accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>

						<div class="row align-items-center">
							<div class="col mb-3">
								<img src="<?=PATH.$user->profile_photo?>" alt="" style="width: 150px;">
							</div>
						</div>


						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="member_name" class="form-label">Nome</label>
								<input type="text" class="form-control" id="member_name" name="member_name" placeholder="" value="<?=$user->firstname?>" disabled />
							</div>
							<div class="col-md-6 mb-3">
								<label for="member_lastname" class="form-label">Sobrenome</label>
								<input type="text" class="form-control" id="member_lastname" name="member_lastname" placeholder="" value="<?=$user->lastname?>" disabled />
							</div>
						</div>


						<div class="row">
							<div class="col mb-3">
								<label for="member_biography" class="form-label">Biografia</label>
								<textarea class="form-control" id="member_biography" name="member_biography" disabled><?=$user->biography?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="member_cpf" class="form-label">CPF</label>
								<input type="text" class="form-control" id="member_cpf" name="member_cpf" placeholder="" value="<?=$user->cpf?>" data-mask="000.000.000-00" disabled />
							</div>
							<div class="col-md-6 mb-3">
								<label for="member_birthdate" class="form-label">Data de Nascimento</label>
								<input type="date" class="form-control" name="member_birthdate" id="member_birthdate" name="member_birthdate" value="<?=$user->birthdate?>" disabled />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="member_biography" class="form-label">CEP</label>
								<input type="text" class="form-control" id="member_zipcode" name="member_zipcode" value="<?=$user->zipcode?>" disabled />
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label for="member_state" class="form-label">Estado</label>
								<select name="member_state" id="member_state" class="form-control address-fields" disabled onchange="Admin.loadCities(this)">
									<option value="">Selecione uma opção</option>
									<?php
										foreach(User::getStates()->fetchAll(PDO::FETCH_ASSOC) as $state)
											echo '<option '.(($user->address_state == $state["idstate"]) ? "selected" : "").' value="'.$state["idstate"].'" data-uf="'.$state["uf"].'"  >'.$state["state"].'</option>';
									?>
								</select>
							</div>
							<div class="col-md-6">
								<label for="member_city" class="form-label address-fields">Cidade</label>
								<select name="member_city" id="member_city" class="form-control" disabled>
									<option value="">Selecione um estado</option>
									<?php
										foreach(User::getCitiesByUf($user->address_state)->fetchAll(PDO::FETCH_ASSOC) as $city)
											echo '<option '.(($user->address_city == $city["idcity"]) ? "selected" : "").' value="'.$city["idcity"].'">'.$city["city"].'</option>';

									?>
								</select>
							</div>
						</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="member_address" class="form-label address-fields">Seu Endereço</label>
									<input type="text" class="form-control" id="member_address" name="member_address" placeholder="Av., Rua, etc." value="<?=$user->address?>" disabled />
								</div>
								<div class="col-md-6">
									<label for="member_address_number" class="form-label address-fields">Número</label>
									<input type="text" class="form-control" id="member_address_number" name="member_address_number" placeholder="" value="<?=$user->address_number?>" disabled />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="member_neighborhood" class="form-label address-fields">Seu Bairro</label>
									<input type="text" class="form-control" id="member_neighborhood" name="member_neighborhood" placeholder="" value="<?=$user->address_neighborhood?>" disabled />
								</div>
								<div class="col-md-6">
									<label for="member_complement" class="form-label address-fields">Complemento</label>
									<input type="text" class="form-control" id="member_complement" name="member_complement" value="<?=$user->address_complement?>" placeholder="" disabled />
								</div>
							</div>

							
							<div class="row mb-3">
								<div class="col">
									<label for="member_cellphone" class="form-label">Celular</label>
									<input type="text" class="form-control" id="member_cellphone" name="member_cellphone" placeholder="(__) _ ____-____" value="<?=$user->cellphone?>" disabled />
								</div>
							</div>

							
							<div class="row mb-3">
								<div class="col">
									<label for="member_email" class="form-label">E-mail</label>
									<input type="email" class="form-control" id="member_email" name="member_email" disabled value="<?=$user->email?>" disabled />
								</div>
							</div>
						<div>
						</div>
<!-- 
						<input type="hidden" name="member_iduser" id="member_iduser" value="<?=$user->iduser?>"> -->
					</form>

					<hr class="m-5">

					<h2>Assinaturas e Pedidos</h2>
					<table class="table">
						<thead>
							<tr>
								<td>ID</td>
								<td>Valor</td>
								<td>Método</td>
								<td>Status</td>
								<td>Início</td>
								<td>Fim</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$Membership = new Membership;
								$getMemberships = $Membership->getMembershipsByUser(USER->iduser);

								if($getMemberships->rowCount() > 0):
									foreach($getMemberships->fetchAll(PDO::FETCH_ASSOC) as $membership):
							?>
								<tr>
									<td><?=$membership['order_id']?></td>
									<td><?=$membership['payment_value']?></td>
									<td><?=ucfirst($membership['payment_method'])?></td>
									<td><?php
										switch($membership['status']){
											case 'paid':
											echo 'Pago';
											break;
											case 'pending':
											echo 'Aguardando Pagamento';
											break;
											default:
											echo 'Cancelado';
											break;
										}
									?></td>
									<td><?=$membership['starts_at']?></td>
									<td><?=$membership['ends_at']?></td>
								</tr>
							<?php endforeach; else: ?>
								<tr><td colspan="6">Nenhum registro encontrado.</td></tr>
							<?php endif; ?>
						</tbody>
					</table>

					<hr class="m-5">

					<h2 class="mb-2">Empresas Cadastradas</h2>
					<div class="companies-list">
						<?php
					  		$Company = new Company;
					  		$companies = $Company->getCompaniesByOwnerAndStatus($user->iduser, 1);
					  		if($companies->rowCount() > 0):
					  			foreach($companies->fetchAll(PDO::FETCH_ASSOC) as $company):
					  				echo Template::render($company, "loop_companies");
					  			endforeach; endif; ?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>	
	</body>
</html>