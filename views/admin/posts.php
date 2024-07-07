<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Posts ‹ Painel Administrativo ‹ Canal Salto Alto</title>
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
					<h1>Todos os Posts</h1>

					<table class="table">
						<thead>
							<th>Título</th>
							<th>Data de Publicação</th>
							<th>Ações</th>
						</thead>
						<tbody>
							<?php
								$Post = new Post;
								foreach($Post->getPosts(200)->fetchAll(PDO::FETCH_ASSOC) as $post):
							?>
								<tr>
									<td><?=$post['title']?></td>
									<td><?=date("d/m/Y \à\s H:i", strtotime($post['published_at']))?></td>
									<td>
										<a href="/admin/posts/edit/<?=$post['post_id']?>" style="color: #333">Editar</a>
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