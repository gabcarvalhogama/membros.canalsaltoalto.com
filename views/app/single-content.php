<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title><?=$object->title?></title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<article class="site__single-post">

			<div class="site__single-post--highlight">
				<div style="background-image: url(<?=PATH.$object->featured_image?>);" class="d-none d-lg-block"></div>
				<img src="<?=PATH.$object->featured_image?>" alt="<?=$object->title?>" class="d-block d-lg-none" />
			</div>

			<div class="container-xl mt-3">
				<h1><?=$object->title?></h1>
				<ul class="d-flex flex-wrap site__single-post--terms">
					<li><a href="#"><i class="fa-solid fa-user"></i> <?=$object->firstname." ".$object->lastname?></a></li>
					<li><a href="#"><i class="fa-solid fa-calendar"></i> <?=date('d/m/Y \à\s H:i', strtotime($object->published_at))?></a></li>
					<li><a href="#comments"><i class="fa-solid fa-calendar"></i> <?php 
						if($object->number_comments == 0 OR $object->number_comments > 1) echo "$object->number_comments comentários";
						else echo "$object->number_comments comentário";?></a></li>
				</ul>
			</div>
			

			<div class="container-xl">
				<div class="site__single-post--grid">
					<div class="site__single-post--content">
						<?=$object->content?>

						<div>
							<?php
								if(!empty($object->featured_video)){
									$video1 = (str_replace("watch?v=", "embed/", $object->featured_video));
									$video2 = str_replace("youtu.be", "youtube.com/embed", $video1);


									echo '<iframe width="560" height="480" style="border-radius: 10px" src="'.($video2).'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
								}
							?>
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
								<input type="hidden" name="post_id" value="<?=$object->idcontent?>" />
							</form>


							<div class="comments">
								<?php
									$comments = $Content->getComments($object->idcontent);

									foreach($comments->fetchAll(PDO::FETCH_ASSOC) as $comment):
								?>

								<div class="comments__item mb-2">
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
			<div class="container-xl">
				<h2>Você também pode se interessar...</h2>
				<div class="contents hide-on-mobile">
					<?php
						$Content = new Content;

						$contents = $Content->getRelatedContents(12, $object->idcontent);

						if($contents->rowCount() > 0):
							foreach($contents->fetchAll(PDO::FETCH_ASSOC) as $content):
								echo Template::render($content, "loop_contents");
					?>
					
					<?php endforeach; else: ?>
					<div class="post-grid__item">
						<h3>Não foi possível encontrar posts.</h3>
					</div>
				<?php endif; ?>
				</div>



				<!-- MOBILE -->
				<div class="contents hide-on-desktop swiper">
					<div class="swiper-wrapper">
					<?php
						$Content = new Content;

						$contents = $Content->getRelatedContents(12, $object->idcontent);

						if($contents->rowCount() > 0):
							foreach($contents->fetchAll(PDO::FETCH_ASSOC) as $content):
								echo "<div class='swiper-slide'>";
								echo Template::render($content, "loop_contents");
								echo "</div>";
					?>
					
					<?php endforeach; else: ?>
					<div class="post-grid__item">
							<h3>Não foi possível encontrar posts.</h3>
						</div>
					<?php endif; ?>
					</div>
				</div>


			</div>
		</section>

		<?=Template::render(null, "footer_app")?>

		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/site.js"></script>
		<script type="text/javascript">
			
			const swiper = new Swiper('.swiper', {
				direction: 'horizontal',
				spaceBetween: 20,
			});
		</script>

	</body>
</html>