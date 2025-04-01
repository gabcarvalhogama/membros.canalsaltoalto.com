<?php
	
	$User = new User;
	$getUsers = $User->getUsers();

?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Aniversários ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Aniversário das Membros</h1>
					<p>Aniversário das membros.</p>

					<form method="get" class="form-inline mb-4">
						<div class="d-flex align-items-center gap-2">
							<div class="form-group mr-2 d-flex flex-row align-items-center">
								<label for="start_date" class="mr-2">Data de Início:</label>
								<input type="date" id="start_date" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>">
							</div>
							<div class="form-group mr-2 d-flex flex-row align-items-center">
								<label for="end_date" class="mr-2">Data de Fim:</label>
								<input type="date" id="end_date" name="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>">
							</div>
							<div class="form-group mr-2 d-flex flex-row align-items-center">
								<label for="member_type" class="mr-2">Tipo de Membro:</label>
								<select id="member_type" name="member_type" class="form-control">
									<option value="all" <?= (isset($_GET['member_type']) && $_GET['member_type'] === 'all') ? 'selected' : '' ?>>Todos</option>
									<option value="active" <?= (isset($_GET['member_type']) && $_GET['member_type'] === 'active') ? 'selected' : '' ?>>Membros Ativos</option>
									<option value="inactive" <?= (isset($_GET['member_type']) && $_GET['member_type'] === 'inactive') ? 'selected' : '' ?>>Membros Inativos</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Filtrar</button>
						</div>
					</form>

					<?php
					$filteredUsers = $getUsers->fetchAll(PDO::FETCH_ASSOC);

					if (isset($_GET['member_type']) || isset($_GET['start_date']) || isset($_GET['end_date'])) {
						$startDate = $_GET['start_date'] ?? null;
						$endDate = $_GET['end_date'] ?? null;
						$memberType = $_GET['member_type'] ?? 'all';

						$filteredUsers = array_filter($filteredUsers, function ($user) use ($startDate, $endDate, $memberType) {
							$currentYear = date('Y');
							$birthdateThisYear = date('Y-m-d', strtotime($currentYear . '-' . date('m-d', strtotime($user['birthdate']))));

							// If the birthday has already passed this year, calculate for the next year
							if ($birthdateThisYear < date('Y-m-d')) {
								$birthdateThisYear = date('Y-m-d', strtotime(($currentYear + 1) . '-' . date('m-d', strtotime($user['birthdate']))));
							}

							$isWithinDateRange = true;
							if ($startDate && $endDate) {
								$isWithinDateRange = $birthdateThisYear >= $startDate && $birthdateThisYear <= $endDate;
							}

							if ($memberType === 'active' && $user['is_member'] != 1) {
								return false;
							}

							if ($memberType === 'inactive' && $user['is_member'] == 1) {
								return false;
							}

							return $isWithinDateRange;
						});

						usort($filteredUsers, function ($a, $b) {
							$currentYear = date('Y');
							$aBirthday = strtotime($currentYear . '-' . date('m-d', strtotime($a['birthdate'])));
							$bBirthday = strtotime($currentYear . '-' . date('m-d', strtotime($b['birthdate'])));
							return $aBirthday <=> $bBirthday;
						});
					}
					?>
					<table class="table table-hover">
						<thead>
							<th></th>
							<th>Nome</th>
							<th>Nascimento</th>
                            <th>Aniversário</th>
							<th>Ações</th>
						</thead>

						<tbody>
							
							<?php
                                foreach($filteredUsers as $user):
							?>
							<tr>
								<td style="width: auto">
									<img src="<?= ((!empty($user["profile_photo"])) ? PATH.$user["profile_photo"] : PATH."assets/images/default-pfp.png")  ?>" loading="lazy" style="width: 50px; height: 50px; object-fit: cover;border-radius: 50px;" alt="">
								</td>
								<td class="align-middle">
									<a href="/admin/members/view/<?=$user['iduser'];?>" style="color: #000"><?=$user['firstname']." ".$user['lastname']?></a>
									
										<?php 
											if($user['is_member'] == 1)
												echo '<small style="border-radius: 50px;border: solid 1px #E54C8E;padding: 5px 10px;color: #E54C8E;">Membro</small>';
										?>
								</td>
                                <td class="align-middle">
                                    <?=date('d/m/Y', strtotime($user['birthdate']))?>
                                </td>
                                <td class="align-middle">
                                    <?php
                                        $currentYear = date('Y');
                                        $birthdayThisYear = strtotime($currentYear . '-' . date('m-d', strtotime($user['birthdate'])));
                                        echo date('d/m/Y', $birthdayThisYear);
                                    ?>
                                </td>
								<td class="align-middle">
									<a href="/admin/members/view/<?=$user['iduser']?>" style="color: #000">Ver<a>
										| 
									<a href="/admin/members/edit/<?=$user['iduser']?>" style="color: #000">Editar<a>
								</td>
							</tr>
							<?php endforeach; ?>
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