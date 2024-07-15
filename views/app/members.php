<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Membros ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="app">
		<?php include "header.phtml"; ?>

		<section class="app__members mt-5 mb-5">
			<div class="container">
				<h2>Conheça <span class="color-primary">nossas membros</span></h2>
				<div class="members-list">
					<?php
						$User = new User;

						$ms = 0;
						$getUsers = $User->getUsers();
						if($getUsers->rowCount() > 0):
							foreach($getUsers->fetchAll(PDO::FETCH_ASSOC) as $user):
								if(in_array($user["email"], ["gabriel@hatoria.com"])) continue;
								$ms+=200;
					?>
					<div class="members-list__item animate__animated animate__faster animate__fadeInDown" style="animation-delay: <?=$ms?>ms ">
						<div class="members-list__item--header">
							<div class="d-flex flex-row align-items-center">
								<img src="/<?=(!empty($user['profile_photo'])) ? $user['profile_photo'] : 'assets/images/default-pfp.png'?>" class="logo" alt=""/>
								<h3 class="mb-0"><?=$user['firstname']." ".$user['lastname']?></h3>
							</div>
							<a href="/app/members/<?=$user['iduser']?>/companies">
								<?php 
									if($user["company_counter"] == 0 OR $user["company_counter"] == null) echo "nenhuma empresa";
									else if($user["company_counter"] == 1) echo "ver 1 empresa";
									else echo "ver ".$user["company_counter"]." empresas";
								?>
							</a>
						</div>

						<div class="members-list__item--description">
							<?=$user['biography']?>
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