<?php
    $Membership = new Membership;
    $getMemberships = $Membership->getMemberships();
?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Membros Vencidos ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Relatório de Membros por Vencimento</h1>

                    <form method="get" class="form-inline mb-4">
						<div class="d-flex align-items-center gap-5">
							<div class="form-group mr-2 d-flex flex-row align-items-center">
								<label for="month" class="mr-2">Mês:</label>
								<select id="month" name="month" class="form-control">
									<option value="">Todos</option>
									<option value="1" <?= (isset($_GET['month']) && $_GET['month'] == '1') ? 'selected' : '' ?>>Janeiro</option>
									<option value="2" <?= (isset($_GET['month']) && $_GET['month'] == '2') ? 'selected' : '' ?>>Fevereiro</option>
									<option value="3" <?= (isset($_GET['month']) && $_GET['month'] == '3') ? 'selected' : '' ?>>Março</option>
									<option value="4" <?= (isset($_GET['month']) && $_GET['month'] == '4') ? 'selected' : '' ?>>Abril</option>
									<option value="5" <?= (isset($_GET['month']) && $_GET['month'] == '5') ? 'selected' : '' ?>>Maio</option>
									<option value="6" <?= (isset($_GET['month']) && $_GET['month'] == '6') ? 'selected' : '' ?>>Junho</option>
									<option value="7" <?= (isset($_GET['month']) && $_GET['month'] == '7') ? 'selected' : '' ?>>Julho</option>
									<option value="8" <?= (isset($_GET['month']) && $_GET['month'] == '8') ? 'selected' : '' ?>>Agosto</option>
									<option value="9" <?= (isset($_GET['month']) && $_GET['month'] == '9') ? 'selected' : '' ?>>Setembro</option>
									<option value="10" <?= (isset($_GET['month']) && $_GET['month'] == '10') ? 'selected' : '' ?>>Outubro</option>
									<option value="11" <?= (isset($_GET['month']) && $_GET['month'] == '11') ? 'selected' : '' ?>>Novembro</option>
									<option value="12" <?= (isset($_GET['month']) && $_GET['month'] == '12') ? 'selected' : '' ?>>Dezembro</option>
								</select>
							</div>
							<div class="form-group mr-2 d-flex flex-row align-items-center">
								<label for="year" class="mr-2">Ano:</label>
								<select id="year" name="year" class="form-control">
									<option value="">Todos</option>
									<?php
										$currentYear = (int) date('Y');
										for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
											$selected = (isset($_GET['year']) && (int) $_GET['year'] === $year) ? 'selected' : '';
											echo "<option value=\"{$year}\" {$selected}>{$year}</option>";
										}
									?>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Filtrar</button>
						</div>
					</form>

                    <?php
                        $memberships = $getMemberships->fetchAll(PDO::FETCH_ASSOC);
                        $selectedMonth = !empty($_GET['month']) ? (int) $_GET['month'] : null;
                        $selectedYear = !empty($_GET['year']) ? (int) $_GET['year'] : null;

                        $totalMemberships = 0;
                        $totalPaidMemberships = 0;
                        $totalPaymentValue = 0;

                        $filteredMemberships = array_filter($memberships, function ($membership) use ($selectedMonth, $selectedYear) {
                            if (empty($membership['ends_at']) || $membership['status'] !== 'paid') {
                                return false;
                            }

                            $endsAtTimestamp = strtotime($membership['ends_at']);

                            if ($endsAtTimestamp === false) {
                                return false;
                            }

                            if ($endsAtTimestamp >= time()) {
                                return false;
                            }

                            $membershipMonth = (int) date('n', $endsAtTimestamp);
                            $membershipYear = (int) date('Y', $endsAtTimestamp);

                            $matchesMonth = !$selectedMonth || $membershipMonth === $selectedMonth;
                            $matchesYear = !$selectedYear || $membershipYear === $selectedYear;

                            return $matchesMonth && $matchesYear;
                        });

                        usort($filteredMemberships, function ($a, $b) {
							return strtotime($a['ends_at']) <=> strtotime($b['ends_at']);
						});

                        foreach ($filteredMemberships as $membership) {
                            $totalMemberships++;
                            if ($membership['status'] === 'paid') {
                                $totalPaidMemberships++;
                                $totalPaymentValue += $membership['payment_value'];
                            }
                        }
                    ?>

                    <div class="row">
                        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                            <a class="card card-hover-shadow h-100" href="javascript:void(0)">
                                <div class="card-body">
                                    <h6 class="card-subtitle">Total de Assinaturas Vencidas</h6>

                                    <div class="row align-items-center gx-2 mb-1">
                                        <div class="col-6">
                                        <h2 class="card-title text-inherit"><?=$totalMemberships?></h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                            <a class="card card-hover-shadow h-100" href="javascript:void(0)">
                                <div class="card-body">
                                    <h6 class="card-subtitle">Assinaturas Pagas Vencidas</h6>

                                    <div class="row align-items-center gx-2 mb-1">
                                        <div class="col-6">
                                        <h2 class="card-title text-inherit"><?=$totalPaidMemberships?></h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                            <a class="card card-hover-shadow h-100" href="javascript:void(0)">
                                <div class="card-body">
                                    <h6 class="card-subtitle">Faturamento Gerado</h6>

                                    <div class="row align-items-center gx-2 mb-1">
                                        <div class="col">
                                        <h2 class="card-title text-inherit">R$ <?=Validation::decimalToReal($totalPaymentValue)?></h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
				    </div>
                    
                    <table class="table table-hover">
						<thead>
                            <th>Usuário</th>
							<th>Plano</th>
                            <th>Valor</th>
                            <th>Método</th>
							<th>Início</th>
                            <th>Vencimento</th>
                            <th>Status</th>
						</thead>

						<tbody>
							<?php
                                foreach($filteredMemberships as $membership):
							?>
							<tr>
                                <td><?=$membership['firstname']." ".$membership['lastname']?></td>
								<td><?=$membership['membership_title']?></td>
                                <td>R$ <?=Validation::decimalToReal($membership['payment_value'])?></td>
                                <td><?=ucfirst($membership['payment_method'])?></td>
                                <td><?=date("d/m/Y \à\s H:i", strtotime($membership['starts_at']))?></td>
                                <td><?=date("d/m/Y \à\s H:i", strtotime($membership['ends_at']))?></td>
                                <td><?=$membership['status']?></td>
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
