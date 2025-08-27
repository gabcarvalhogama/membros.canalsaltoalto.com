<?php 
	
	$User = new User;
	$getUsers = $User->getAllUsersWithLastSubscription();

?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Membros ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Membros</h1>
					<p>Nessa página você encontra a lista de todos os membros cadastrados no sistema, incluindo administradores. Atualmente existem <?=$getUsers->rowCount()?> usuários cadastrados.</p>

                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="flex flex-row align-items-center">
									<input type="date" id="start_date" name="start_date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>"> - 
									<input type="date" id="end_date" name="end_date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
									<button type="submit" class="btn btn-primary">Filtrar</button>
								</div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
                        $startDate = $_GET['start_date'];
                        $endDate = $_GET['end_date'];

                        $filteredUsers = array_filter($getUsers->fetchAll(PDO::FETCH_ASSOC), function($user) use ($startDate, $endDate) {
                            return (
								!empty($user['ends_at']) 
								&& $user['ends_at'] >= $startDate 
								&& $user['ends_at'] <= $endDate
							);
                        });
                    } else {
                        $filteredUsers = $getUsers->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>

					<table class="table table-hover">
						<thead>
							<th></th>
							<th>Nome</th>
							<th>Assinatura</th>
							<th>Ações</th>
						</thead>

						<tbody>
							
							<?php
								if(count($filteredUsers) > 0):
									foreach($filteredUsers as $user):
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
		<script type="text/javascript" src="<?=PATH?>assets/js/daterangepicker.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/moment.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js"></script>
	</body>
</html>