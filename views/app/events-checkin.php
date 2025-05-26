<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Faça o seu Check-in ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(null, "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__contents">
			<div class="container-xl">
                <div style="width: 500px;max-width: 100%;margin: 50px auto;">
                    <img src="<?=PATH.$event->event_poster?>" alt="" style="width: 100%;border-radius: 5px;">
                    
                    <?php
                        if($event_checkin->rowCount() > 0):
                    ?>
                    <h1 class="fs-2 mt-3">Olá, <?=USER->firstname?>, você já realizou check-in neste evento!</h1>
                    <?php else: ?>
                    <h1 class="fs-2 mt-3">Olá, <?=USER->firstname?>, você está prestes a realizar <strong>check-in</strong> no evento!</h1>
                    <p>Para fazer check-in no evento, toque no botão abaixo e aguarde.</p>
                    <button class="btn btn-rose btn-full" onclick="App.doEventCheckin(this, '<?=$event->qrcode_uuid?>', <?=USER->iduser?>)">FAZER CHECK-IN AGORA</button>
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