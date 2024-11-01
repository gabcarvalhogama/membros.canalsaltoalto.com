<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Aprovar Publis ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Publis</h1>

					<table class="table">
						<thead>
							<th>Título</th>
							<th>Criado em</th>
							<th>Ações</th>
						</thead>
						<tbody>
							<?php
								$Publi = new Publi;
								foreach($Publi->getPublisByStatus(500, 0)->fetchAll(PDO::FETCH_ASSOC) as $publi):
							?>
								<tr>
									<td><?=$publi['publi_title']?></td>
									<td><?=date("d/m/Y \à\s H:i", strtotime($publi['created_at']))?></td>
									<td>
										<a href="/admin/publis/edit/<?=$publi['publi_id']?>" style="color: #333">Acessar</a>
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