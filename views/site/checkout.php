<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto - Seja Membro</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="checkout">

		<div class="container mt-3 checkout__header">
			<div class="row align-items-center">
				<div class="col-md-6">
					<a href="<?=PATH?>"><i class="fa-solid fa-chevron-left"></i> VOLTAR AO INÍCIO</a>
				</div>
				<div class="col-md-6 d-flex justify-content-end">
					<img src="<?=PATH?>assets/images/logo-csa-white.png" alt="Logotipo do Canal Salto Alto" class="checkout__header--logo" />
				</div>
			</div>
			<div class="row">
				<hgroup>
					<h1>FINALIZE SUA COMPRA</h1>
					<h2>Falta pouco para você ter acesso a nossa Comunidade!</h2>
				</hgroup>
			</div>
		</div>

		<div class="container checkout__content">
			<div class="d-flex flex-row">
				<div class="left">
					<!-- # Sobre Você -->
					<form-step id="enterpreneur">
						<form action="javascript:void(0)" method="post" onsubmit="Checkout.checkoutEnterpreneur(this)">
							<div class="row">
								<div class="mb-3 col-md-6">
									<label for="f_firstname" class="form-label">Seu nome</label>
									<input type="text" class="form-control" id="f_firstname" name="f_firstname" placeholder="Seu nome" required />
								</div>
								<div class="mb-3 col-md-6">
									<label for="f_lastname" class="form-label">Seu sobrenome</label>
									<input type="text" class="form-control" id="f_lastname" name="f_lastname" placeholder="Seu sobrenome" required />
								</div>
							</div>
							<div class="row">
								<div class="mb-3 col-md-6">
									<label for="f_cpf" class="form-label">Seu CPF</label>
									<input type="text" class="form-control" id="f_cpf" name="f_cpf" placeholder="Seu CPF" required data-mask="000.000.000-00" />
								</div>
								<div class="mb-3 col-md-6">
									<label for="f_birthdate" class="form-label">Sua Data de Nascimento</label>
									<input type="date" class="form-control" id="f_birthdate" name="f_birthdate" placeholder="Sua data de nascimento" required />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_zipcode" class="form-label">CEP</label>
									<input type="text" class="form-control" id="f_zipcode" name="f_zipcode" placeholder="Digite seu CEP" required data-mask="00.000-000" onkeyup="Checkout.getCep(this)" />
								</div>
								<div class="col-md-6 d-flex align-items-end">
									<a href="" class="dont-know-cep">Não sei meu CEP</a>
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_state" class="form-label">Estado</label>
									<select name="f_state" id="f_state" class="form-control address-fields" required onchange="Checkout.loadCities(this)">
										<option value="">Selecione uma opção</option>
										<?php
											foreach(User::getStates()->fetchAll(PDO::FETCH_ASSOC) as $state)
												echo '<option value="'.$state["idstate"].'" data-uf="'.$state["uf"].'"  >'.$state["state"].'</option>';
										?>
									</select>
								</div>
								<div class="col-md-6">
									<label for="f_city" class="form-label address-fields">Cidade</label>
									<select name="f_city" id="f_city" class="form-control" required disabled>
										<option value="">Selecione um estado</option>
									</select>
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_address" class="form-label address-fields">Seu Endereço</label>
									<input type="text" class="form-control" id="f_address" name="f_address" placeholder="Av., Rua, etc." required />
								</div>
								<div class="col-md-6">
									<label for="f_address_number" class="form-label address-fields">Número</label>
									<input type="text" class="form-control" id="f_address_number" name="f_address_number" placeholder="" required />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_neighborhood" class="form-label address-fields">Seu Bairro</label>
									<input type="text" class="form-control" id="f_neighborhood" name="f_neighborhood" placeholder="" required />
								</div>
								<div class="col-md-6">
									<label for="f_complement" class="form-label address-fields">Complemento</label>
									<input type="text" class="form-control" id="f_complement" name="f_complement" placeholder="" />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col">
									<label for="f_cellphone" class="form-label">Seu Celular</label>
									<input type="text" class="form-control" id="f_cellphone" name="f_cellphone" placeholder="(__) _ ____-____" required />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col">
									<label for="f_email" class="form-label">Seu E-mail</label>
									<input type="email" class="form-control" id="f_email" name="f_email" placeholder="Ex.: meuemail@gmail.com" required />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_password" class="form-label">Sua Senha</label>
									<input type="password" class="form-control" id="f_password" name="f_password" placeholder="Digite sua senha" required />
								</div>
								<div class="col-md-6">
									<label for="f_rpassword" class="form-label">Re-digite sua Senha</label>
									<input type="password" class="form-control" id="f_rpassword" name="f_rpassword" placeholder="Digite novamente sua senha" required />
								</div>
							</div>

							<div class="row">
								<div class="col">
									<button class="btn btn-rose btn-next">AVANÇAR PARA PRÓXIMA ETAPA</buton>
								</div>
							</div>
						</form>
					</form-step>

					<!-- # Sobre Sua Empresa -->
					<form-step id="company">
						<form action="javascript:void(0)" method="post" onsubmit="Checkout.checkoutCompany(this)">
							<div class="row mb-3">
								<div class="col">
									<label for="f_cnpj" class="form-label">Seu CNPJ</label>
									<input type="text" class="form-control" id="f_cnpj" name="f_cnpj" placeholder="00.000.000/0000-00" required data-mask="00.000.000/0000-00" />
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<a href="javascript:void(0)" onclick="Checkout.changeStep(null, '#enterpreneur')" class="btn btn-prev">VOLTAR</a>
								</div>
								<div class="col-md-6">
									<button class="btn btn-rose btn-next">AVANÇAR PARA PRÓXIMA ETAPA</button>
								</div>
							</div>
						</form>
					</form-step>

					<!-- # Pagamento -->
					<form-step id="payment">
						<form action="javascript:void(0)" method="post" onsubmit="Checkout.checkoutPayment(this)">
							<div class="checkout__payment">
								<p>Selecione a melhor forma de pagamento</p>
								<div class="checkout__payment--item d-flex" onclick="Checkout.changePayment(this, 'pix')">
									<span class="mr-1_5">Pague via Pix</span>
									<img src="<?=PATH?>assets/images/logo-pix-horizontal.svg" class="pix" alt="" />
								</div>
								<div class="checkout__payment--item d-flex" onclick="Checkout.changePayment(this, 'cc')">
									<span class="mr-1_5">Pague via Cartão de Crédito</span>
									<img src="<?=PATH?>assets/images/logo-cc-horizontal.svg" class="cc" alt="" />
								</div>
							</div>

							<input type="hidden" name="f_payment_method" id="f_payment_method" />

							<div class="checkout__creditcard">
								<div class="row mb-3">
									<div class="col">
										<label for="f_cc_number" class="form-label">Número do Cartão de Crédito</label>
										<input type="text" class="form-control" id="f_cc_number" name="f_cc_number" placeholder="" data-mask="0000 0000 0000 0000" />
									</div>
								</div>

								<div class="row mb-3">
									<div class="col">
										<label for="f_cc_name" class="form-label">Nome Completo</label>
										<input type="text" class="form-control" id="f_cc_name" name="f_cc_name" />
									</div>
								</div>

								<div class="row mb-3">
									<div class="col-md-6">
										<label for="f_cc_expirationdate" class="form-label">Data de Validade</label>
										<input type="text" class="form-control" id="f_cc_expirationdate" name="f_cc_expirationdate" value="DD/AA" data-mask="00/00" />
									</div>
									<div class="col-md-6">
										<label for="f_cc_cvv" class="form-label">CVV</label>
										<input type="text" class="form-control" id="f_cc_cvv" name="f_cc_cvv" maxlength="3" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col">
									<button type="submit" class="btn btn-rose finish-checkout"><i class="fa-solid fa-lock"></i> FINALIZE SUA COMPRA</button>
								</div>
							</div>
						</form>
					</form-step>

					<!-- # Checkouting -->
					<form-step id="checkouting">
						
					</form-step>
				</div>
				<div class="right" style="background-image: url('https://membros.canalsaltoalto.com/wp-content/uploads/2023/08/WhatsApp-Image-2022-11-17-at-17.56.42.jpeg');">
					
				</div>
			</div>
		</div>




		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/checkout.js"></script>
	</body>
</html>