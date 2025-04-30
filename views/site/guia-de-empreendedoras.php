<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Canal Salto Alto - Guia de Empreendedoras</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="site">
		<?=Template::render(null, "header_site")?>

		<section class="about mt-5 site__lp-about">
			<div class="container-xl">
				<div class="row">
					<div class="col-md-8">
						<h2>Guia de <strong class="color-primary">Empreendedoras</strong></h2>
						<p>Encontre as empresas das membros do Canal Salto Alto!</p>
					</div>
				</div>
			</div>
		</section>

        <section class="mt-0 mb-5">
			<div class="container-xl">

            <div class="d-flex flex-row flex-wrap gap-2">
                <?php
                    #$get_companies_categories = $Company->getCompaniesCategories();
                    #$companies_categories = $get_companies_categories->fetchAll(PDO::FETCH_ASSOC);
                    #foreach($companies_categories as $category):
                ?>
                <!-- <a href="?category=<?=$category['id_company_category']?>"><button type="button" class="btn btn-sm btn-outline-primary rounded-pill me-2">#<?=$category['category_name']?></button></a> -->
                <?php 
                #endforeach; 
                ?>
                </div>

				<?php 
					$actual_page = (isset($page_number)) ? (int) $page_number : 1;
					$start = (($actual_page - 1) * 12);
					

					$pages = ceil($total_companies / 12);	
					$before = (($actual_page - 1) == 0) ? 1 : $actual_page - 1;

					$after = (($actual_page + 1) >= $pages) ? $pages : $actual_page+1;
				?>
				<div class="companies-list mt-3">
				<?php
			  		if($companies->rowCount() > 0):
			  			foreach($companies->fetchAll(PDO::FETCH_ASSOC) as $company):
			  				echo Template::render($company, "loop_companies");
			  			endforeach; endif; ?>
			    </div>

			    <div class="pagination">
                    <?php if ($actual_page > 1): ?>
                        <a href="/guia-de-empreendedoras/page/<?= $before ?><?= isset($_GET['category']) ? '?category=' . $_GET['category'] : '' ?>" class="pagination__link">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <a href="/guia-de-empreendedoras/page/<?= $i ?><?= isset($_GET['category']) ? '?category=' . $_GET['category'] : '' ?>" class="pagination__link <?= $i == $actual_page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($actual_page < $pages): ?>
                        <a href="/guia-de-empreendedoras/page/<?= $after ?><?= isset($_GET['category']) ? '?category=' . $_GET['category'] : '' ?>" class="pagination__link">Próximo</a>
                    <?php endif; ?>
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