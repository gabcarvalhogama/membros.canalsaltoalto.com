<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title><?=$object->title?></title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />
		<?php include(__DIR__."/../templates/head-tags.phtml"); ?>

	</head>
	<body class="app">
		<?php include("header.phtml"); ?>

		<article class="site__single-post">

			<div class="site__single-post--highlight">
				<div style="background-image: url(<?=PATH.$object->featured_image?>);"></div>
			</div>

			<div class="container mt-3">
				<h1><?=$object->title?></h1>
				<ul class="d-flex site__single-post--terms">
					<li><a href="#"><i class="fa-solid fa-user"></i> <?=$object->firstname." ".$object->lastname?></a></li>
					<li><a href="#"><i class="fa-solid fa-calendar"></i> <?=date('d/m/Y \à\s H:i', strtotime($object->published_at))?></a></li>
					<li><a href="#comments"><i class="fa-solid fa-calendar"></i> <?php 
						if($object->number_comments == 0 OR $object->number_comments > 1) echo "$object->number_comments comentários";
						else echo "$object->number_comments comentário";?></a></li>
				</ul>
			</div>
			

			<div class="container">
				<div class="site__single-post--grid">
					<div class="site__single-post--content">
						<?=$object->content?>

						<div>
							<?=$object->featured_video?>
						</div>

						<div class="site__single-post--comments" id="#comments">
							<h3>Deixe um Comentário</h3>
							<p>Faça parte da discursão sobre essa postagem, deixe um comentário falando o que você pensou!</p>
							<form onsubmit="Post.comment(this);" method="post" action="javascript:void(0)" accept-charset="utf-8">
								<div class="row">
									<div class="mb-3 col">
									  <input type="text" class="form-control" id="name" name="name" placeholder="Seu nome" required />
									</div>
									<div class="mb-3 col">
									  <input type="email" class="form-control" id="email" name="email" placeholder="Seu e-mail" required />
									</div>
								</div>
								<div class="row mb-3"> 
									<div class="col">
										<textarea class="form-control" id="comment__field" name="comment" placeholder="Digite seu comentário..."></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<button class="btn btn-rose">Postar comentário</button>
									</div>
								</div>
								<input type="hidden" name="post_id" value="<?=$object->post_id?>" />
							</form>


							<div class="comments">
								<?php
									$comments = $Content->getComments($object->idcontent);

									foreach($comments->fetchAll(PDO::FETCH_ASSOC) as $comment):
								?>

								<div class="comments__item">
									<h3><?=$comment['user_name']?> às <?=date('d/m/Y \à\s H:i', strtotime($comment['created_at']))?></h3>
									<div class="comments__item--comment">
										<?=$comment['comment']?>
									</div>
								</div>

								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<aside class="site__single-post--bar"></aside>
				</div>
			</div>
		</article>

		<section class="related-posts mb-3 mt-3">
			<div class="container">
				<h2>Você também pode se interessar...</h2>
				<div class="contents">
					<?php
						$Content = new Content;

						$contents = $Content->getRelatedContents(12, $object->idcontent);

						if($contents->rowCount() > 0):
							foreach($contents->fetchAll(PDO::FETCH_ASSOC) as $content):
					?>
					<div class="contents__item">
						<div class="contents__item--photo" style="background-image: url('<?=$content["featured_image"]?>')"></div>
						<div class="contents__item--content">
							<h3><?=$content["title"]?></h3>
							<a href="<?=PATH?>app/content/<?=$content['slug']?>" class="cta">LEIA MAIS »</a>
						</div>
					</div>
					<?php endforeach; else: ?>
					<div class="post-grid__item">
						<h3>Não foi possível encontrar posts.</h3>
					</div>
				<?php endif; ?>
				</div>
			</div>
		</section>

		<?php include("footer.phtml"); ?>

		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/site.js"></script>


	</body>
</html>