<?php
    $Membership = new Membership;
    $getMemberships = $Membership->getMemberships();
?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Pedidos ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Relatório de Pedidos</h1>

                    <form method="get" class="form-inline mb-4">
						<div class="d-flex align-items-center gap-5">
							<div class="form-group mr-2 d-flex flex-row align-items-center">
								<label for="start_date" class="mr-2">Data de Início:</label>
								<input type="date" id="start_date" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>">
							</div>
							<div class="form-group mr-2 d-flex flex-row align-items-center">
								<label for="end_date" class="mr-2">Data de Fim:</label>
								<input type="date" id="end_date" name="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>">
							</div>
							<div class="form-group mr-2 d-flex flex-row align-items-center">
								<label for="order_type" class="mr-2">Tipo de Pedidos:</label>
								<select id="order_type" name="order_type" class="form-control">
									<option value="all" <?= (isset($_GET['order_type']) && $_GET['order_type'] === 'all') ? 'selected' : '' ?>>Todos</option>
									<option value="paid" <?= (isset($_GET['order_type']) && $_GET['order_type'] === 'paid') ? 'selected' : '' ?>>Pagos</option>
									<option value="pending" <?= (isset($_GET['order_type']) && $_GET['order_type'] === 'pending') ? 'selected' : '' ?>>Pendentes</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Filtrar</button>
						</div>
					</form>

                    <?php
                        $filteredOrders = $getMemberships->fetchAll(PDO::FETCH_ASSOC);
                        $startDate = !empty($_GET['start_date']) ? $_GET['start_date'] : null;
                        $endDate = !empty($_GET['end_date']) ? $_GET['end_date'] : null;
                        $orderType = !empty($_GET['order_type']) ? $_GET['order_type'] : 'all';

                        $totalMemberships = 0;
                        $totalPaidMemberships = 0;
                        $totalPaymentValue = 0;

                        $filteredOrders = array_filter($filteredOrders, function ($order) use ($startDate, $endDate, $orderType) {
                            $orderDate = $order['created_at'];
                            $isWithinDateRange = (!$startDate || $orderDate >= $startDate) && (!$endDate || $orderDate <= $endDate);
                            $isMatchingType = ($orderType === 'all' || $order['status'] === $orderType);

                            return $isWithinDateRange && $isMatchingType;
                        });

                        usort($filteredOrders, function ($a, $b) {
							return $a['created_at'] <=> $b['created_at'];
						});

                        foreach ($filteredOrders as $order) {
                            $totalMemberships++;
                            if ($order['status'] === 'paid') {
                                $totalPaidMemberships++;
                                $totalPaymentValue += $order['payment_value'];
                            }
                        }
                    ?>

                    <div class="row">
                        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                            <a class="card card-hover-shadow h-100" href="javascript:void(0)">
                                <div class="card-body">
                                    <h6 class="card-subtitle">Total de Pedidos</h6>

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
                                    <h6 class="card-subtitle">Pedidos Pagos</h6>

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
							<th>Order ID</th>
                            <th>Valor</th>
                            <th>Método</th>
                            <th>Usuário</th>
							<th>Criado Em</th>
                            <th>Status</th>
							<th></th>
						</thead>

						<tbody>
							
							<?php
                                foreach($filteredOrders as $order):
							?>
							<tr>
								<td><?=$order['order_id']?></td>
                                <td>R$ <?=Validation::decimalToReal($order['payment_value'])?></td>
                                <td><?=$order['payment_method']?></td>
                                <td><?=$order['firstname']." ".$order['lastname']?></td>
                                <td><?=date("d/m/Y \à\s H:i", strtotime($order['created_at']))?></td>
                                <td><?=$order['status']?></td>
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