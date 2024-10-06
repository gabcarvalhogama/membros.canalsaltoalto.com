<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Aprovar Empresas ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Empresas pendentes de aprovação</h1>

					<table class="table">
						<thead>
							<th></th>
							<th>Empresa</th>
							<th>Membro</th>
							<th>Ações</th>
						</thead>
						<tbody>
							<?php
								$Company = new Company;
								$getCompany = $Company->getCompaniesByStatus(2);

								if($getCompany->rowCount() > 0):
									foreach($getCompany->fetchAll(PDO::FETCH_ASSOC) as $company):
							?>
							<tr>
								<td class="align-middle"><img src="/<?=$company['company_image']?>" alt="" style="width: 80px;" /></td>
								<td class="align-middle">
									<?=$company['company_name']?>
								</td>
								<td class="align-middle">
									<?=$company['firstname']." ".$company['lastname']?>
								</td>
								<td class="align-middle">
									<a style="color: #333;" href="/admin/companies/edit/<?=$company['company_id']?>">Editar</a>
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