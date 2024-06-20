<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto - Notícias</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		<?php include(__DIR__."/../templates/head-tags.phtml"); ?>
	</head>
	<body class="site">
		<?php include("header.phtml"); ?>

		<main class="m-5">
			<div class="container">
				<h2>Notícias</h2>
				<div class="post-grid">
					<?php
						$Post = new Post;

						$posts = $Post->getPosts(12, 0);

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
					<?php endforeach; else: ?>
					<div class="post-grid__item">
						<h3>Não foi possível encontrar posts.</h3>
					</div>
					<?php endif; ?>
				</div>				
			</div>
		</main>

		<?php include "footer.phtml"; ?>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/site.js"></script>
	</body>
</html>