<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Events ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Todos os Eventos</h1>

					<table class="table">
						<thead>
							<th>Título</th>
							<th>Data do Evento</th>
							<th>Ações</th>
						</thead>
						<tbody>
							<?php
								$Event = new Event;
								foreach($Event->getEvents(200)->fetchAll(PDO::FETCH_ASSOC) as $event):
							?>
								<tr>
									<td><?=$event['event_title']?></td>
									<td><?=date("d/m/Y \à\s H:i", strtotime($event['event_datetime']))?></td>
									<td>
										<a href="/admin/events/edit/<?=$event['idevent']?>" style="color: #333">Editar</a>
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