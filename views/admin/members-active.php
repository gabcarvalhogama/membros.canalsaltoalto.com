<?php
	
	$User = new User;
	$getUsersActive = $User->getActiveUsers();

?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Membros Ativos ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Membros Ativos</h1>
					<p>Atualmente existem <?=$getUsersActive->rowCount()?> membros ativos.</p>
					<table class="table table-hover">
						<thead>
							<th></th>
							<th>Nome</th>
							<th>Assinatura</th>
							<th>Ações</th>
						</thead>

						<tbody>
							
							<?php

								if($getUsersActive->rowCount() > 0):
									foreach($getUsersActive->fetchAll(PDO::FETCH_ASSOC) as $user):
							?>
							<tr>
								<td style="width: auto">
									<img src="<?= ((!empty($user["profile_photo"])) ? PATH.$user["profile_photo"] : PATH."assets/images/default-pfp.png")  ?>" style="width: 50px; height: 50px; object-fit: cover;border-radius: 50px;" alt="">
								</td>
								<td class="align-middle">
									<a href="/admin/members/view/<?=$user['iduser'];?>" style="color: #000"><?=$user['firstname']." ".$user['lastname']?></a>
								</td>
								<td class="align-middle">
									<?php
										if(empty($user['starts_at']) OR empty($user['ends_at']))
											echo "-";
										else
											echo date("d/m/Y", strtotime($user['starts_at'])). " até " . date("d/m/Y", strtotime($user['ends_at']));

									?>
								</td>
								<td class="align-middle">
									<a href="/admin/members/view/<?=$user['iduser']?>" style="color: #000">Ver<a>
										| 
									<a href="/admin/members/edit/<?=$user['iduser']?>" style="color: #000">Editar<a>
								</td>
							</tr>
							<?php endforeach; endif; ?>
						</tbody>
					</table>
					
					


				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
	</body>
</html>