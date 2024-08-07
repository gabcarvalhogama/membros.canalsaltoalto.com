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
		<?php include "header.phtml"; ?>

		<section class="app__companies mt-5 mb-5">
			<div class="container">
				<div class="d-flex flex-row justify-content-between">
					<h2>Conheça os negócios <span class="color-primary">das membros</span></h2>
					<div>
						<a href="/app/companies/new"><button class="btn btn-rose btn-rounded">Cadastre sua empresa</button></a>
					</div>
				</div>
				<div class="companies-list mt-3">
				<?php
			  		$Company = new Company;
			  		$companies = $Company->getCompanies();
			  		if($companies->rowCount() > 0):
			  			foreach($companies->fetchAll(PDO::FETCH_ASSOC) as $company):
			  	?>
			  		<div class="companies-list__item animate__animated animate__faster animate__fadeInDown">
			  			<div class="companies-list__item--image" style="background-image: url('/<?=$company["company_image"]?>')"></div>
			  			<div class="companies-list__item--content">
			  				<ul>
			  					
			  					<?php if(!empty($company["facebook_url"])): ?>
			  						<li><a href="<?=$company["facebook_url"]?>" target="_blank"><i class="fa-brands fa-facebook"></i></a></li>
			  					<?php endif; ?>

			  					<?php if(!empty($company["instagram_url"])): ?>
			  					<li><a href="<?=$company["instagram_url"]?>" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
			  					<?php endif; ?>

			  					<?php if(!empty($company["site_url"])): ?>
			  					<li><a href="<?=$company["site_url"]?>" target="_blank"><i class="fa-solid fa-link"></i></a></li>
			  					<?php endif; ?>
			  				</ul>
			  				<h3 class="mt-3"><?=$company["company_name"]?></h3>
			  				<div class="description"><?=$company["company_description"]?></div>
			  				<div class="d-flex flex-row align-items-center mt-2">
			  					<a href="https://wa.me/55<?=$company["cellphone"]?>" target="_blank"><button class="btn btn-rose btn-rounded"><i class="fa-brands fa-whatsapp"></i> <?=$company["cellphone"]?></button></a>
			  					<div class="d-flex flex-row p-2 align-items-center">
			  						<img src="/<?=(!empty($company['profile_photo'])) ? $company["profile_photo"] : 'assets/images/default-pfp.png'?>" style="width: 20px;height: 20px;border-radius: 20px;" alt=""/>
			  						<span class="p-2 d-block">by <?=$company["firstname"]." ".$company["lastname"]?></span>
			  					</div>
			  				</div>
			  			</div>
			  		</div>
			    		<?php endforeach; endif; ?>
			    </div>
			</div>
		</section>



		<?php include "footer.phtml"; ?>



		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>