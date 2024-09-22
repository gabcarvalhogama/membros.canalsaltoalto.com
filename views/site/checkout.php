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

		<div class="container-xl mt-5 checkout__header">
			<img src="<?=PATH?>assets/images/logo-csa-white.png" alt="Logotipo do Canal Salto Alto" class="checkout__header--logo" />
			<hgroup>
				<h1>FINALIZE SUA COMPRA</h1>
				<h2>Falta pouco para você <br />ter acesso a nossa Comunidade!</h2>
			</hgroup>


			<!-- <div class="row align-items-center">
				<div class="col-6">
					<a href="<?=PATH?>"><i class="fa-solid fa-chevron-left"></i> VOLTAR AO INÍCIO</a>
				</div>
				<div class="col-6 d-flex justify-content-end">
				</div>
			</div> -->
		</div>

		<div class="container-xl checkout__content">
			<div class="checkout__content--box">
				<div class="checkout__content--price">
					<div class="d-flex flex-row align-items-center">
						<div style="width: 80px; height: 80px;border-radius: 5px;background: #E54C8E;">
							<!-- <img src="<?=PATH?>/uploads/2024/07/banner-plataforma-membros.jpg" style="width: 125px;" /> -->
						</div>
						<div class="flex flex-column" style="margin-left: 10px;">
							<h4 class="font-weight-bold">Acesso de 1 (um) ano à Comunidade Salto Alto</h4>
							<p class="d-flex flex-row align-items-center font-weight-bold">R$ 199,00 à vista <br /><small style="margin-left: 10px;color: rgb(150,150,150);">ou 12x de R$ 19,90</small></p>
						</div>
					</div>
				</div>
				<form-step id="auth-email">
					<form action="javascript:void(0)" method="post" onsubmit="Checkout.checkoutAuth(this)">
						<div class="message"></div>
						<div class="row mb-3">
							<div class="col">
								<input type="email" class="form-control" id="f_auth_email" name="f_auth_email" placeholder="Ex.: meuemail@gmail.com" required tabindex="1" />
							</div>
						</div>
						<div class="row mb-3">
							<div class="col">
								<input type="password" style="display: none" class="form-control" id="f_auth_password" name="f_auth_password" placeholder="Digite a sua senha" tabindex="1" />
							</div>
						</div>
						<div class="row">
							<div class="col">
								<button class="btn btn-rose btn-next">AVANÇAR PARA PRÓXIMA ETAPA</buton>
							</div>
						</div>
					</form>
				</form-step>
				<!-- # Sobre Você -->
				<form-step id="enterpreneur">
					<form action="javascript:void(0)" method="post" onsubmit="Checkout.checkoutEnterpreneur(this)">
						<div class="message"></div>
						<div class="row mb-3">
							<div class="col">
								<label for="f_email" class="form-label">Seu E-mail</label>
								<input type="email" class="form-control" id="f_email" name="f_email" placeholder="Ex.: meuemail@gmail.com" required tabindex="1" disabled />
								<a href="javascript:void(0)" onclick="Checkout.changeStep('#enterpreneur', '#auth-email')" style="color: #000">Quero alterar meu e-mail</a>
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label for="f_password" class="form-label">Sua Senha</label>
								<input type="password" class="form-control" id="f_password" name="f_password" placeholder="Digite sua senha" required tabindex="2" />
							</div>
							<div class="col-md-6">
								<label for="f_rpassword" class="form-label">Re-digite sua Senha</label>
								<input type="password" class="form-control" id="f_rpassword" name="f_rpassword" placeholder="Digite novamente sua senha" tabindex="3" required />
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="mb-3 col-md-6">
								<label for="f_firstname" class="form-label">Seu nome</label>
								<input type="text" class="form-control" id="f_firstname" name="f_firstname" placeholder="Seu nome" required tabindex="4" />
							</div>
							<div class="mb-3 col-md-6">
								<label for="f_lastname" class="form-label">Seu sobrenome</label>
								<input type="text" class="form-control" id="f_lastname" name="f_lastname" placeholder="Seu sobrenome" tabindex="5" required />
							</div>
						</div>
						<div class="row">
							<div class="mb-3 col-md-6">
								<label for="f_cpf" class="form-label">Seu CPF</label>
								<input type="text" class="form-control" id="f_cpf" name="f_cpf" placeholder="Seu CPF" required data-mask="000.000.000-00" tabindex="6" />
							</div>
							<div class="mb-3 col-md-6">
								<label for="f_birthdate" class="form-label">Sua Data de Nascimento</label>
								<input type="date" class="form-control" id="f_birthdate" name="f_birthdate" placeholder="Sua data de nascimento" tabindex="7" required />
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-12">
								<label for="f_zipcode" class="form-label">CEP</label>
								<input type="text" class="form-control" id="f_zipcode" name="f_zipcode" placeholder="Digite seu CEP" required data-mask="00.000-000" onkeyup="Checkout.getCep(this)" tabindex="8" />
							</div>
							<!-- <div class="col-md-6 d-flex align-items-end">
								<a href="" class="dont-know-cep">Não sei meu CEP</a>
							</div> -->
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label for="f_state" class="form-label">Estado</label>
								<select name="f_state" tabindex="9" id="f_state" class="form-control address-fields" required onchange="Checkout.loadCities(this)">
									<option value="">Selecione uma opção</option>
									<?php
										foreach(User::getStates()->fetchAll(PDO::FETCH_ASSOC) as $state)
											echo '<option value="'.$state["idstate"].'" data-uf="'.$state["uf"].'"  >'.$state["state"].'</option>';
									?>
								</select>
							</div>
							<div class="col-md-6">
								<label for="f_city" class="form-label address-fields">Cidade</label>
								<select name="f_city" tabindex="10" id="f_city" class="form-control" required disabled>
									<option value="">Selecione um estado</option>
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label for="f_address" class="form-label address-fields">Seu Endereço</label>
								<input type="text" class="form-control" id="f_address" name="f_address" placeholder="Av., Rua, etc." required tabindex="11" />
							</div>
							<div class="col-md-6">
								<label for="f_address_number" class="form-label address-fields">Número</label>
								<input type="text" class="form-control" id="f_address_number" name="f_address_number" placeholder="" required tabindex="12" />
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-md-6">
								<label for="f_neighborhood" class="form-label address-fields">Seu Bairro</label>
								<input type="text" class="form-control" id="f_neighborhood" name="f_neighborhood" placeholder="" required tabindex="13" />
							</div>
							<div class="col-md-6">
								<label for="f_complement" class="form-label address-fields">Complemento</label>
								<input type="text" class="form-control" id="f_complement" name="f_complement" placeholder="" tabindex="14" />
							</div>
						</div>

						<div class="row mb-3">
							<div class="col">
								<label for="f_cellphone" class="form-label">Seu Celular</label>
								<input type="text" class="form-control" id="f_cellphone" name="f_cellphone" placeholder="(__) _ ____-____" required tabindex="15" />
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
				<!-- <form-step id="company">
					<form action="javascript:void(0)" method="post" onsubmit="Checkout.checkoutCompany(this)">
						<div class="message"></div>
						<div class="row mb-3">
							<div class="col">
								<label for="f_cnpj" class="form-label">Seu CNPJ</label>
								<input type="text" class="form-control" id="f_cnpj" name="f_cnpj" placeholder="00.000.000/0000-00" data-mask="00.000.000/0000-00" />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="company_name" class="form-label">Nome da empresa</label>
								<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Escreva aqui o título do conteúdo." required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="company_description" class="form-label">Descrição da Empresa</label>
								<textarea name="company_description" id="company_description" class="form-control"></textarea>
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
								<select name="address_state" id="address_state" class="form-control address-fields" onchange="Checkout.loadCities(this)">
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
								<label for="cellphone" class="form-label">Celular</label>
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



						<div class="row">
							<div class="col-md-6">
								<a href="javascript:void(0)" onclick="Checkout.changeStep(null, '#enterpreneur')" class="btn btn-prev">VOLTAR</a>
							</div>
							<div class="col-md-6">
								<button class="btn btn-rose btn-next">AVANÇAR PARA PRÓXIMA ETAPA</button>
							</div>
						</div>
					</form>
				</form-step> -->

				<!-- # Pagamento -->
				<form-step id="payment">
					<form action="javascript:void(0)" method="post" onsubmit="Checkout.checkoutPayment(this)" data-pagarmecheckout-form>
						<div class="message"></div>
						<div class="checkout__payment">
							<p>Selecione a melhor forma de pagamento</p>
							<div class="checkout__payment--item d-flex" onclick="Checkout.changePayment(this, 'pix')">
								<span class="mr-1_5">Pague via Pix</span>
								<img src="<?=PATH?>assets/images/logo-pix-horizontal.svg" class="pix" alt="" />
							</div>
							<div class="checkout__payment--item d-flex" onclick="Checkout.changePayment(this, 'credit_card')">
								<span class="mr-1_5">Pague via Cartão de Crédito</span>
								<img src="<?=PATH?>assets/images/logo-cc-horizontal.svg" class="cc" alt="" />
							</div>
						</div>

						<input type="hidden" name="f_payment_method" id="f_payment_method" />

						<div class="checkout__creditcard">
							<div class="row mb-3">
								<div class="col">
									<label for="f_cc_holdername" class="form-label">Nome no Cartão</label>
									<input type="text" class="form-control" id="f_cc_holdername" data-pagarmecheckout-element="holder_name" name="f_cc_holdername" placeholder="" />
								</div>
							</div>
							<div class="row mb-3">
								<div class="col">
									<label for="f_cc_number" class="form-label">Número do Cartão de Crédito</label>
									<input type="text" class="form-control" id="f_cc_number" data-pagarmecheckout-element="number" name="f_cc_number" placeholder="" data-mask="0000 0000 0000 0000" />
								    <span  data-pagarmecheckout-element="brand"></span>
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="f_cc_expirationdate" class="form-label">Data de Validade</label>
									<input type="text" class="form-control" id="f_cc_expirationdate" name="f_cc_expirationdate" value="DD/AA" data-mask="00/00" onkeyup="Checkout.updateExpirationDates(this.value)" />
									<input type="hidden" id="f_cc_expirationdate_month" data-pagarmecheckout-element="exp_month" />
									<input type="hidden" id="f_cc_expirationdate_year" data-pagarmecheckout-element="exp_year" />
								</div>
								<div class="col-md-6">
									<label for="f_cc_cvv" class="form-label">CVV</label>
									<input type="text" class="form-control" id="f_cc_cvv" name="f_cc_cvv" maxlength="3" data-pagarmecheckout-element="cvv" />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col">
									<label for="f_cc_installments" class="form-label">Selecione o Parcelamento</label>
									<select name="f_cc_installments" class="form-control" id="f_cc_installments">
										<option value="1">À vista (R$ 238,80) s/juros</option>
			                            <option value="2">2x de R$ 119,40 (R$ 238,80) s/juros</option>
			                            <option value="3">3x de R$ 79,61 (R$ 238,80) s/juros</option>
			                            <option value="4">4x de R$ 59,70 (R$ 238,80) s/juros</option>
			                            <option value="5">5x de R$ 47,77 (R$ 238,80) s/juros</option>
			                            <option value="6">6x de R$ 39,81 (R$ 238,80) s/juros</option>
			                            <option value="7">7x de R$ 34,12 (R$ 238,80) s/juros</option>
			                            <option value="8">8x de R$ 29,85 (R$ 238,80) s/juros</option>
			                            <option value="9">9x de R$ 26,54 (R$ 238,80) s/juros</option>
			                            <option value="10">10x de R$ 23,89 (R$ 238,80) s/juros</option>
			                            <option value="11">11x de R$ 21,71 (R$ 238,80) s/juros</option>
			                            <option value="12">12x de R$ 19,91 (R$ 238,80) s/juros</option>
									</select>
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

				<form-step id="checkout__loading">
					<div class="text-center">
						<img src="<?=PATH?>assets/images/loading-pink.svg" alt="" />
						<p>Estamos carregando as informações, aguarde...</p>
					</div>
				</form-step>

				<!-- # Checkouting -->
				<form-step id="checkouting-pix_pending">
					<!-- <h2></h2> -->
					<p>O pagamento será identificado automaticamente e você será redirecionada para a tela de confirmação.</p>

					<div class="pix text-center" >
						<p><small>Escaneie este QR Code</small></p>
						<div>
							<img src="https://api.pagar.me/core/v5/transactions/tran_qwOMP3BI4IlYkQgW/qrcode?payment_method=pix" alt="" id="pixImage" />
						</div>

						<p><small>Ou clique no botão para copiar o Pix Copia e Cola</small></p>
						<input type="text"  value="" id="pixField" />
						<button onclick="Checkout.copyPix()" class="btn-rose btn-rounded" style="border: none">Copiar Pix Copia e Cola</button>
					</div>
				</form-step>


				<form-step id="checkouting-pix_paid">
					<div class="d-flex flex-column align-items-center justify-content-center">
					<div class=""><img src="<?=PATH?>assets/images/success.gif" alt="" /></div>
					<h2>Pagamento confirmado!</h2>
					<p>Aguarde, você será redirecionada em breve...</p>
						
					</div>
				</form-step>
			</div>
		</div>




		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<!-- <script src="https://checkout.pagar.me/v1/tokenizecard.js" data-pagarmecheckout-app-id="pk_test_ZgALAN5IKBH50K1N"></script> -->
		<script type="text/javascript" src="<?=PATH?>assets/js/checkout.js"></script>
		<!-- <script type="text/javascript">
			function success(data) {
        	};
    
        	function fail(error) {
        		alert("Error")
            	console.error(error);
        	};
    
        	PagarmeCheckout.init(success,fail)
		</script> -->
	</body>
</html>