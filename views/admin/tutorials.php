<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Tutoriais ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<div class="d-flex flex-row align-items-center gap-2">
						<h1>Todos os Tutoriais</h1>
						<a href="/admin/tutorials/new" class="btn btn-primary ml-2">Adicionar Novo</a>
					</div>
					
					<table class="table">
						<thead>
							<th>Título</th>
							<th>Data de Publicação</th>
							<th>Ordem</th>
							<th>Status</th>
							<th>Ações</th>
						</thead>
						<tbody>
							<?php
								$Tutorial = new Tutorial;
								foreach($Tutorial->getAll()->fetchAll(PDO::FETCH_ASSOC) as $tutorial):
							?>
								<tr>
									<td><a target="_blank" href="/app/tutorial/<?=$tutorial['tutorial_id']?>"><?=$tutorial['tutorial_title']?></a></td>
									<td><?=(($tutorial['published_at'] != null) ? date("d/m/Y H:i", strtotime($tutorial['published_at'])) : "Não publicado")?></td>
									<td><?=$tutorial['tutorial_order']?></td>
									<td<?=($tutorial['status'] != 1 ? ' style="color: #888;"' : '')?>><?=(($tutorial['status'] == 1) ? "Publicado" : "Rascunho")?></td>
									<td>
										<a href="/admin/tutorials/edit/<?=$tutorial['tutorial_id']?>" style="color: #333">Editar</a>
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