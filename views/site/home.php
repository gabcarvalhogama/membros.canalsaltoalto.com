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
			  	<?php 
			  		$Banner = new Banner;
			  		$getBanners = $Banner->getBannersByPosition('public_home_hero');

			  		foreach($getBanners->fetchAll(PDO::FETCH_ASSOC) as $banner):
			  	?>
			  	 <div class="swiper-slide">
			    	<a href="<?=$banner['link']?>" target="_blank">
			    		<img src="<?=PATH.$banner['path_desktop']?>" class="site__hero--image d-none d-md-block" />
			    		<img src="<?=PATH.$banner['path_mobile']?>" class="site__hero--image d-block d-md-none" />
			    	</a>
			    </div>

				<?php endforeach; ?>
			  </div>
			  <div class="swiper-button-prev"></div>
			  <div class="swiper-button-next"></div>
			</div>
		</div>

		<section class="banner mt-3 mb-3">
			<div class="container-xl">
				<?php 
			  		$getBanners01 = $Banner->getBannersByPosition('public_home_ad1');

			  		foreach($getBanners01->fetchAll(PDO::FETCH_ASSOC) as $banner):
			  	?>
				<a href="<?=$banner['link']?>" target="_blank" style="display: block">
					<img src="<?=PATH.$banner['path_desktop']?>" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
				<?php endforeach; ?>
			</div>
		</section>

		

		<section class="banner mt-3 mb-3">
			<div class="container-xl">
				<?php 
			  		$getBanners02 = $Banner->getBannersByPosition('public_home_ad2');

			  		foreach($getBanners02->fetchAll(PDO::FETCH_ASSOC) as $banner):
			  	?>
				<a href="<?=$banner['link']?>" target="_blank" style="display: block">
					<img src="<?=PATH.$banner['path_desktop']?>" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
				<?php endforeach; ?>
			</div>
		</section>



		<section class="pt-3 pb-3">
			<div class="container-xl">

				<h3>Últimas notícias</h3>
				<div class="post-grid hide-on-mobile">
					<?php
						$Post = new Post;

						$posts = $Post->getPosts(6);

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

								$posts = $Post->getPosts(6);
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

				<div class="text-center">
					
					<a href="/noticias"><button class="btn btn-rose">Veja outras notícias</button></a>
				</div>
			</div>
		</section>



		<section class="banner mt-3 mb-3">
			<div class="container-xl">
				<?php 
			  		$getBanners03 = $Banner->getBannersByPosition('public_home_ad3');

			  		foreach($getBanners03->fetchAll(PDO::FETCH_ASSOC) as $banner):
			  	?>
				<a href="<?=$banner['link']?>" target="_blank" style="display: block">
					<img src="<?=PATH.$banner['path_desktop']?>" alt="" class="img-fluid" style="width: 100%;display: block;border-radius: 5px;" />
				</a>
				<?php endforeach; ?>
			</div>
		</section>


		<section class="companies mt-5 mb-5">
			<div class="container-xl">
				<h2>Empresas da nossa rede!</h2>
				<!-- Slider main container -->
				<div class="swiper swiper_companies">
				  <div class="swiper-wrapper">
				    <?php
				  		$Company = new Company;
				  		$companies = $Company->getCompaniesEnabledAndActiveMembers();
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

		<section class="newsletter bg-primary p-4 mt-5 mb-5">
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
				  		$users = $User->getLastUsersWithFirstMembership(12);
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
				  
				  <div class="swiper-button-prev"></div>
				  <div class="swiper-button-next"></div>
				</div>
			</div>
		</section>

		<section class="banners mt-4 mb-1">
			<div class="container-xl">
				<div class="d-flex flex-column flex-md-row flex-wrap justify-content-between">
					<div class="banner-item">
						<a href="https://canalsaltoalto.com/app" target="_blank"><img src="<?=PATH?>assets/images/banner-plataforma.png" alt="" style="width: 100%;"></a>
					</div>
					<div class="banner-item">
						<a href="https://www.youtube.com/c/CanalSaltoAlto" target="_blank"><img src="<?=PATH?>assets/images/banner-canal-youtube.png" alt="" style="width: 100%;"></a>
					</div>
					<div class="banner-item">
						<a href="https://canalsaltoalto.com/guia-de-empreendedoras/" target="_blank"><img src="<?=PATH?>assets/images/banner-guia-empreendedoras.png" alt="" style="width: 100%;"></a>
					</div>
				</div>
			</div>
		</section>


		<?=Template::render(null, "footer_site")?>


		<script type="text/javascript" src="<?=PATH?>assets/js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/jquery.mask.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=PATH?>assets/js/site.js?<?=uniqid()?>"></script>
	</body>
</html>