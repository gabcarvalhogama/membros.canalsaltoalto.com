<?php 
	require "application/autoload.php";

	$name = "Tati Serafim";
	$email = "faleconoscosaltoalto@gmail.com";

	$Comunications = new Comunications;

	$email_title = "Seja bem-vinda! - Canal Salto Alto";
	$content = "<div>
		<h1>Seja bem-vinda à Comunidade Canal Salto Alto</h1>
		<p>Olá <b>$name</b>, parabéns por dar mais um SALTO ALTO em seu empreendedorismo se tornando membro do Canal Salto Alto.</p>
		<p>Somos um canal de aprendizado e conexão com outras empreendedoras. Aqui o seu sucesso depende muito da sua participação nas ações que criamos, seja no digital e no presencial.</p>

		<p>Quanto mais você se conectar, mais se desenvolve, conhece novas pessoas e divulga o seu trabalho.</p>

		<p>Fique ligada! A Plataforma de Membros é nosso maior canal de comunicação.</p>

		<p>Você agora é uma membro ativa da Comunidade Canal Salto Alto. Clique no botão abaixo e acesse a plataforma:</p>
		<a href='https://canalsaltoalto.com/app' style='display: block;padding: 20px;border-radius: 5px;background-color: #E54C8E;color: #000;width: 100%;'>ACESSE A PLATAFORMA AGORA</a>
	</div>";
	$email_content = Template::render([
		"email_title" => $email_title,
		"email_content" => $content 
	], "email_general");



		// $Comunications->sendEmail($email, $email_title, $email_content);