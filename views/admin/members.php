<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Membros ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

	</head>
	<body class="admin">

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Membros</h1>

					<table class="table table-hover">
						<thead>
							<th></th>
							<th>Nome</th>
							<th>Assinatura</th>
							<th>Ações</th>
						</thead>

						<tbody>
							
							<?php
								$User = new User;
								$getUsers = $User->getUsers();

								if($getUsers->rowCount() > 0):
									foreach($getUsers->fetchAll(PDO::FETCH_ASSOC) as $user):
							?>
							<tr>
								<td style="width: auto">
									<img src="<?= ((!empty($user["profile_photo"])) ? PATH.$user["profile_photo"] : PATH."assets/images/default-pfp.png")  ?>" style="width: 50px; height: 50px; object-fit: cover;border-radius: 50px;" alt="">
								</td>
								<td class="align-middle">
									<?=$user['firstname']." ".$user['lastname']?>
								</td>
								<td class="align-middle">
									<?=date("d/m/Y", strtotime($user['starts_at']))?> até <?=date("d/m/Y", strtotime($user['ends_at']))?>
								</td>
								<td class="align-middle">
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