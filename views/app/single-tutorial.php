<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title><?=$object->tutorial_title?></title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<article class="site__single-post">

			

			<div class="container-xl mt-3">
				<h1><?=$object->tutorial_title?></h1>
				<ul class="d-flex flex-wrap site__single-post--terms">
					<li><a href="#"><i class="fa-solid fa-calendar"></i> <?=date('d/m/Y \à\s H:i', strtotime($object->published_at))?></a></li>
				</ul>
				<?php if($object->tutorial_video_url): ?>
					<iframe width="560" height="315" src="<?=$object->tutorial_video_url?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
				<?php endif; ?>
			</div>
			

			<div class="container-xl">
				<div class="site__single-post--grid">
					<div class="site__single-post--content">
						<?=$object->tutorial_content?>

						
					</div>
					<aside class="site__single-post--bar"></aside>
				</div>
			</div>
		</article>

		<?=Template::render(null, "footer_app")?>

		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/app.js"></script>
		<script type="text/javascript">
			
			const swiper = new Swiper('.swiper', {
				direction: 'horizontal',
				spaceBetween: 20,
			});
		</script>

	</body>
</html>