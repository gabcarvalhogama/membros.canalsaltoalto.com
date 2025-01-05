<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Banners ‹ Painel Administrativo ‹ Canal Salto Alto</title>
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="admin">

		<div class="admin__dashboard">
			<?php include "nav.phtml"; ?>

			<div class="admin__dashboard--content">
				<div class="container">
					<h1>Todos os Banners</h1>

					<table class="table">
						<thead>
							<th>Banner</th>
							<th>Posição</th>
							<th>Link</th>
							<th>Ações</th>
						</thead>
						<tbody>
							<?php
								$Banner = new Banner;
						  		$getBanners = $Banner->getBanners();

						  		foreach($getBanners->fetchAll(PDO::FETCH_ASSOC) as $banner):
							?>
								<tr>
									<td><img src="<?=PATH.$banner['path_desktop'];?>" alt="" class="img-fluid"></td>
									<td><?=$Banner->positions[$banner['position']]?></td>
									<td><a href="<?=$banner['link']?>" target="_blank" style="color: #000"><?=$banner['link']?></a></td>
									<td>
										<a href="/admin/banners/edit/<?=$banner['banner_id']?>" style="color: #000">Editar</a>
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
		<script type="text/javascript" src="<?=PATH?>assets/js/admin.js?<?=uniqid()?>"></script>
	</body>
</html>