<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Ranking de Membros ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />
		
		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__members mt-5 mb-5">
			<div class="container-xl">
				<h2>Ranking de <span class="color-primary">membros.</span></h2>
                <div class="members-list mt-3">
					<?php
						$User = new User;
						$getUsers = $User->getActiveUsersOrderByDiamonds();
						if($getUsers->rowCount() > 0):
							foreach($getUsers->fetchAll(PDO::FETCH_ASSOC) as $member):
								if($member["firstname"] == null) continue;
								if(in_array($member["email"], ["gabriel@hatoria.com"])) continue;
								echo Template::render($member, "loop_members_ranking");
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