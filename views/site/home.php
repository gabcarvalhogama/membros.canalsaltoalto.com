<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto - Uma rede de apoio a mulheres empreendedoras</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		<?php include(__DIR__."/../templates/head-tags.phtml"); ?>
	</head>
	<body class="site">
		<?php include("header.phtml"); ?>

		<div class="site__hero">
			
			<!-- Slider main container -->
			<div class="swiper swiper_hero">
			  <div class="swiper-wrapper">
			    <div class="swiper-slide">
			    	<a href="https://www.youtube.com/playlist?list=PL7QAaleeNYRztUZvoBAdVH4Oq239rjNnb" target="_blank">
			    		<img src="<?=PATH?>assets/images/site-banner-salto-alto-pod.png" class="site__hero--image" />
			    	</a>
			    </div>
			    <div class="swiper-slide">
			    	<a href="/" target="_blank">
			    		<img src="<?=PATH?>assets/images/site-banner-institucional.jpg" class="site__hero--image" />
			    	</a>
			    </div>
			    <div class="swiper-slide">
			    	<a href="https://membros.canalsaltoalto.com/" target="_blank">
			    		<img src="<?=PATH?>assets/images/site-banner-seja-membro.jpg" class="site__hero--image" />
			    	</a>
			    </div>
			    <div class="swiper-slide">
			    	<a href="https://www.sicoob.com.br/web/sicoobes/para-voce" target="_blank">
			    		<img src="<?=PATH?>assets/images/site-banner-sicoob.png" class="site__hero--image" />
			    	</a>
			    </div>
			  </div>
			  <!-- If we need pagination -->
			  <div class="swiper-pagination"></div>

			  <!-- If we need navigation buttons -->
			  <div class="swiper-button-prev"></div>
			  <div class="swiper-button-next"></div>
			</div>
		</div>

		<section class="banner mt-3 mb-3">
			<div class="container">
				<a href="https://www.sicoob.com.br/web/sicoobes/para-voce" target="_blank" style="display: block">
					<img src="<?=PATH?>uploads/2024/07/BANNER-SICOOB-900x100px.png" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
			</div>
		</section>

		<section class="banners mt-4 mb-1">
			<div class="container">
				<div class="d-flex flex-row flex-wrap justify-content-between">
					<div class="banner-item">
						<a href="https://membros.canalsaltoalto.com/" target="_blank"><img src="<?=PATH?>uploads/2024/07/banner-plataforma-membros.jpg" alt="" style="width: 100%;"></a>
					</div>
					<div class="banner-item">
						<a href="https://marketplace.canalsaltoalto.com/" target="_blank"><img src="<?=PATH?>uploads/2024/07/marketplace-banner.jpg" alt="" style="width: 100%;"></a>
					</div>
					<div class="banner-item">
						<a href="https://www.youtube.com/c/CanalSaltoAlto" target="_blank"><img src="<?=PATH?>uploads/2024/07/banner-canal-youtube.jpg" alt="" style="width: 100%;"></a>
					</div>
					<div class="banner-item">
						<a href="https://canalsaltoalto.com/guia-de-empreendedoras/" target="_blank"><img src="<?=PATH?>uploads/2024/07/Banner-guia-de-empreendedoras.jpg" alt="" style="width: 100%;"></a>
					</div>
				</div>
			</div>
		</section>

		<section class="banner mt-3 mb-3">
			<div class="container">
				<a href="https://wa.me/message/UIAZUSAT7AZNK1" target="_blank" style="display: block">
					<img src="<?=PATH?>uploads/2024/07/club1.png" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
			</div>
		</section>



		<section class="pt-3 pb-3">
			<div class="container">

				<h3>Últimas notícias</h3>
				<div class="post-grid hide-on-mobile">
					<?php
						$Post = new Post;

						$posts = $Post->getPosts();

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


				<!-- MOBILE -->
				<div class="post-grid-slider swiper hide-on-desktop">
			  		<div class="swiper-wrapper">
					<?php
						$Post = new Post;

						$posts = $Post->getPosts();

						if($posts->rowCount() > 0):
							foreach($posts->fetchAll(PDO::FETCH_ASSOC) as $post):
					?>
					<div class="post-grid__item swiper-slide">
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

					<!-- If we need pagination -->
					<div class="swiper-pagination"></div>

					<!-- If we need navigation buttons -->
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				</div>



				</div>
			</div>
		</section>



		<section class="banner mt-3 mb-3">
			<div class="container">
				<a href="https://limilk.com.br/" target="_blank" style="display: block">
					<img src="<?=PATH?>uploads/2024/07/LIMILK.png" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
			</div>
		</section>

		<section class="newsletter bg-primary p-4">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6">
						<h5>Seja avisada das novidades do <b>Canal Salto Alto!</b></h5>
					</div>
					<div class="col-md-6">
						<form action="">
							<div class="d-flex flex-row">
								<input type="email" placeholder="Qual o seu e-mail?" />
								<button>OK!</button>
							</div>
						</form>
					</div>
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