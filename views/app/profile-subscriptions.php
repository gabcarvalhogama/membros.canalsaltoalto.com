<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Inscrições ‹ Área de Membros ‹ Canal Salto Alto</title>

		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__profile">
			<div class="container-xl">

				<div class="profile__header">
					<div class="profile__header--photo">
						<label for="f_profile_photo"><img src="<?=PATH?>

							<?php 
								if(empty(USER->profile_photo))
									echo 'assets/images/profile-icon.png';
								else
									echo USER->profile_photo;
							?>

						" id="profile__header--photo-image" alt="" /></label>
						<form action="javascript:void(0)" id="updateProfilePhoto">
							<input type="file" id="f_profile_photo" accept="image/*" class="d-none" onchange="App.updateProfilePhoto(this)">
						</form>
					</div>
					<div class="profile__header--presentation">
						<h2><?=USER->firstname . " ". USER->lastname?></h2>
						<div class="bio">
							<?=USER->biography?>
						</div>
					</div>
				</div>

				<div class="profile__section">
					<?php include "profile.menu.php"; ?>
					<div class="profile__section--content">
						<h3>Minhas inscrições</h3>

						<table class="table table-dark">
							<thead>
								<tr>
									<td>Inscrição</td>
									<td>Valor</td>
									<td>Início</td>
									<td>Fim</td>
								</tr>
							</thead>
							<tbody>
								<?php 
									$Membership = new Membership;
									$getMembership = $Membership->getMembershipsByUserAndStatus(USER->iduser, 'paid');

									foreach($getMembership->fetchAll(PDO::FETCH_ASSOC) as $membership):
								?>
								<tr>
									<td><?=$membership['membership_title'];?></td>
									<td><?=$membership['payment_value'];?></td>
									<td><?=date('d/m/Y H:i', strtotime($membership['starts_at']));?></td>
									<td><?=date('d/m/Y H:i', strtotime($membership['ends_at']));?></td>
								</tr>

								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
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