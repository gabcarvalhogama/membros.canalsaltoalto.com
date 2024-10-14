<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Nova Membro ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Nova Membro</h1>
					<p class="subtitle">Cadastre uma nova membro.</p>
					<form action="javascript:void(0)" method="post" onsubmit="Admin.newMember(this)"  accept-charset="utf-8" enctype="multipart/form-data">
						<div class="message"></div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="member_name" class="form-label">Nome</label>
								<input type="text" class="form-control" id="member_name" name="member_name" placeholder="" required />
							</div>
							<div class="col-md-6 mb-3">
								<label for="member_lastname" class="form-label">Sobrenome</label>
								<input type="text" class="form-control" id="member_lastname" name="member_lastname" placeholder="" required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="member_photo" class="form-label">Foto</label>
								<input type="file" accept="image/*" id="member_photo" name="member_photo" class="form-control">
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="member_biography" class="form-label">Biografia</label>
								<textarea class="form-control" id="member_biography" name="member_biography"></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="member_cpf" class="form-label">CPF</label>
								<input type="text" class="form-control" id="member_cpf" name="member_cpf" placeholder="" data-mask="000.000.000-00" />
							</div>
							<div class="col-md-6 mb-3">
								<label for="member_birthdate" class="form-label">Data de Nascimento</label>
								<input type="date" class="form-control" name="member_birthdate" id="member_birthdate" name="member_birthdate" required />
							</div>
						</div>

						<div class="row">
							<div class="col mb-3">
								<label for="member_biography" class="form-label">CEP</label>
								<input type="text" class="form-control" id="member_zipcode" name="member_zipcode" />
							</div>
						</div>

						<div class="row mb-3">
								<div class="col-md-6">
									<label for="member_state" class="form-label">Estado</label>
									<select name="member_state" id="member_state" class="form-control address-fields" required onchange="Admin.loadCities(this)">
										<option value="">Selecione uma opção</option>
										<?php
											foreach(User::getStates()->fetchAll(PDO::FETCH_ASSOC) as $state)
												echo '<option value="'.$state["idstate"].'" data-uf="'.$state["uf"].'"  >'.$state["state"].'</option>';
										?>
									</select>
								</div>
								<div class="col-md-6">
									<label for="member_city" class="form-label address-fields">Cidade</label>
									<select name="member_city" id="member_city"  data-address="city" class="form-control" required disabled>
										<option value="">Selecione um estado</option>
									</select>
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="member_address" class="form-label address-fields">Seu Endereço</label>
									<input type="text" class="form-control" id="member_address" name="member_address" placeholder="Av., Rua, etc." required />
								</div>
								<div class="col-md-6">
									<label for="member_address_number" class="form-label address-fields">Número</label>
									<input type="text" class="form-control" id="member_address_number" name="member_address_number" placeholder="" required />
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="member_neighborhood" class="form-label address-fields">Seu Bairro</label>
									<input type="text" class="form-control" id="member_neighborhood" name="member_neighborhood" placeholder="" required />
								</div>
								<div class="col-md-6">
									<label for="member_complement" class="form-label address-fields">Complemento</label>
									<input type="text" class="form-control" id="member_complement" name="member_complement" placeholder="" />
								</div>
							</div>

							
							<div class="row mb-3">
								<div class="col">
									<label for="member_cellphone" class="form-label">Celular</label>
									<input type="text" class="form-control" id="member_cellphone" name="member_cellphone" placeholder="(__) _ ____-____" required />
								</div>
							</div>

							
							<div class="row mb-3">
								<div class="col-md-6">
									<label for="member_email" class="form-label">E-mail</label>
									<input type="email" class="form-control" id="member_email" name="member_email" required />
								</div>
								<div class="col-md-6">
									<label for="member_password" class="form-label">Senha</label>
									<input type="password" class="form-control" id="member_password" name="member_password" value="12345678" />
								</div>
							</div>
						<div>
							<input type="submit" value="Cadastrar membro" class="btn btn-rose btn-medium" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
		<script type="text/javascript">
			
			tinymce.init({
				selector: 'textarea#content_content',
				license_key: 'gpl',
			   	promotion: false,
			   	plugins: 'image, link, lists',
			   	toolbar: 'undo redo | styles | bold italic | numlist bullist | link image | link',
			   	menubar: false,
		       	language: 'pt_BR',
	         	images_upload_url: '<?=PATH?>upload/image',
         	  	images_upload_base_path: '/',
         	  	relative_urls: false,
				remove_script_host: false,
         	  	image_dimensions: false,
         	  	image_class_list: [
		            {title: 'Responsive', value: 'img-responsive'}
		        ]
			});

		</script>	
	</body>
</html>