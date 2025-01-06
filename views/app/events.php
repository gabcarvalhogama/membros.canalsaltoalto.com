<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Eventos ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__contents">
			<div class="container-xl">
				<?php 
					$actual_page = (isset($page_number)) ? (int) $page_number : 1;
					$start = (($actual_page - 1) * 12);
					

					$pages = ceil($total_events / 12);	
					$before = (($actual_page - 1) == 0) ? 1 : $actual_page - 1;

					$after = (($actual_page + 1) >= $pages) ? $pages : $actual_page+1;
				?>


				<h2>Nossos <span class="color-primary">Eventos</span> <?=((isset($page_number)) ? "| <small>(Página $page_number)</small>" : "")?></h2>
				<div class="events-list mt-3">
					<?php
				  		// $Event = new Event;
				  		// $events = $Event->getEvents();
				  		foreach($events->fetchAll(PDO::FETCH_ASSOC) as $event)
				  			echo Template::render($event, "loop_events");
				  	?>
			    </div>
			    <div class="pagination">
				    <?php if ($actual_page > 1): ?>
				        <a href="/app/events/page/<?= $before ?>" class="pagination__link">Anterior</a>
				    <?php endif; ?>

				    <?php for ($i = 1; $i <= $pages; $i++): ?>
				        <a href="/app/events/page/<?= $i ?>" class="pagination__link <?= $i == $actual_page ? 'active' : '' ?>">
				            <?= $i ?>
				        </a>
				    <?php endfor; ?>

				    <?php if ($actual_page < $pages): ?>
				        <a href="/app/events/page/<?= $after ?>" class="pagination__link">Próximo</a>
				    <?php endif; ?>
				</div>
			</div>
		</section>



		<?=Template::render(null, "footer_app")?>



		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
	</body>
</html>