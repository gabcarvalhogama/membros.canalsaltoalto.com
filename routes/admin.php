<?php 
	
	$router->before('GET|POST', '/admin(?!/login$).*', function(){
		$User = new User;
		if((($User->isUserAuthenticated()) == false OR $User->isUserAMember($_SESSION["csa_email"]) == 0) OR !$User->isUserAdminByEmail($_SESSION["csa_email"])) die(header("Location: /admin/login"));


	});

	$router->mount("/admin", function() use ($router){
		$router->get("/", function(){
			require "views/admin/index.php";
		});

		$router->get("/login", function(){
			require "views/admin/login.php";
		});
		$router->post("/login", function(){
			if(empty($_POST["login_email"])){
				die(json_encode(["res" => "Por favor, informe seu e-mail para acesso."]));
			}else if(empty($_POST["login_password"])){
				die(json_encode(["res" => "Por favor, informe sua senha para acesso."]));
			}else{
				$User = new User;
				if($User->login($_POST["login_email"], $_POST["login_password"]) AND $User->isUserAdminByEmail($_POST["login_email"])){
					$_SESSION["csa_email"] = $_POST["login_email"];
					$_SESSION["csa_password"] = $_POST["login_password"];

					die(json_encode(["res"=>1]));
				}else{
					die(json_encode(["res"=>"O e-mail ou senha estão incorretos. Verifique os dados e tente novamente!"]));
				}
			}
		});


		#/admin/posts
		$router->get("/posts", function(){
			require "views/admin/posts.php";
		});
		$router->get("/posts/new", function(){
			require "views/admin/posts-new.php";
		});
		$router->post("/posts/new", function(){
			if(empty($_POST["post_title"]) OR empty(trim($_POST["post_title"]))){
				die(json_encode(["res" => "Por favor, informe um título para o post."]));
			}else if(empty($_POST["post_excerpt"])){
				die(json_encode(["res" => "Por favor, informe um resumo para o post."]));
			}else if(empty($_POST["post_content"])){
				die(json_encode(["res" => "Por favor, informe um conteúdo para o post."]));
			}else{
				if(isset($_FILES["post_featured_image"]) AND !empty($_FILES["post_featured_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["post_featured_image"]["name"], 10, "jpeg,jpg,png", "post_featured_image", 1);
					$Upin->run();

					if($Upin->res === true) $post_featured_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
				}


				$Post = new Post;

				if($Post->create(
					$_POST["post_title"],
					$_POST["post_excerpt"],
					$_POST["post_content"],
					$post_featured_image,
					$_SESSION["csa_email"]
				)){
					die(json_encode(["res" => 1]));
				}else{
					die(json_encode(["res" => "Desculpe, não foi possível criar o seu post. Atualize a página e tente novamente."]));
				}
			}
		});
		$router->get("/posts/edit/{post_id}", function($post_id){
			$Post = new Post;
			$getPost = $Post->getPost($post_id);

			if($getPost->rowCount() == 0){
				header("Location: /admin/posts");
				exit;
			}

			$post = $getPost->fetchObject();


			require "views/admin/posts-edit.php";
		});
		$router->post("/posts/edit/{post_id}", function($post_id){
			if(empty($post_id)){
				die(json_encode(["res" => "Por favor, informe o ID do post."]));
			}else if(empty($_POST["post_title"]) OR empty(trim($_POST["post_title"]))){
				die(json_encode(["res" => "Por favor, informe um título para o post."]));
			}else if(empty($_POST["post_excerpt"])){
				die(json_encode(["res" => "Por favor, informe um resumo para o post."]));
			}else if(empty($_POST["post_content"])){
				die(json_encode(["res" => "Por favor, informe um conteúdo para o post."]));
			}else{
				if(isset($_FILES["post_featured_image"]) AND !empty($_FILES["post_featured_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["post_featured_image"]["name"], 10, "jpeg,jpg,png", "post_featured_image", 1);
					$Upin->run();

					if($Upin->res === true) $post_featured_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					if(empty($_POST["post_actual_featured_image"]))
						die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
					else
						$post_featured_image = $_POST["post_actual_featured_image"];
				}


				$Post = new Post;
				if($Post->update(
					$post_id,
					$_POST["post_title"],
					$_POST["post_excerpt"],
					$_POST["post_content"],
					$post_featured_image,
					$_SESSION["csa_email"]
				)){
					die(json_encode(["res" => 1]));
				}else{
					die(json_encode(["res" => "Desculpe, não foi possível criar o seu post. Atualize a página e tente novamente."]));
				}
			}
		});


		# Contents
		$router->get("/contents", function(){
			require "views/admin/contents.php";
		});
		$router->get("/contents/new", function(){
			require "views/admin/contents-new.php";
		});
		$router->post("/contents/new", function(){
			if(empty($_POST["content_title"])){
				die(json_encode(["res"=>"Por favor, informe o título do conteúdo!"]));
			}else if(empty($_POST["content_excerpt"])){
				die(json_encode(["res"=>"Por favor, informe o resumo do conteúdo!"]));
			}else if(empty($_POST["content_content"])){
				die(json_encode(["res"=>"Por favor, informe o conteúdo do conteúdo!"]));
			}else if(!empty($_POST["content_featured_video_url"]) AND filter_var($_POST["content_featured_video_url"], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) == false){
				die(json_encode(["res"=>"Por favor, informe uma URL válida para o vídeo em destaque!"]));
			}else{

				if(isset($_FILES["content_featured_image"]) AND !empty($_FILES["content_featured_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["content_featured_image"]["name"], 10, "jpeg,jpg,png", "content_featured_image", 1);
					$Upin->run();

					if($Upin->res === true) $content_featured_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
				}

				// $User = new User;
				// if(($User->isUserAuthenticated()) == false)
				// 	die(json_encode(["res"=>"Oops, parece que você não tem permissão para isso!"]));


				$Content = new Content;
				if($Content->create($_POST["content_title"], $_POST["content_excerpt"], $_POST["content_content"], $content_featured_image, $_POST["content_featured_video_url"], $_SESSION["csa_email"]))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Não foi possível criar este conteúdo. Atualize a página e tente novamente!"]));
			}
		});
		$router->get("/contents/edit/{content_id}", function($content_id){
			$Content = new Content;
			$getContent = $Content->getContentById($content_id);

			if($getContent->rowCount() == 0){
				header("Location: /admin/contents");
				exit;
			}

			$content = $getContent->fetchObject();


			require "views/admin/contents-edit.php";
		});
		$router->post("/contents/edit/{content_id}", function($content_id){
			if(empty($content_id)){
				die(json_encode(["res" => "Desculpe, não foi possível atualizar este conteúdo."]));
			}else if(empty($_POST["content_title"])){
				die(json_encode(["res"=>"Por favor, informe o título do conteúdo!"]));
			}else if(empty($_POST["content_excerpt"])){
				die(json_encode(["res"=>"Por favor, informe o resumo do conteúdo!"]));
			}else if(empty($_POST["content_content"])){
				die(json_encode(["res"=>"Por favor, informe o conteúdo do conteúdo!"]));
			}else if(!empty($_POST["content_featured_video_url"]) AND filter_var($_POST["content_featured_video_url"], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) == false){
				die(json_encode(["res"=>"Por favor, informe uma URL válida para o vídeo em destaque!"]));
			}else{

				if(isset($_FILES["content_featured_image"]) AND !empty($_FILES["content_featured_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["content_featured_image"]["name"], 10, "jpeg,jpg,png", "content_featured_image", 1);
					$Upin->run();

					if($Upin->res === true) $content_featured_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					$content_featured_image = $_POST["content_featured_image_actual"];
				}



				$Content = new Content;
				if($Content->update($content_id, $_POST["content_title"], $_POST["content_excerpt"], $_POST["content_content"], $content_featured_image, $_POST["content_featured_video_url"]))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Não foi possível atualizar este conteúdo. Atualize a página e tente novamente!"]));
			}
		});


		# /clubs
		$router->get("/clubs", function(){
			require "views/admin/clubs.php";
		});
		$router->get("/clubs/new", function(){
			require "views/admin/clubs-new.php";
		});
		$router->post("/clubs/new", function(){
			if(empty($_POST["club_title"])){
				die(json_encode(["res" => "Por favor, informe um título para o clube."]));
			}else if(empty($_POST["club_description"])){
				die(json_encode(["res" => "Por favor, informe uma descrição para o clube."]));
			}else{
				if(isset($_FILES["club_image"]) AND !empty($_FILES["club_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["club_image"]["name"], 10, "jpeg,jpg,png", "club_image", 1);
					$Upin->run();

					if($Upin->res === true) $club_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem válida."]));
				}else{
					die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
				}


				$Club = new Club;

				if($Club->create($_POST["club_title"], $_POST["club_description"], $club_image, 1, $_SESSION['csa_email']))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, algo deu errado ao criar o clube. Atualize a página e tente novamente!"]));


			}
		});

		$router->get("/clubs/edit/{club_id}", function($club_id){
			$Club = new Club;
			$getClub = $Club->getClubById($club_id);

			if($getClub->rowCount() == 0){
				header("Location: /admin/clubs");
				exit;
			}

			$club = $getClub->fetchObject();

			require "views/admin/clubs-edit.php";
		});

		$router->post("/clubs/edit/{club_id}", function($club_id){
			if(empty($_POST["club_id"])){
				die(json_encode(["res" => "Por favor, atualize a página e tente novamente!"]));
			}else if(empty($_POST["club_title"]) OR empty(trim($_POST["club_title"]))){
				die(json_encode(["res" => "Por favor, informe um título para o clube."]));
			}else if(empty($_POST["club_description"])){
				die(json_encode(["res" => "Por favor, informe o conteúdo do clube."]));
			}else{
				if(isset($_FILES["club_image"]) AND !empty($_FILES["club_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["club_image"]["name"], 10, "jpeg,jpg,png", "club_image", 1);
					$Upin->run();

					if($Upin->res === true) $club_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem válida."]));
				}else{
					$club_image = $_POST["club_actual_image"];
				}

				$Club = new Club;

				if($Club->update($_POST["club_id"], $_POST["club_title"], $_POST["club_description"], $club_image, 1))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res"=>"Desculpe, não foi possivel atualizar este clube. Atualize a página e tente novamente!"]));
			}
		});


		# /events
		$router->get("/events", function(){
			require "views/admin/events.php";
		});
		$router->get("/events/new", function(){
			require "views/admin/events-new.php";
		});
		$router->post("/events/new", function(){

			if (empty($_POST["event_title"])){
			    die(json_encode(["res" => "Por favor, informe um título para o evento."]));
			}else if (empty($_POST["event_excerpt"])){
			    die(json_encode(["res" => "Por favor, informe um resumo para o evento."]));
			}else if (empty($_POST["event_content"])){
			    die(json_encode(["res" => "Por favor, informe o conteúdo do evento."]));
			}else if (empty($_FILES["event_poster"]["name"])){
			    die(json_encode(["res" => "Por favor, envie uma imagem em destaque para o evento."]));
			}else if (empty($_POST["event_datetime"])){
			    die(json_encode(["res" => "Por favor, informe a data e hora do evento."]));
			}else{
				if(isset($_FILES["event_poster"]) AND !empty($_FILES["event_poster"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["event_poster"]["name"], 10, "jpeg,jpg,png", "event_poster", 1);
					$Upin->run();

					if($Upin->res === true) $event_poster = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem válida."]));
				}else{
					die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
				}


				$Event = new Event;
				if($Event->create(
					$_POST["event_title"],
					$_POST["event_excerpt"],
					DateTime::createFromFormat('d/m/Y H:i', $_POST["event_datetime"])->format('Y-m-d H:i'),
					$event_poster,
					$_POST["event_content"],
					$_SESSION["csa_email"]
				))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, não foi possível cadastrar o evento."]));


			}

		});

		$router->get("/events/edit/{idevent}", function($idevent){
			$Event = new Event;
			$getEvent = $Event->getEventById($idevent);

			if($getEvent->rowCount() == 0){
				header("Location: /admin/events");
				exit;
			}

			$event = $getEvent->fetchObject();

			require "views/admin/events-edit.php";
		});
		$router->post("/events/edit/{idevent}", function($idevent){
			if(empty($idevent)){
				die(json_encode(["res" => "Desculpe, não foi possível encontrar o evento. Atualize a página e tente novamente!"]));
			}else if (empty($_POST["event_title"])){
			    die(json_encode(["res" => "Por favor, informe um título para o evento."]));
			}else if (empty($_POST["event_excerpt"])){
			    die(json_encode(["res" => "Por favor, informe um resumo para o evento."]));
			}else if (empty($_POST["event_content"])){
			    die(json_encode(["res" => "Por favor, informe o conteúdo do evento."]));
			}else if (empty($_POST["event_datetime"])){
			    die(json_encode(["res" => "Por favor, informe a data e hora do evento."]));
			}else{
				if(isset($_FILES["event_poster"]) AND !empty($_FILES["event_poster"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["event_poster"]["name"], 10, "jpeg,jpg,png", "event_poster", 1);
					$Upin->run();

					if($Upin->res === true) $event_poster = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem válida."]));
				}else{
					if(empty($_POST["event_poster_actual"]))
						die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
					else
						$event_poster = $_POST["event_poster_actual"];
				}

				$Event = new Event;

				if($Event->update(
					$idevent,
					$_POST["event_title"],
					$_POST["event_excerpt"],
					DateTime::createFromFormat('d/m/Y H:i', $_POST["event_datetime"])->format('Y-m-d H:i'),
					$event_poster,
					$_POST["event_content"]
				))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, não foi possível atualizar este evento. Atualize a página e tente novamente!"]));

			}

		});



		$router->get("/notices", function(){
			require "views/admin/notices.php";
		});

		$router->get("/notices/new", function(){
			require "views/admin/notices-new.php";
		});
		$router->post("/notices/new", function(){
			if(empty($_POST["notice_title"])){
				die(json_encode(["res"=>"Por favor, informe o título do aviso!"]));
			}else if(empty($_POST["notice_content"])){
				die(json_encode(["res"=>"Por favor, informe o conteúdo do aviso!"]));
			}else{
				$User = new User;
				if(($User->isUserAuthenticated()) == false)
					die(json_encode(["res"=>"Oops, parece que você não tem permissão para isso!"]));


				$Notice = new Notice;
				if($Notice->create($_POST["notice_title"], $_POST["notice_content"], $_SESSION["csa_email"]))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Não foi possível criar este aviso. Atualize a página e tente novamente!"]));
			}
		});


		$router->get("/notices/edit/{notice_id}", function($notice_id){
			$Notice = new Notice;
			$getNotice = $Notice->getNoticeById($notice_id);

			if($getNotice->rowCount() == 0){
				header("Location: /admin/notices");
				exit;
			}

			$notice = $getNotice->fetchObject();

			require "views/admin/notices-edit.php";
		});



		$router->get("/members", function(){
			require "views/admin/members.php";
		});

		$router->get("/members/new", function(){
			require "views/admin/members-new.php";
		});
		$router->post("/members/new", function(){
			if(empty($_POST["member_name"])){
				die(json_encode(["res"=>"Por favor, informe seu nome!"]));
			}else if(empty($_POST["member_lastname"])){
				die(json_encode(["res"=>"Por favor, informe seu sobrenome."]));
			}else if(empty($_POST["member_cpf"])){
				die(json_encode(["res"=>"Por favor, informe seu C.P.F."]));
			}else if(empty($_POST["member_birthdate"])){
				die(json_encode(["res"=>"Por favor, informe sua data de nascimento."]));
			}else if(empty($_POST["member_zipcode"])){
				die(json_encode(["res"=>"Por favor, informe um CEP válido."]));
			}else if(empty($_POST["member_state"])){
				die(json_encode(["res"=>"Por favor, informe o seu estado."]));
			}else if(empty($_POST["member_city"])){
				die(json_encode(["res"=>"Por favor, informe sua cidade."]));
			}else if(empty($_POST["member_address"])){
				die(json_encode(["res"=>"Por favor, informe seu endereço."]));
			}else if(empty($_POST["member_neighborhood"])){
				die(json_encode(["res"=>"Por favor, informe o seu bairro."]));
			}else if(empty($_POST["member_cellphone"])){
				die(json_encode(["res"=>"Por favor, informe seu celular."]));
			}else if(empty($_POST["member_email"])){
				die(json_encode(["res"=>"Por favor, informe o seu e-mail."]));
			}else if(empty($_POST["member_password"])){
				die(json_encode(["res"=>"Por favor, informe uma senha."]));
			}else{
				if(isset($_FILES["member_photo"]) AND !empty($_FILES["member_photo"]["name"])){
					$imageFolder = "uploads/".date("Y\/m\/");
					if (!is_dir($imageFolder)) {
					    mkdir($imageFolder, 0755, true);
					}

					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["member_photo"]["name"], 10, "jpeg,jpg,png", "member_photo", 1);
					$Upin->run();

					if($Upin->res === true) $member_photo = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma foto de perfil válida."]));
				}



				$User = new User;
				// if($User->getUserByEmail($_POST["f_email"])->rowCount() > 0)
				// 	die(json_encode(["res"=>"O e-mail informado já foi utilizado. Informe um novo e-mail para continuar!", $_SESSION]));

				// if($User->getUserByCPF($_POST["f_cpf"])->rowCount() > 0)
				// 	die(json_encode(["res"=>"O CPF informado já foi utilizado. Informe um novo CPF para continuar!"]));

				// if($User->getUserByCNPJ($_POST["f_cnpj"])->rowCount() > 0)
				// 	die(json_encode(["res"=>"O CNPJ informado já foi utilizado. Informe um novo CNPJ para continuar!"]));

				// if($User->getUserByCellphone($_POST["f_cellphone"])->rowCount() > 0)
				// 	die(json_encode(["res"=>"O Celular informado já foi utilizado. Informe um novo Celular para continuar!"]));

				if($User->create(
					(isset($_POST["member_name"])) ? $_POST["member_name"] : null,
					(isset($_POST["member_lastname"])) ? $_POST["member_lastname"] : null,
					(isset($_POST["member_cpf"])) ? $_POST["member_cpf"] : null,
					(isset($_POST["member_birthdate"])) ? $_POST["member_birthdate"] : null,
					(isset($_POST["member_zipcode"])) ? $_POST["member_zipcode"] : null,
					(isset($_POST["member_state"])) ? $_POST["member_state"] : null,
					(isset($_POST["member_city"])) ? $_POST["member_city"] : null,
					(isset($_POST["member_address"])) ? $_POST["member_address"] : null,
					(isset($_POST["member_address_number"])) ? $_POST["member_address_number"] : null,
					(isset($_POST["member_neighborhood"])) ? $_POST["member_neighborhood"] : null,
					(isset($_POST["member_complement"])) ? $_POST["member_complement"] : null,
					(isset($_POST["member_cellphone"])) ? $_POST["member_cellphone"] : null,
					(isset($_POST["member_email"])) ? $_POST["member_email"] : null,
					(isset($_POST["member_password"])) ? $_POST["member_password"] : null,
					0
				))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, algo deu errado ao criar o usuário."]));
			}
		});

		$router->get("/members/edit/{user_id}", function($user_id){
			$User = new User;
			$getUser = $User->getUserById($user_id);

			if($getUser->rowCount() == 0){
				header("Location: /admin/members");
				exit;
			}

			$user = $getUser->fetchObject();


			require "views/admin/members-edit.php";
		});

		$router->post("/members/edit/{user_id}", function($user_id){
			if(empty($user_id)){
				die(json_encode(["res" => "Desculpe, não foi possível encontrar o usuário. Atualize a página!"]));
			}else if(empty($_POST["member_name"])){
				die(json_encode(["res"=>"Por favor, informe seu nome!"]));
			}else if(empty($_POST["member_lastname"])){
				die(json_encode(["res"=>"Por favor, informe seu sobrenome."]));
			}
			// else if(empty($_POST["member_cpf"])){
			// 	die(json_encode(["res"=>"Por favor, informe seu C.P.F."]));
			// }
			else if(empty($_POST["member_birthdate"])){
				die(json_encode(["res"=>"Por favor, informe sua data de nascimento."]));
			}else if(empty($_POST["member_zipcode"])){
				die(json_encode(["res"=>"Por favor, informe um CEP válido."]));
			}else if(empty($_POST["member_state"])){
				die(json_encode(["res"=>"Por favor, informe o seu estado."]));
			}else if(empty($_POST["member_city"])){
				die(json_encode(["res"=>"Por favor, informe sua cidade."]));
			}else if(empty($_POST["member_address"])){
				die(json_encode(["res"=>"Por favor, informe seu endereço."]));
			}else if(empty($_POST["member_neighborhood"])){
				die(json_encode(["res"=>"Por favor, informe o seu bairro."]));
			}else if(empty($_POST["member_cellphone"])){
				die(json_encode(["res"=>"Por favor, informe seu celular."]));
			}else{
				if(isset($_FILES["member_photo"]) AND !empty($_FILES["member_photo"]["name"])){
					$imageFolder = "uploads/".date("Y\/m\/");
					if (!is_dir($imageFolder)) {
					    mkdir($imageFolder, 0755, true);
					}

					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["member_photo"]["name"], 10, "jpeg,jpg,png", "member_photo", 1);
					$Upin->run();

					if($Upin->res === true) $member_photo = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma foto de perfil válida."]));
				}



				$User = new User;

				if($User->update(
					(isset($_POST["member_name"])) ? $_POST["member_name"] : null,
					(isset($_POST["member_lastname"])) ? $_POST["member_lastname"] : null,
					(isset($member_photo)) ? $member_photo : null,
					(isset($_POST["member_biography"])) ? $_POST["member_biography"] : null,
					(isset($_POST["member_cpf"])) ? $_POST["member_cpf"] : null,
					(isset($_POST["member_birthdate"])) ? $_POST["member_birthdate"] : null,
					(isset($_POST["member_zipcode"])) ? $_POST["member_zipcode"] : null,
					(isset($_POST["member_state"])) ? $_POST["member_state"] : null,
					(isset($_POST["member_city"])) ? $_POST["member_city"] : null,
					(isset($_POST["member_address"])) ? $_POST["member_address"] : null,
					(isset($_POST["member_address_number"])) ? $_POST["member_address_number"] : null,
					(isset($_POST["member_neighborhood"])) ? $_POST["member_neighborhood"] : null,
					(isset($_POST["member_complement"])) ? $_POST["member_complement"] : null,
					(isset($_POST["member_cellphone"])) ? $_POST["member_cellphone"] : null,
					$user_id
				))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, algo deu errado ao atualizar o usuário."]));
			}
		});




		$router->get("/companies", function(){
			require "views/admin/companies.php";
		});
		$router->get("/companies/new", function(){
			require "views/admin/companies-new.php";
		});
		$router->post("/companies/new", function(){
		    if(empty($_POST["company_owner"])){
		    	die(json_encode(["res" => "Por favor, selecione um usuário."]));
		    }else if (empty($_POST["company_name"])) {
		        die(json_encode(["res" => "Por favor, informe o nome da empresa!"]));
		    }else if (empty($_POST["company_description"])) {
		        die(json_encode(["res" => "Por favor, informe a descrição da empresa!"]));
		    }else if (empty($_FILES["company_image"]["name"])) {
		        die(json_encode(["res" => "Por favor, envie uma imagem para a empresa!"]));
		    }else if (empty($_POST["cellphone"])) {
		        die(json_encode(["res" => "Por favor, informe o celular!"]));
		    }else if (isset($_POST["has_place"]) && $_POST["has_place"] == 'on') {
		        if (empty($_POST["address_zipcode"])) {
		            die(json_encode(["res" => "Por favor, informe o CEP!"]));
		        }else if (empty($_POST["address_state"])) {
		            die(json_encode(["res" => "Por favor, informe o estado!"]));
		        }else if (empty($_POST["address_city"])) {
		            die(json_encode(["res" => "Por favor, informe a cidade!"]));
		        }else if (empty($_POST["address"])) {
		            die(json_encode(["res" => "Por favor, informe o endereço!"]));
		        }else if (empty($_POST["address_number"])) {
		            die(json_encode(["res" => "Por favor, informe o número do endereço!"]));
		        }
		    }else if (!empty($_POST["instagram_url"]) && !filter_var($_POST["instagram_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o Instagram!"]));
		    }
		    else if (!empty($_POST["site_url"]) && !filter_var($_POST["site_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o site!"]));
		    }
		    else if (!empty($_POST["facebook_url"]) && !filter_var($_POST["facebook_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o Facebook!"]));
		    }else{

		    	if(isset($_FILES["company_image"]) AND !empty($_FILES["company_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["company_image"]["name"], 10, "jpeg,jpg,png", "company_image", 1);
					$Upin->run();

					if($Upin->res === true) $company_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
				}

		    	$Company = new Company;

		    	if($Company->create(
		    		$_POST["company_owner"],
				    $_POST["company_name"],
				    $_POST["company_description"],
				    $company_image,
				    ($_POST["has_place"]) ?? null,
				    ($_POST["address_zipcode"]) ?? null,
				    ($_POST["address_state"]) ?? null,
				    ($_POST["address_city"]) ?? $_POST["address_city"],
				    ($_POST["address"]) ?? $_POST["address"],
				    ($_POST["address_number"]) ?? $_POST["address_number"],
				    ($_POST["address_neighborhood"]) ?? $_POST["address_neighborhood"],
				    ($_POST["address_complement"]) ?? $_POST["address_complement"],
				    ($_POST["cellphone"]) ?? $_POST["cellphone"],
				    ($_POST["instagram_url"]) ?? $_POST["instagram_url"],
				    ($_POST["site_url"]) ?? $_POST["site_url"],
				    ($_POST["facebook_url"]) ?? $_POST["facebook_url"],
				    1
		    	))
		    		die(json_encode(["res" => 1]));
		    	else
		    		die(json_encode(["res" => "Desculpe, algo deu errado ao tentar criar a empresa. Atualize a página e tente novamente!"]));


		    }
		});


		$router->get("/companies/edit/{company_id}", function($company_id){
			$Company = new Company;
			$getCompany = $Company->getCompanyById($company_id);

			if($getCompany->rowCount() == 0){
				header("Location: /admin/companies");
				exit;
			}

			$company = $getCompany->fetchObject();

			require "views/admin/companies-edit.php";
		});
		$router->post("/companies/edit/{company_id}", function($company_id){
			if(empty($_POST["company_id"])){
				die(json_encode(["res" => "Desculpe, não foi possível identificar a empresa. Atualize a página e tente novamente!"]));
			}else if(empty($_POST["company_owner"])){
		    	die(json_encode(["res" => "Por favor, selecione um usuário."]));
		    }else if (empty($_POST["company_name"])) {
		        die(json_encode(["res" => "Por favor, informe o nome da empresa!"]));
		    }else if (empty($_POST["company_description"])) {
		        die(json_encode(["res" => "Por favor, informe a descrição da empresa!"]));
		    }else if (empty($_POST["cellphone"])) {
		        die(json_encode(["res" => "Por favor, informe o celular!"]));
		    }else if (isset($_POST["has_place"]) && $_POST["has_place"] == 'on') {
		        if (empty($_POST["address_zipcode"])) {
		            die(json_encode(["res" => "Por favor, informe o CEP!"]));
		        }else if (empty($_POST["address_state"])) {
		            die(json_encode(["res" => "Por favor, informe o estado!"]));
		        }else if (empty($_POST["address_city"])) {
		            die(json_encode(["res" => "Por favor, informe a cidade!"]));
		        }else if (empty($_POST["address"])) {
		            die(json_encode(["res" => "Por favor, informe o endereço!"]));
		        }else if (empty($_POST["address_number"])) {
		            die(json_encode(["res" => "Por favor, informe o número do endereço!"]));
		        }
		    }else if (!empty($_POST["instagram_url"]) && !filter_var($_POST["instagram_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o Instagram!"]));
		    }
		    else if (!empty($_POST["site_url"]) && !filter_var($_POST["site_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o site!"]));
		    }
		    else if (!empty($_POST["facebook_url"]) && !filter_var($_POST["facebook_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o Facebook!"]));
		    }else{

		    	if(isset($_FILES["company_image"]) AND !empty($_FILES["company_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["company_image"]["name"], 10, "jpeg,jpg,png", "company_image", 1);
					$Upin->run();

					if($Upin->res === true) $company_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					if(empty($_POST["actual_company_image"]))
						die(json_encode(["res" => "Algo deu errado com a imagem da empresa. Atualize a página e tente novamente!"]));
					else
						$company_image = $_POST["actual_company_image"];
				}

		    	$Company = new Company;


		    	if($Company->update(
		    		$_POST["company_id"],
		    		$_POST["company_owner"],
				    $_POST["company_name"],
				    $_POST["company_description"],
				    $company_image,
				    ($_POST["has_place"]) ?? null,
				    ($_POST["address_zipcode"]) ?? null,
				    ($_POST["address_state"]) ?? null,
				    ($_POST["address_city"]) ?? $_POST["address_city"],
				    ($_POST["address"]) ?? $_POST["address"],
				    ($_POST["address_number"]) ?? $_POST["address_number"],
				    ($_POST["address_neighborhood"]) ?? $_POST["address_neighborhood"],
				    ($_POST["address_complement"]) ?? $_POST["address_complement"],
				    ($_POST["cellphone"]) ?? $_POST["cellphone"],
				    ($_POST["instagram_url"]) ?? $_POST["instagram_url"],
				    ($_POST["site_url"]) ?? $_POST["site_url"],
				    ($_POST["facebook_url"]) ?? $_POST["facebook_url"],
				    1
		    	))
		    		die(json_encode(["res" => 1]));
		    	else
		    		die(json_encode(["res" => "Desculpe, algo deu errado ao tentar criar a empresa. Atualize a página e tente novamente!"]));


		    }
		});


		#/admin/publis
		$router->get("/publis", function(){
			require "views/admin/publis.php";
		});

		$router->get("/publis/new", function(){
			require "views/admin/publis-new.php";
		});

		$router->post("/publis/new", function(){
			if(empty($_POST["publi_title"])){
				die(json_encode(["res" => "Por favor, informe um título para sua publi."]));
			}else if(empty($_POST["publi_content"])){
				die(json_encode(["res" => "Por favor, informe um conteúdo para sua publi."]));
			}else if(empty($_POST["publi_creator"])){
				die(json_encode(["res" => "Por favor, selecione uma dona para esta publi."]));
			}else{

				$Publi = new Publi;

				if($Publi->create(
					$_POST["publi_title"],
					$_POST["publi_content"],
					1,
					$_POST["publi_creator"])){
					die(json_encode(["res" => 1]));
				}
				else{
					die(json_encode(["res" => "Desculpe, não foi possível criar a sua Publi. Verifique os dados e tente novamente!"]));
				}

			}
		});

		$router->get("/publis/edit/{publi_id}", function($publi_id){
			$Publi = new Publi;
			$getPubli = $Publi->getPubliById($publi_id);

			if($getPubli->rowCount() == 0){
				header("Location: /app/publis");
				exit();
			}

			$publi = $getPubli->fetchObject();


			require "views/admin/publis-edit.php";
		});
		$router->post("/publis/edit/{publi_id}", function($publi_id){
			if(empty($_POST["publi_creator"])){
				die(json_encode(["res" => "Por favor, selecione um criador para a publi."]));
			}else if(empty(trim($_POST["publi_title"]))){
				die(json_encode(["res" => "Por favor, informe o título da publi."]));
			}else if(empty(trim($_POST["publi_content"]))){
				die(json_encode(["res" => "Por favor, informe um conteúdo para a publi."]));
			}else{
				$Publi = new Publi;

				if($Publi->update($publi_id, $_POST["publi_title"], $_POST["publi_content"], $_POST["publi_creator"]))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, não foi possível atualizar a publi."]));
			}
		});
	});


	$router->post("/upload/image", function(){
  		// $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://example.com");

		$imageFolder = "uploads/".date("Y\/m\/");
		if (!is_dir($imageFolder)) {
		    mkdir($imageFolder, 0755, true);
		}

  		reset ($_FILES);
  		$temp = current($_FILES);
  		if (is_uploaded_file($temp['tmp_name'])){

		    // Sanitize input
		    // if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
		    //     header("HTTP/1.1 400 Invalid file name.");
		    //     return;
		    // }

		    // Verify extension
		    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png", "jpeg"))) {
		        header("HTTP/1.1 400 Invalid extension.");
		        return;
		    }

		    // Accept upload if there was no origin, or if it is an accepted origin
		    $filetowrite = $imageFolder . uniqid().".".pathinfo($temp['name'], PATHINFO_EXTENSION);
		    move_uploaded_file($temp['tmp_name'], $filetowrite);

		    // Determine the base URL
		    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
		    $baseurl = $protocol . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER['REQUEST_URI']), "/") . "/";

		    // Respond to the successful upload with JSON.
		    // Use a location key to specify the path to the saved image resource.
		    // { location : '/your/uploaded/image/file'}
		    echo json_encode(array('location' => $filetowrite));
		  } else {
		    // Notify editor that the upload failed
		    header("HTTP/1.1 500 Server Error");
		  }
	});