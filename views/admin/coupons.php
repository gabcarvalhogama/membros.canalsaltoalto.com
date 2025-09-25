<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Cupons ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Todos os Cupons</h1>

					<table class="table">
						<thead>
							<th>Título</th>
							<th>Desconto</th>
							<th>Expiração</th>
							<!-- <th>Ações</th> -->
						</thead>
						<tbody>
							<?php
								$Coupon = new Coupon;
								foreach($Coupon->getCoupons()->fetchAll(PDO::FETCH_ASSOC) as $coupon):
							?>
								<tr>
									<td><?=$coupon['code']?></td>
									<td><?php
										if($coupon['discount_type'] == 'value')
											echo "R$ ".$coupon['discount_value'];
										else
											echo $coupon['discount_value']."%";

									?></td>
									<td><?=date("d/m/Y \à\s H:i", strtotime($coupon['expiration_date']))?></td>
									<td>
										<a href="/admin/coupons/edit/<?=$coupon['coupon_id']?>" style="color: #333">Editar</a>
									</td>
								</tr>
							<?php 
								endforeach;
							?>
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