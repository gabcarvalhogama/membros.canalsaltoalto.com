<?php
	$router->before('GET', '/app(?!/(login|recover)$).*', function(){
		$User = new User;
		if(
			(
				($User->isUserAuthenticated()) == false 
				OR 
				$User->isUserAMember(
					(isset($_SESSION["csa_email"]) ? $_SESSION["csa_email"] : null)
				) == 0
			) 

			AND (
				$User->isUserAdminByEmail((isset($_SESSION["csa_email"]) ? $_SESSION["csa_email"] : null)) == false)
		){
			session_destroy();
			die(header("Location: /app/login"));

		}
	});
	$router->mount("/app", function() use($router){

		

		$router->get("/", function() {
			// if(USER->)
			// var_dump(USER);
			if(intval(USER->company_counter) == 0 AND USER->user_type != 1)
				header("Location: /app/welcome/new-company");

			require_once "views/app/index.php";
		});


		$router->get("/login", function(){
			require_once "views/app/login.php";
		});
		$router->post("/login", function(){
			if(empty($_POST["login_email"])){
				die(json_encode(["res" => "Por favor, informe seu e-mail para acesso."]));
			}else if(empty($_POST["login_password"])){
				die(json_encode(["res" => "Por favor, informe sua senha para acesso."]));
			}else{
				$User = new User;
				if($User->login($_POST["login_email"], $_POST["login_password"])){
					$_SESSION["csa_email"] = $_POST["login_email"];
					$_SESSION["csa_password"] = $_POST["login_password"];

					die(json_encode(["res"=>1]));
				}else{
					die(json_encode(["res"=>"O e-mail ou senha estão incorretos. Verifique os dados e tente novamente!"]));
				}
			}
		});


		$router->get("/recover", function(){
			require_once "views/app/recover.php";
		});

		$router->post("/recover", function(){
			if(empty($_POST["recover_email"])){
				die(json_encode(["res" => "Por favor, informe o e-mail para recuperação do acesso."]));
			}else{
				$User = new User;
				$user = $User->getUserByEmail($_POST["recover_email"]);
				if($user->rowCount() == 0)
					die(json_encode(["res" => "Desculpe, não foi possível encontrar este e-mail."]));
				

				$userData = $user->fetchObject();
				$token = bin2hex(random_bytes(16));
				if($User->createPasswordReset($userData->iduser, $token)){

					$Comunications = new Comunications;

					$email_title = "Recupere o seu Acesso - Canal Salto Alto";
					$content = "<div>
						<h1>Recupere o seu acesso à Comunidade Canal Salto Alto</h1>
						<p>Olá, recebemos a sua solicitação para recuperação de senha. Para prosseguir com a redefinição da sua senha, clique no botão a seguir:</p>
						<a href='https://canalsaltoalto.com/app/recover/?token=$token'>QUERO REDEFINIR MINHA SENHA</a>
					</div>";
					$email_content = Template::render([
						"email_title" => $email_title,
						"email_content" => $content 
					], "email_general");



 					$Comunications->sendEmail($userData->email, $email_title, $email_content);

					die(json_encode(["res" => 1]));
				}else{
					die(json_encode(["res" => "Desculpe, não foi possível recuperar a sua senha. Entre em contato com nossa equipe de suporte."]));
				}

			}
		});

		$router->post("/recover/updatepwd", function(){
			if(empty($_POST["recovery_token"])){
				die(json_encode(["res" => "Desculpe, não foi possível identificar o token de recuperação."]));
			}else if(empty($_POST["recover_password"])){
				die(json_encode(["res" => "Por favor, informe a nova senha."]));
			}else if(empty($_POST["recover_confirmation_password"])){
				die(json_encode(["res" => "Por favor, confirme a sua nova senha."]));
			}else if(strlen($_POST["recover_password"]) < 8){
				die(json_encode(["res" => "Por favor, informe uma senha com no mínimo 8 caracteres."]));
			}else if($_POST["recover_password"] != $_POST["recover_confirmation_password"]){
				die(json_encode(["res" => "As senhas não conferem! Verifique os dados e tente novamente."]));
			}else{
				$User = new User;
				if($User->isTokenValid($_POST["recovery_token"]) != true)
					die(json_encode(["res" => "Desculpe, este token já expirou ou foi usado. Acesse a página de recuperação e tente novamente!"]));


				$getToken = $User->getToken($_POST["recovery_token"])->fetchObject();

				if($User->updatePassword($getToken->user_id, $_POST["recover_password"])){
					$User->updateTokenToUsed($_POST["recovery_token"]);
					die(json_encode(["res" => 1]));
				}else{
					die(json_encode(["res" => "Desculpe, não foi possível alterar a sua senha. Verifique com o suporte da plataforma e tente novamente."]));
				}
			}
		});


		// $User = new User;
		
		
		$router->get("/welcome", function(){

			require_once "views/app/welcome.php";
		});

		
		$router->get("/welcome/new-company", function(){

			require_once "views/app/welcome-new-company.php";
		});
		
		$router->get("/welcome/success", function(){

			require_once "views/app/welcome-success.php";
		});


		$router->get("/contents", function(){
			$Content = new Content;
			$total_contents = $Content->getContentsTotalNumber();
			
			$contents = $Content->getContentsWithPagination(12, 0);


			require "views/app/contents.php";
		});
		$router->get("/content/{slug}", function($content_slug){

			$Content = new Content;

			$content = $Content->getContentBySlug($content_slug);
			if($content->rowCount() == 0) header("404");

			$object = $content->fetchObject();

			require "views/app/single-content.php";
		});

		$router->get("/contents/page/{page_number}", function($page_number){
			if((int) $page_number < 1)
				header("Location: /app/contents");

			$Content = new Content;
			
			$total_contents = $Content->getContentsTotalNumber();

			$contents = $Content->getContentsWithPagination(12, (($page_number - 1) * 12));


			require "views/app/contents.php";
		});


		$router->get("/notices", function(){

			require "views/app/notices.php";
		});


		$router->get("/clubs", function(){

			require "views/app/clubs.php";
		});


		$router->get("/companies", function(){
			require "views/app/companies.php";
		});

		$router->get("/companies/new", function(){
			require "views/app/companies-new.php";
		});
		$router->post("/companies/new", function(){
			if (empty($_POST["company_name"])) {
		        die(json_encode(["res" => "Por favor, informe o nome da empresa!"]));
		    }else if (empty($_POST["company_description"])) {
		        die(json_encode(["res" => "Por favor, informe a descrição da empresa!"]));
		    }else if (empty($_POST["cellphone"])) {
		        die(json_encode(["res" => "Por favor, informe o celular!"]));
		    }else if (!empty($_POST["instagram_url"]) && !filter_var($_POST["instagram_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o Instagram!"]));
		    }
		    else if (!empty($_POST["site_url"]) && !filter_var($_POST["site_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o site!"]));
		    }
		    else if (!empty($_POST["facebook_url"]) && !filter_var($_POST["facebook_url"], FILTER_VALIDATE_URL)) {
		        die(json_encode(["res" => "Por favor, informe uma URL válida para o Facebook!"]));
		    }else{
		    	if (isset($_POST["has_place"]) && $_POST["has_place"] == 'on') {
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
			    }

		    	if(isset($_FILES["company_image"]) AND !empty($_FILES["company_image"]["name"])){
					$Upin = new Upin;

					$imageFolder = "uploads/".date("Y\/m\/");

					if (!file_exists($imageFolder)) mkdir($imageFolder, 0777, true);


					$Upin->get( $imageFolder, $_FILES["company_image"]["name"], 10, "jpeg,jpg,png", "company_image", 1);
					$Upin->run();

					if($Upin->res === true) $company_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					// die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
					$company_image = null;
				}

		    	$Company = new Company;
		    	$User = new User;

		    	if($Company->create(
		    		$User->getUserIdByEmail($_SESSION["csa_email"]),
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
				    2
		    	))
		    		die(json_encode(["res" => 1]));
		    	else
		    		die(json_encode(["res" => "Desculpe, algo deu errado ao tentar criar a empresa. Atualize a página e tente novamente!"]));


		    }
		});



		$router->get("/members", function(){

			require "views/app/members.php";
		});
		$router->get("/members/{user_id}/companies", function($user_id){

			if(empty($user_id) OR $user_id == 0) header("Location: /app/companies");

			$User = new User;
			$getUser = $User->getUserById($user_id);

			if($getUser->rowCount() == 0) header("Location: /app/companies");

			$user = $getUser->fetchObject();

			require "views/app/members-companies.php";
		});

		$router->get("/events", function(){

			$Event = new Event;
			$total_events = $Event->getEventsTotalNumber();
			
			$events = $Event->getEventsWithPagination(12, 0);
			require "views/app/events.php";
		});

		$router->get("/events/page/{page_number}", function($page_number){
			if((int) $page_number < 1)
				header("Location: /app/events");

			$Event = new Event;
			
			$total_events = $Event->getEventsTotalNumber();

			$events = $Event->getEventsWithPagination(12, (($page_number - 1) * 12));
			require "views/app/events.php";
		});

		$router->get("/events/{slug}", function($slug){

			$Event = new Event;
			$getEvent = $Event->getEventBySlug($slug);

			if($getEvent->rowCount() == 0){
				header("Location: /app/events");
				exit();
			}

			$event = $getEvent->fetchObject();
			require "views/app/single-event.php";
		});


		$router->get("/publis", function(){

			require "views/app/publis.php";
		});

		$router->get("/publis/new", function(){

			require "views/app/publis-new.php";
		});

		$router->post("/publis/new", function(){
			// if(empty($_POST["publi_title"])){
			// 	die(json_encode(["res" => "Por favor, informe um título para sua publi."]));
			// }else 

			if(empty($_POST["publi_content"])){
				die(json_encode(["res" => "Por favor, informe um conteúdo para sua publi."]));
			}else{

				if(isset($_FILES["publi_image"]) AND !empty($_FILES["publi_image"]["name"])){
					
					$imageFolder = "uploads/".date("Y\/m\/");

					if (!file_exists($imageFolder)) mkdir($imageFolder, 0777, true);


					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["publi_image"]["name"], 10, "jpeg,jpg,png", "publi_image", 1);
					$Upin->run();

					if($Upin->res === true) $publi_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem válida."]));
				}else{
					$publi_image = null;
				}


				$Publi = new Publi;

				if($Publi->create(
					// $_POST["publi_title"],
					$_POST["publi_content"],
					$publi_image,
					0,
					USER->iduser
				)){
					die(json_encode(["res" => 1]));
				}
				else{
					die(json_encode(["res" => "Desculpe, não foi possível criar a sua Publi. Verifique os dados e tente novamente!"]));
				}

			}
		});

		$router->post("/publis/{publi_id}/comment", function($publi_id){
			if(empty($publi_id)){
				die(json_encode(["res" => "Desculpe, não foi possivel identificar o ID da publi."]));
			}else if(empty($_POST["publi_comment"])){
				die(json_encode(["res" => "Por favor, digite o seu comentário!"]));
			}else{

				$parent_id = (!empty($_POST["parent_id"])) ? intval($_POST["parent_id"]) : null;

				$Publi = new Publi;

				if($Publi->setComment($publi_id, USER->iduser, $_POST["publi_comment"], $parent_id))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, não foi possível postar o seu comentário. Atualize o site e tente novamente!"]));
			}
		});

		$router->post("/publis/{publi_id}/like", function($publi_id) {
		    if (empty($publi_id)) {
		        die(json_encode(["res" => "Desculpe, não foi possível identificar o ID da publicação."]));
		    }

		    $Publi = new Publi;

		    $likeExists = $Publi->getLike($publi_id, USER->iduser)->rowCount() > 0;

		    if ($likeExists) {
		        if ($Publi->deleteLike($publi_id, USER->iduser)) {
		            die(json_encode(["res" => 1, "current" => 0]));
		        } else {
		            die(json_encode(["res" => "Desculpe, não foi possível remover o like."]));
		        }
		    } else {
		        if ($Publi->setLike($publi_id, USER->iduser)) {
		            die(json_encode(["res" => 1, "current" => 1]));
		        } else {
		            die(json_encode(["res" => "Desculpe, não foi possível adicionar o like."]));
		        }
		    }
		});


		$router->get("/profile", function(){
			$User = new User;
			$user = $User->getUserByEmail($_SESSION["csa_email"])->fetchObject();
			require "views/app/profile.php";
		});

		$router->post("/profile/update", function(){
			if(empty($_POST["f_firstname"])){
				die(json_encode(["res"=>"Por favor, informe seu nome!", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_lastname"])){
				die(json_encode(["res"=>"Por favor, informe seu sobrenome.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_cpf"])){
				die(json_encode(["res"=>"Por favor, informe seu C.P.F.", "step" => "enterpreneur"]));
			}else if(!User::validateCPF($_POST["f_cpf"])){
				die(json_encode(["res"=>"Por favor, informe um C.P.F. válido.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_birthdate"])){
				die(json_encode(["res"=>"Por favor, informe sua data de nascimento.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_zipcode"])){
				die(json_encode(["res"=>"Por favor, informe um CEP válido.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_state"])){
				die(json_encode(["res"=>"Por favor, informe o seu estado.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_city"])){
				die(json_encode(["res"=>"Por favor, informe sua cidade.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_address"])){
				die(json_encode(["res"=>"Por favor, informe seu endereço.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_neighborhood"])){
				die(json_encode(["res"=>"Por favor, informe o seu bairro.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_cellphone"])){
				die(json_encode(["res"=>"Por favor, informe seu celular.", "step" => "enterpreneur"]));
			}else{

				$User = new User;
				if($User->update(
					(isset($_POST["f_firstname"])) ? $_POST["f_firstname"] : null,
					(isset($_POST["f_lastname"])) ? $_POST["f_lastname"] : null,
					null,
					(isset($_POST["f_biography"])) ? $_POST["f_biography"] : null,
					(isset($_POST["f_cpf"])) ? $_POST["f_cpf"] : null,
					(isset($_POST["f_birthdate"])) ? $_POST["f_birthdate"] : null,
					(isset($_POST["f_zipcode"])) ? $_POST["f_zipcode"] : null,
					(isset($_POST["f_state"])) ? $_POST["f_state"] : null,
					(isset($_POST["f_city"])) ? $_POST["f_city"] : null,
					(isset($_POST["f_address"])) ? $_POST["f_address"] : null,
					(isset($_POST["f_address_number"])) ? $_POST["f_address_number"] : null,
					(isset($_POST["f_neighborhood"])) ? $_POST["f_neighborhood"] : null,
					(isset($_POST["f_complement"])) ? $_POST["f_complement"] : null,
					(isset($_POST["f_cellphone"])) ? $_POST["f_cellphone"] : null,
					$User->getUserIdByEmail($_SESSION["csa_email"])
				)){
					die(json_encode(["res" => 1]));
				}else{
					die(json_encode(["res" => "Desculpe, não foi possível atualizar as suas informações."]));
				}

			}
		});

		$router->post("/profile/update/photo", function(){
			// $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://example.com");

			$imageFolder = "uploads/".date("Y\/m\/");
			if (!file_exists($imageFolder)) mkdir($imageFolder, 0777, true);

	  		reset ($_FILES);
	  		$temp = current($_FILES);
	  		if (is_uploaded_file($temp['tmp_name'])){
			    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
			        header("HTTP/1.1 400 Invalid extension.");
			        return;
			    }

			    $filetowrite = $imageFolder . uniqid().".".pathinfo($temp['name'], PATHINFO_EXTENSION);
			    if(move_uploaded_file($temp['tmp_name'], $filetowrite)){
			    	$User = new User;
			    	$User->updatePhotoByEmail($_SESSION["csa_email"], $filetowrite);
			    	die(json_encode(array('res' => 1, 'path' => $filetowrite)));
			    }
			    else{
			    	die(json_encode(["res" => "Desculpe, algo deu errado ao salvar sua foto de perfil."]));
			    }

			  } else {
			    // Notify editor that the upload failed
			    header("HTTP/1.1 500 Server Error");
			  }
		});

		$router->get("/profile/companies", function(){
			$User = new User;
			$user = $User->getUserByEmail($_SESSION["csa_email"])->fetchObject();
			require "views/app/profile-companies.php";
		});

		$router->get("/profile/subscriptions", function(){
			require "views/app/profile-subscriptions.php";
		});

		$router->get("/profile/change-password", function(){
			require "views/app/profile-change-password.php";
		});
		$router->post("/profile/change-password", function(){
			if(empty($_POST["new_password"])){
				die(json_encode(["res" => "Por favor, digite a nova senha."]));
			}else if(empty($_POST["r_new_password"])){
				die(json_encode(["res" => "Por favor, repita a nova senha."]));
			}else{
				if(strlen($_POST["new_password"]) < 8)
					die(json_encode(["res" => "Desculpe, a nova senha deve ter no mínimo 8 caracteres."]));

				if($_POST["new_password"] != $_POST["r_new_password"])
					die(json_encode(["res" => "Desculpe, as senhas não conferem. Verifique as senhas e tente novamente!"]));


				$User = new User;

				if($User->updatePassword(USER->iduser, $_POST["new_password"]) == true){
					$_SESSION["csa_password"] = $_POST["new_password"];
					die(json_encode(["res" => 1]));
				}
				else{
					die(json_encode(["res" => "Desculpe, algo deu errado ao atualizar a sua senha. Atualize a página e tente novamente!"]));
				}

			}
		});
	});