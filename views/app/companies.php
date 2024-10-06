<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Empresas ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__companies mt-5 mb-5">
			<div class="container-xl">
				<div class="d-flex flex-column flex-md-row justify-content-between">
					<h2>Conheça os negócios <span class="color-primary">das membros</span></h2>
					<div>
						<a href="/app/companies/new"><button class="btn btn-rose btn-rounded">Cadastre sua empresa</button></a>
					</div>
				</div>
				<div class="companies-list mt-3">
				<?php
			  		$Company = new Company;
			  		$companies = $Company->getCompaniesByStatus(1);
			  		if($companies->rowCount() > 0):
			  			foreach($companies->fetchAll(PDO::FETCH_ASSOC) as $company):
			  				echo Template::render($company, "loop_companies");
			  			endforeach; endif; ?>
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