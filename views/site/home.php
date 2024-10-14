<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto - Uma rede de apoio a mulheres empreendedoras</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="site">
		<?=Template::render(null, "header_site")?>

		<div class="site__hero">
			
			<!-- Slider main container -->
			<div class="swiper swiper_hero">
			  <div class="swiper-wrapper">
			    <div class="swiper-slide">
			    	<a href="https://www.youtube.com/playlist?list=PL7QAaleeNYRztUZvoBAdVH4Oq239rjNnb" target="_blank">
			    		<img src="<?=PATH?>uploads/2024/08/site-banner-salto-alto-pod.png" class="site__hero--image d-none d-md-block" />
			    		<img src="<?=PATH?>uploads/2024/08/BANNER-MOBILE-425x425.png" class="site__hero--image d-block d-md-none" />
			    	</a>
			    </div>
			    <div class="swiper-slide">
			    	<a href="/" target="_blank">
			    		<img src="<?=PATH?>uploads/2024/08/site-banner-institucional.jpg" class="site__hero--image d-none d-md-block" />
			    		<img src="<?=PATH?>uploads/2024/08/Banner-1-mobile.jpg" class="site__hero--image d-block d-md-none" />
			    	</a>
			    </div>
			    <div class="swiper-slide">
			    	<a href="https://membros.canalsaltoalto.com/" target="_blank">
			    		<img src="<?=PATH?>uploads/2024/08/site-banner-seja-membro.jpg" class="site__hero--image d-none d-md-block" />
			    		<img src="<?=PATH?>uploads/2024/08/Banner-2-mobile.jpg" class="site__hero--image d-block d-md-none" />
			    	</a>
			    </div>
			    <div class="swiper-slide">
			    	<a href="https://www.sicoob.com.br/web/sicoobes/para-voce" target="_blank">
			    		<img src="<?=PATH?>uploads/2024/08/site-banner-sicoob.png" class="site__hero--image d-none d-md-block" />
			    		<img src="<?=PATH?>uploads/2024/08/BANNER-SICOOB-MOBILE-500x500px.png" class="site__hero--image d-block d-md-none" />
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
			<div class="container-xl">
				<a href="https://www.sicoob.com.br/web/sicoobes/para-voce" target="_blank" style="display: block">
					<img src="<?=PATH?>uploads/2024/07/BANNER-SICOOB-900x100px.png" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
			</div>
		</section>

		<section class="banners mt-4 mb-1">
			<div class="container-xl">
				<div class="d-flex flex-column flex-md-row flex-wrap justify-content-between">
					<div class="banner-item">
						<a href="https://membros.canalsaltoalto.com/" target="_blank"><img src="<?=PATH?>uploads/2024/07/banner-plataforma-membros.jpg" alt="" style="width: 100%;"></a>
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
			<div class="container-xl">
				<a href="https://wa.me/message/UIAZUSAT7AZNK1" target="_blank" style="display: block">
					<img src="<?=PATH?>uploads/2024/07/club1.png" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
			</div>
		</section>



		<section class="pt-3 pb-3">
			<div class="container-xl">

				<h3>Últimas notícias</h3>
				<div class="post-grid hide-on-mobile">
					<?php
						$Post = new Post;

						$posts = $Post->getPosts();

						if($posts->rowCount() > 0):
							foreach($posts->fetchAll(PDO::FETCH_ASSOC) as $post)
					  			echo Template::render($post, "loop_posts");

					  	else:
					?>
					<div class="post-grid__item">
						<h3>Não foi possível encontrar posts.</h3>
					</div>
				<?php endif; ?>
				</div>


				<!-- MOBILE -->
				<div class="hide-on-desktop">
					<div class="post-grid-slider swiper">
				  		<div class="swiper-wrapper">
							<?php
								$Post = new Post;

								$posts = $Post->getPosts();
								if($posts->rowCount() > 0){
									foreach($posts->fetchAll(PDO::FETCH_ASSOC) as $post){
										echo "<div class='swiper-slide'>";
							  			echo Template::render($post, "loop_posts");
							  			echo "</div>";
									}
								}else{ ?>
								<div class="post-grid__item">
									<h3>Não foi possível encontrar posts.</h3>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>



		<section class="banner mt-3 mb-3">
			<div class="container-xl">
				<a href="https://limilk.com.br/" target="_blank" style="display: block">
					<img src="<?=PATH?>uploads/2024/07/LIMILK.png" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
			</div>
		</section>


		<section class="companies mt-3 mb-3">
			<div class="container-xl">
				<h2>Essas empresas estão conosco!</h2>
				<!-- Slider main container -->
				<div class="swiper swiper_companies">
				  <div class="swiper-wrapper">
				    <?php
				  		$Company = new Company;
				  		$companies = $Company->getCompanies();
				  		if($companies->rowCount() > 0):
				  			foreach($companies->fetchAll(PDO::FETCH_ASSOC) as $company):
				  	?>
				  		<div class="swiper-slide">
					    	<div class="companies--item">
					    		<div class="companies--item__content">
					    			<img src="/<?=$company["company_image"]?>" alt="" />
					    			<h3><?=$company["company_name"]?></h3>
					    		</div>
					    	</div>
					    </div>
				  	<?php endforeach; endif; ?>
				  </div>
				</div>
			</div>
		</section>

		<section class="newsletter bg-primary p-4">
			<div class="container-xl">
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



		<section class="members mt-3 mb-3">
			<div class="container-xl">
				<h2>Sejam bem-vindas! ❤</h2>
				<p>Nossas mais novas membros do Canal Salto Alto.</p>
				<!-- Slider main container -->
				<div class="swiper swiper_members">
				  <div class="swiper-wrapper">
				    <?php
				  		$User = new User;
				  		$users = $User->getLastUsersWithMembership(10);
				  		if($users->rowCount() > 0):
				  			foreach($users->fetchAll(PDO::FETCH_ASSOC) as $user_loop):
				  				if(empty($user_loop["profile_photo"])) continue;
				  	?>

				  		<div class="swiper-slide">
					    	<div class="members--item">
					    		<div class="members--item__content">
					    			<img src="/<?=$user_loop["profile_photo"]?>" alt="" />
					    			<h3><?=$user_loop["firstname"]." ".$user_loop["lastname"]?></h3>
					    		</div>
					    	</div>
					    </div>

				  	<?php endforeach; endif; ?>
				  </div>
				</div>
			</div>
		</section>


		<?=Template::render(null, "footer_site")?>


		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/site.js"></script>
	</body>
</html>