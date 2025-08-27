<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<title>Serviços Extras ‹ Área de Membros ‹ Canal Salto Alto</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?=PATH?>assets/css/styles.css?<?=uniqid()?>" />
		<link rel="icon" href="<?=PATH?>assets/images/favicon.png" />

		
		<?=Template::render(["is_private_area" => true], "head-tags")?>
	</head>
	<body class="app">
		<?=Template::render(null, "header_app")?>

		<section class="app__consultancies">
			<div class="container-xl">
                <div style="width: 1200px;max-width: 100%">
                    <h1>Serviços Extras</h1>
					<p>Olá empreendedora membro!</p>
					<p>Temos abaixo os serviços disponíveis em nossa aba de Serviços Extras. Eles estarão habilitados para você de acordo com a sua assinatura de membro.</p>
					<p>Este é mais um benefício que estamos oferecendo para você dar um SALTO ALTO na vida e nos negócios e conquistar o extraordinário. APROVEITE!</p>
					<p>Para acessar o benefício, clique no botão referente a ele, preencha o formulário e siga as instruções contidas no formulário. Caso precise, estaremos disponíveis em nosso whatsapp para te auxiliar. BORA CRESCER JUNTAS?! 🚀🚀🚀</p>
                    <div class="mb-3">
                        <a href="https://forms.gle/7CCex8QxMoBVdTae7" target="_blank">
                            <img src="<?=PATH?>assets/images/banner-consultoria-analise-instagram.png" alt="" style="width: 100%" />
                        </a>
                    </div>
                    <div>
                        <a href="https://wa.me/5527996959895" target="_blank">
                            <img src="<?=PATH?>assets/images/banner-sessao-orientacao.png" alt="" style="width: 100%" />
                        </a>
                    </div>
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