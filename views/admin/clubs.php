<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Clubes ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Todos os Clubes</h1>

					<table class="table">
						<thead>
							<th>Título</th>
							<th>Criado em</th>
							<th>Ações</th>
						</thead>
						<tbody>
							<?php
								$Club = new Club;
								foreach($Club->getClubs(200)->fetchAll(PDO::FETCH_ASSOC) as $club):
							?>
								<tr>
									<td><?=$club['club_title']?></td>
									<td><?=date("d/m/Y \à\s H:i", strtotime($club['created_at']))?></td>
									<td>
										<a href="/admin/clubs/edit/<?=$club['club_id']?>" style="color: #333">Editar</a>
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