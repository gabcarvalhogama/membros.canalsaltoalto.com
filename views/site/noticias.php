<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto - Notícias</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />
		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="site">
		<?=Template::render(null, "header_site")?>

		<main class="mt-5 mb-5">
			<div class="container-xl">

				<?php 
					$actual_page = (isset($page_number)) ? (int) $page_number : 1;
					$start = (($actual_page - 1) * 12);
					

					$pages = ceil($total_posts / 12);	
					$before = (($actual_page - 1) == 0) ? 1 : $actual_page - 1;

					$after = (($actual_page + 1) >= $pages) ? $pages : $actual_page+1;
				?>
				<h2>Notícias <?=((isset($page_number)) ? "| <small>(Página $page_number)</small>" : "")?></h2>

				<div class="post-grid">
					<?php
						if($posts->rowCount() > 0):
							foreach($posts->fetchAll(PDO::FETCH_ASSOC) as $post):
					?>
					<div class="post-grid__item">
						<div class="post-grid__item--tag">
							<a href="#">NOTÍCIA</a>
						</div>
						<div class="post-grid__item--image">
							<a href="<?=PATH.'post/'.$post['slug']?>">
								<div style="background-image: url('<?=PATH.$post['featured_image']?>');"></div>
							</a>
						</div>
						<div class="post-grid__item--content">
							<h3><a href="<?=PATH.'post/'.$post['slug']?>"><?=$post['title']?></a></h3>
							<p class="post-grid__item--content-resume">
								<?=$post['excerpt']?>
							</p>
							<a href="<?=PATH.'post/'.$post['slug']?>" class="post-grid__item--content-cta"><button>CONTINUE LENDO <span>»</span></button></a>
						</div>
					</div>
					<?php endforeach; ?>
					
					<div class="pagination">
					    <?php if ($actual_page > 1): ?>
					        <a href="/noticias/page/<?= $before ?>" class="pagination__link">Anterior</a>
					    <?php endif; ?>

					    <?php for ($i = 1; $i <= $pages; $i++): ?>
					        <a href="/noticias/page/<?= $i ?>" class="pagination__link <?= $i == $actual_page ? 'active' : '' ?>">
					            <?= $i ?>
					        </a>
					    <?php endfor; ?>

					    <?php if ($actual_page < $pages): ?>
					        <a href="/noticias/page/<?= $after ?>" class="pagination__link">Próximo</a>
					    <?php endif; ?>
					</div>


					<?php else: ?>
					<div class="post-grid__item">
						<h3>Não foi possível encontrar posts.</h3>
					</div>
					<?php endif; ?>
				</div>				
			</div>
		</main>

		<?=Template::render(null, "footer_site")?>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/site.js"></script>
	</body>
</html>