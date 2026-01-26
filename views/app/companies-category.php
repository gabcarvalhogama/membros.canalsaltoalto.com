<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Empresas — <?=htmlspecialchars($category->category_name)?> ‹ Área de Membros ‹ Canal Salto Alto</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
        <link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

    <?=Template::render(["is_private_area" => true], "head-tags")?>

    <style>
    /* Companies categories pills (matches companies.php) */
    .companies-categories{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem}
    .companies-categories__item{display:inline-flex;align-items:center;gap:.45rem;padding:.35rem .75rem;border-radius:50rem;border:1px solid rgba(var(--bs-primary-rgb),0.12);color:var(--bs-primary);background:transparent;text-decoration:none;font-size:.95rem;transition:all .15s ease-in-out}
    .companies-categories__item img{height:18px;width:auto;display:inline-block}
    .companies-categories__item:hover{background:rgba(var(--bs-primary-rgb),0.08);transform:translateY(-1px);text-decoration:none}
    .companies-categories__item.active,.companies-categories__item[aria-current="page"]{background:var(--bs-primary);color:#fff;border-color:transparent}
    @media(max-width:575px){.companies-categories__item{padding:.3rem .6rem;font-size:.9rem}}
    </style>
    </head>
    <body class="app">
        <?=Template::render(null, "header_app")?>

        <section class="app__companies mt-5 mb-5">
            <div class="container-xl">
                <?php 
                    $actual_page = (isset($page_number)) ? (int) $page_number : 1;
                    $start = (($actual_page - 1) * 12);

                    $pages = ceil($total_companies / 12);    
                    $before = (($actual_page - 1) == 0) ? 1 : $actual_page - 1;

                    $after = (($actual_page + 1) >= $pages) ? $pages : $actual_page+1;
                ?>
                <div class="d-flex flex-column flex-md-row justify-content-between">
                    <h2>Empresas na categoria <span class="color-primary"><?=htmlspecialchars($category->category_name)?></span> <?=((isset($page_number)) ? "| <small>(Página $page_number)</small>" : "")?></h2>
                    <div class="d-flex flex-row align-items-center">
                        <a href="/app/members/<?=USER->iduser?>/companies" class="me-3">Editar minhas empresas</a>
                        <a href="/app/companies/new"><button class="btn btn-rose btn-rounded">Cadastre sua empresa</button></a>
                    </div>
                </div>

                <div class="companies-list mt-3">

                <?php
                    $company = new Company();

                    $categories = $company->getEnabledCompaniesCategories();
                    // determine active slug for this category page
                    $active_slug = (isset($category) && is_object($category) && !empty($category->slug)) ? $category->slug : null;
                    if($categories->rowCount() > 0):
                        echo '<div class="companies-categories mb-4">';
                        foreach($categories->fetchAll(PDO::FETCH_ASSOC) as $cat):
                            $category_name = (!empty($cat['icon'])) ? '<img src="'.PATH.'uploads/'.$cat['icon'].'" alt="'.$cat['category_name'].'" class="me-2" />' : '';
                            $category_name .= $cat['category_name'];
                            $is_active = ($active_slug && $cat['slug'] === $active_slug);
                            $class_attr = 'companies-categories__item' . ($is_active ? ' active' : '');
                            $aria = $is_active ? ' aria-current="page"' : '';
                            echo '<a href="/app/companies/category/'.$cat['slug'].'" class="'.$class_attr.'"'.$aria.'>'. $category_name .'</a>';
                        endforeach;
                        echo '</div>';
                    endif;
                ?>

                <?php
                    if($companies->rowCount() > 0):
                        foreach($companies->fetchAll(PDO::FETCH_ASSOC) as $company):
                            echo Template::render($company, "loop_companies");
                        endforeach; endif; ?>
                </div>

                <div class="pagination">
                    <?php if ($actual_page > 1): ?>
                        <?php if ($before == 1): ?>
                            <a href="/app/companies/category/<?= $category->slug ?>" class="pagination__link">Anterior</a>
                        <?php else: ?>
                            <a href="/app/companies/category/<?= $category->slug ?>/page/<?= $before ?>" class="pagination__link">Anterior</a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <?php if ($i == 1): ?>
                            <a href="/app/companies/category/<?= $category->slug ?>" class="pagination__link <?= $i == $actual_page ? 'active' : '' ?>"><?= $i ?></a>
                        <?php else: ?>
                            <a href="/app/companies/category/<?= $category->slug ?>/page/<?= $i ?>" class="pagination__link <?= $i == $actual_page ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($actual_page < $pages): ?>
                        <a href="/app/companies/category/<?= $category->slug ?>/page/<?= $after ?>" class="pagination__link">Próximo</a>
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
