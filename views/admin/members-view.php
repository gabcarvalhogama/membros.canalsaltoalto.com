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
	<?=Template::render(null, "after-body-tags")?>

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
					</form>

					<div class="mt-5 d-flex align-items-center">
						<h2>Assinaturas e Pedidos</h2>
						<button class="ms-md-3 btn btn-rose btn-rounded btn-rose-light" data-bs-toggle="modal" data-bs-target="#addMembershipModal">Cadastrar assinatura</button>
					</div>
					<table class="table">
						<thead>
							<tr>
								<td>ID</td>
								<td>Valor</td>
								<td>Método</td>
								<td>Status</td>
								<td>Início</td>
								<td>Fim</td>
								<td>Ações</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$Membership = new Membership;
								$getMemberships = $Membership->getMembershipsByUser($user->iduser);

								if($getMemberships->rowCount() > 0):
									foreach($getMemberships->fetchAll(PDO::FETCH_ASSOC) as $membership):
							?>
								<tr>
									<td><?=$membership['order_id']?></td>
									<td>R$ <?=Validation::decimalToReal($membership['payment_value'])?></td>
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
									<td><?=Validation::convertUSDateToBr($membership['starts_at'])?></td>
									<td><?=Validation::convertUSDateToBr($membership['ends_at'])?></td>
									<td><a href="javascript:void(0)" onclick="Admin.deleteMembership(<?=$membership['idusermembership']?>)">Apagar</a></td>
								</tr>
							<?php endforeach; else: ?>
								<tr><td colspan="6">Nenhum registro encontrado.</td></tr>
							<?php endif; ?>
						</tbody>
					</table>

					<h2 class="mt-5 mb-2">Empresas Cadastradas</h2>
					<div class="companies-list">
						<?php
					  		$Company = new Company;
					  		$companies = $Company->getCompaniesByOwnerAndStatus($user->iduser, 1);
					  		if($companies->rowCount() > 0):
					  			foreach($companies->fetchAll(PDO::FETCH_ASSOC) as $company):
					  				echo Template::render($company, "loop_companies");
					  			endforeach;

					  		else: ?>
					  			<div>
					  				<p>Nenhuma empresa foi cadastrada para este membro.</p>
					  			</div>
					  		<?php 

					  		endif; ?>
					</div>

					<section>
						<div class="mt-5 d-flex align-items-center">
							<h2>Consultorias Realizadas</h2>
							<button class="ms-md-3 btn btn-rose btn-rounded btn-rose-light" data-bs-toggle="modal" data-bs-target="#addConsultingModal">Cadastrar consultoria</button>
						</div>
						<table class="table">
							<thead>
								<tr>
									<td>Data</td>
									<td>Observações</td>
									<td>Ações</td>
								</tr>
							</thead>
							<tbody>
								<?php
									$Consulting = new Consulting;
									$getConsulting = $Consulting->getConsultingByUserId($user->iduser);
									if($getConsulting->rowCount() > 0):
										foreach($getConsulting->fetchAll(PDO::FETCH_ASSOC) as $consulting):
								?>
									<tr>
										<td><?=$consulting['consulting_date']?></td>
										<td><?=ucfirst($consulting['consulting_observation'])?></td>
										<td><a href="javascript:void(0)" onclick="Admin.deleteConsulting(<?=$consulting['user_consulting_id']?>)">Apagar</a></td>
									</tr>
								<?php endforeach; else: ?>
									<tr><td colspan="6">Nenhum registro encontrado.</td></tr>
								<?php endif; ?>
							</tbody>
						</table>
					</section>

					<section>
						<div class="mt-5 d-flex align-items-center">
							<h2>Participação em Eventos</h2>
						</div>
						
						<table class="table">
							<thead>
								<tr>
									<td>Evento</td>
									<td>Check-In</td>
									<!-- <td>Ações</td> -->
								</tr>
							</thead>
							<tbody>
								<?php
									$Event = new Event;
									$getCheckInByUser = $Event->getCheckInByUser($user->iduser);
									if($getCheckInByUser->rowCount() > 0):
										foreach($getCheckInByUser->fetchAll(PDO::FETCH_ASSOC) as $checkin):
								?>
									<tr>
										<td><?=$checkin['event_title']?></td>
										<td><?=date("d/m/Y \à\s H:i", strtotime($checkin['checkin_at']))?></td>
									</tr>
								<?php endforeach; else: ?>
									<tr><td colspan="6">Nenhum registro encontrado.</td></tr>
								<?php endif; ?>
							</tbody>
						</table>
					</section>
					

					<section>
						<div class="mt-5 d-flex align-items-center">
							<h2>Diamantes</h2>
							<button class="ms-md-3 btn btn-rose btn-rounded btn-rose-light" data-bs-toggle="modal" data-bs-target="#addDiamondsModal">Cadastrar diamante</button>
						</div>
						<table class="table">
							<thead>
								<tr>
									<td>Diamantes</td>
									<td>Tipo</td>
									<td>Observações</td>
									<td>Criado</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
								<?php
									$User = new User;
									$getDiamondByUserId = $User->getAllDiamondsByUserId($user->iduser);
									if($getDiamondByUserId->rowCount() > 0):
										foreach($getDiamondByUserId->fetchAll(PDO::FETCH_ASSOC) as $diamond):
								?>
									<tr>
										<td><?=$diamond['diamond_value']?></td>
										<td>
											<?=$diamond['diamond_origin_type']?>
											<?php
												if($diamond['diamond_origin_type'] == 'event_checkin'){
													$Event = new Event;
													$event = $Event->getEventById($diamond['diamond_origin_id']);
													if($event->rowCount() > 0){
														$event = $event->fetch(PDO::FETCH_OBJ);
														echo ' - <a href="'.PATH.'app/events/'.$event->slug.'">'.$event->event_title.'</a>';
													}
												}
											?>
										</td>
										<td><?=$diamond['diamond_observation']?></td>
										<td><?=date("d/m/Y \à\s H:i", strtotime($diamond['created_at']))?></td>
										<td><a href="javascript:void(0)" onclick="Admin.deleteDiamonds(<?=$diamond['user_diamonds_id']?>)">Apagar</a></td>
									</tr>
								<?php endforeach; else: ?>
									<tr><td colspan="6">Nenhum registro encontrado.</td></tr>
								<?php endif; ?>
							</tbody>
						</table>
					</section>
				</div>
			</div>
		</div>


		<!-- Modal -->
		<div class="modal" id="addMembershipModal" tabindex="-1" role="dialog" aria-labelledby="addMembershipModal" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Cadastre uma nova assinatura</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<form action="javascript:void(0)" method="post" accept-charset="utf-8" onsubmit="Admin.newMembership(this)">
		      		<div class="message"></div>
		      		<div class="form-group">
		      			<label for="new_membership_orderid" class="form-label">Número do Pedido (order id) <small>(opcional)</small></label>
						<input type="text" class="form-control" id="new_membership_orderid" name="new_membership_orderid" placeholder="" />
		      		</div>

		      		<div class="form-group mt-3">
		      			<label for="new_membership_product" class="form-label">Produto <small class="text-danger">*</small></label>
		      			<select name="new_membership_product" class="form-control" id="new_membership_product" required>
		      				<option value="1">Seja Membro - CSA</option>
		      			</select>
		      		</div>

		      		<div class="form-group mt-3">
		      			<label for="new_membership_value" class="form-label">Valor <small class="text-danger">*</small></label>
						<input type="text" class="form-control" id="new_membership_value" name="new_membership_value" placeholder="" data-mask="#.##0,00" data-mask-reverse="true" required />
		      		</div>

		      		<div class="form-group mt-3">
		      			<label for="new_membership_payment_type" class="form-label">Tipo de Pagamento <small class="text-danger">*</small></label>
		      			<select name="new_membership_payment_type" class="form-control" id="new_membership_payment_type" required>
		      				<option value="pix">Pix</option>
		      				<option value="credit_card">Cartão de Crédito</option>
		      			</select>
		      		</div>

		      		<div class="form-group mt-3">
		      			<label for="new_membership_starts_at" class="form-label">Data de Início <small class="text-danger">*</small></label>
						<input type="datetime-local" class="form-control" id="new_membership_starts_at" name="new_membership_starts_at" placeholder="dd/mm/aaaa h:m" required />
		      		</div>

		      		<div class="form-group mt-3">
		      			<label for="new_membership_ends_at" class="form-label">Data de Fim <small class="text-danger">*</small></label>
						<input type="datetime-local" class="form-control" id="new_membership_ends_at" name="new_membership_ends_at" placeholder="dd/mm/aaaa h:m" required />
		      		</div>

		      		<input type="hidden" name="iduser" value="<?=$user->iduser?>" />	
		      		<div class="form-group mt-3">
		      			<button type="submit" class=" btn btn-rose btn-rounded btn-rose-light">Cadastrar assinatura</button>
		      		</div>
		      	</form>
		      </div>
		    </div>
		  </div>
		</div>

		<div class="modal" id="addConsultingModal" tabindex="-1" role="dialog" aria-labelledby="addConsultingModal" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Cadastre uma nova consultoria</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<form action="javascript:void(0)" method="post" accept-charset="utf-8" onsubmit="Admin.newConsulting(this)">
		      		<div class="message"></div>
		      		<div class="form-group">
		      			<label for="consulting_date" class="form-label">Data da Consultoria</label>
						<input type="date" class="form-control" id="consulting_date" name="consulting_date" required />
		      		</div>

					  <div class="form-group">
		      			<label for="consulting_observation" class="form-label">Observações da Consultoria</label>
						<textarea name="consulting_observation" id="consulting_observation" class="form-control"></textarea>
		      		</div>

		      		<input type="hidden" name="user_id" value="<?=$user->iduser?>" />	
		      		<div class="form-group mt-3">
		      			<button type="submit" class=" btn btn-rose btn-rounded btn-rose-light">Cadastrar consultoria</button>
		      		</div>
		      	</form>
		      </div>
		    </div>
		  </div>
		</div>

		<div class="modal" id="addDiamondsModal" tabindex="-1" role="dialog" aria-labelledby="addDiamondsModal" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Cadastre diamantes manualmente</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<form action="javascript:void(0)" method="post" accept-charset="utf-8" onsubmit="Admin.newDiamonds(this)">
		      		<div class="message"></div>
		      		<div class="form-group">
		      			<label for="diamonds_value" class="form-label">Quantidade de Diamantes</label>
						<input type="text" class="form-control" id="diamonds_value" name="diamonds_value" required />
		      		</div>
					
		      		<div class="form-group">
		      			<label for="diamonds_observation" class="form-label">Observações dos Diamantes</label>
						<input type="text" class="form-control" id="diamonds_observation" name="diamonds_observation" required />
		      		</div>

					

		      		<input type="hidden" name="user_id" value="<?=$user->iduser?>" />	
		      		<div class="form-group mt-3">
		      			<button type="submit" class=" btn btn-rose btn-rounded btn-rose-light">Cadastrar diamantes</button>
		      		</div>
		      	</form>
		      </div>
		    </div>
		  </div>
		</div>


		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>	
	</body>
</html>