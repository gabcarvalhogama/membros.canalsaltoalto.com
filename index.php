<?php
	require_once "application/autoload.php";

	define("PATH", "http://canalsaltoalto.local/");

	if (session_status() == PHP_SESSION_NONE) session_start();


	// Instance Router
	$router = new \Bramus\Router\Router();


	$router->get("/", function(){
		require "views/site/home.php";
	});

	$router->get("/seja-membro", function(){
		require "views/site/seja-membro.php";
	});

	$router->get("/noticias", function(){
		require "views/site/noticias.php";
	});

	$router->get("/quem-somos", function(){
		require "views/site/quem-somos.php";
	});


	$router->get("/post/{slug}", function($post_slug){
		$Post = new Post;

		$post = $Post->getPostBySlug($post_slug);
		if($post->rowCount() == 0) header("404");

		$object = $post->fetchObject();


		require "views/site/single-post.php";
	});




	$router->post("/post/comment", function(){
		if(empty($_POST["post_id"])){
			die(json_encode(["res"=>"Algo deu errado ao postar o seu comentário, atualize a página e tente novamente."]));
		}else if(empty($_POST["name"])){
			die(json_encode(["res"=>"Por favor, informe o seu nome para publicar um comentário."]));
		}else if(empty($_POST["email"])){
			die(json_encode(["res"=>"Por favor, informe o seu e-mail para publicar um comentário."]));
		}else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
			die(json_encode(["res"=>"O e-mail informado é inválido. Informe um novo e-mail e tente novamente!"]));
		}else if(empty($_POST["comment"])){
			die(json_encode(["res"=>"Por favor, informe o comentário que deseja realizar."]));
		}else{
			$Post = new Post;

			if($Post->addComment($_POST["post_id"], $_POST["name"], $_POST["email"], $_POST["comment"], 0, $_SERVER['REMOTE_ADDR'])){
				die(json_encode(["res"=>1]));
			}else{
				die(json_encode(["res"=>"Algo deu errado ao postar o seu comentário, atualize a página e tente novamente."]));
			}
		}
	});


	// Checkout
	$router->get("/checkout", function(){
		require "views/site/checkout.php";
	});

	$router->get("/checkout/cities/{uf}", function($uf){
		if(empty($uf)){
			die(json_encode(["res" => "Algo deu errado ao obter as cidades. Atualize a página e tente novamente."]));
		}else{
			$cities = User::getCitiesByUf($uf);

			if($cities->rowCount() > 0){
				die(json_encode(["res" => 1, "cities" => $cities->fetchAll(PDO::FETCH_ASSOC)]));
			}else{
				die(json_encode(["res" => "Algo deu errado ao obter as cidades. Atualize a página e tente novamente."]));
			}
		}
	});


	$router->post("/checkout", function(){
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
		}else if(empty($_POST["f_email"])){
			die(json_encode(["res"=>"Por favor, informe o seu e-mail.", "step" => "enterpreneur"]));
		}else if(empty($_POST["f_password"])){
			die(json_encode(["res"=>"Por favor, informe uma senha.", "step" => "enterpreneur"]));
		}else if(empty($_POST["f_rpassword"])){
			die(json_encode(["res"=>"Por favor, repita sua senha.", "step" => "enterpreneur"]));
		}else if($_POST["f_password"] != $_POST["f_rpassword"]){
			die(json_encode(["res"=>"As senhas digitadas não combinam.", "step" => "enterpreneur"]));
		}else if(empty($_POST["f_cnpj"])){
			die(json_encode(["res"=>"Por favor, informe seu CNPJ para se tornar membro.", "step" => "company"]));
		}else if(!User::validateCNPJ($_POST["f_cnpj"])){
			die(json_encode(["res"=>"Por favor, informe um CNPJ válido para se tornar membro.", "step" => "company"]));
		}else if(empty($_POST["f_payment_method"])){
			die(json_encode(["res"=>"Por favor, selecione uma forma de pagamento válida.", "step" => "payment"]));
		}else{
			if($_POST["f_payment_method"] == "cc"){
				if(empty($_POST["f_cc_number"])){
					die(json_encode(["res"=>"Por favor, informe os números do Cartão de Crédito.", "step" => "payment"]));
				}else if(empty($_POST["f_cc_name"])){
					die(json_encode(["res"=>"Por favor, informe o Nome Completo que está no Cartão de Crédito.", "step" => "payment"]));
				}else if(empty($_POST["f_cc_expirationdate"])){
					die(json_encode(["res"=>"Por favor, informe a data de expiração do Cartão de Crédito.", "step" => "payment"]));
				}else if(!(DateTime::createFromFormat('m/y', $_POST["f_cc_expirationdate"]) && DateTime::createFromFormat('m/y', $_POST["f_cc_expirationdate"])->format('m/y') === $_POST["f_cc_expirationdate"] && DateTime::createFromFormat('m/y', $_POST["f_cc_expirationdate"]) > new DateTime('last day of previous month'))){
					die(json_encode(["res"=>"Por favor, verifique a data de validade do Cartão de Crédito.", "step" => "payment"]));
				}else if(empty($_POST["f_cc_cvv"])){
					die(json_encode(["res"=>"Por favor, informe o CVV do Cartão de Crédito.", "step" => "payment"]));
				}
			}


			$User = new User;
			if($User->getUserByEmail($_POST["f_email"])->rowCount() > 0)
				die(json_encode(["res"=>"O e-mail informado já foi utilizado. Informe um novo e-mail para continuar!", "step" => "enterpreneur"]));



			$isUserCreated =  $User->create(
				$_POST["f_firstname"],
				$_POST["f_lastname"],
				$_POST["f_cpf"],
				$_POST["f_birthdate"],
				$_POST["f_zipcode"],
				$_POST["f_state"],
				$_POST["f_city"],
				$_POST["f_address"],
				$_POST["f_address_number"],
				$_POST["f_neighborhood"],
				$_POST["f_complement"],
				$_POST["f_cellphone"],
				$_POST["f_email"],
				$_POST["f_password"],
				0
			);

			if(!$isUserCreated)
				die(json_encode(["res"=>"Algo deu errado ao criar o seu usuário. Atualize a página e tente novamente!", "step" => "enterpreneur"]));

			$user_id = $User->getUserIdByEmail($_POST["f_email"]);



			if($_POST["f_payment_method"] == "pix"){
				$pagarme = new PagarMe\Client('sk_33ca088d2f0643229336a8045280a2b8');
				$transaction = $pagarme->transactions()->create([
					'amount' => 10,
				    'payment_method' => 'Pix',
				    'customer' => [
				        'external_id' => $user_id,
				        'name' => $_POST["f_firstname"]." ".$_POST["f_lastname"],
				        'type' => 'individual',
				        'country' => 'br',
				        'documents' => [
				          [
				            'type' => 'cpf',
				            'number' => $_POST["f_cpf"]
				          ]
				        ],
				        'phone_numbers' => [ '+55'.preg_replace('/\D/', '', $_POST["f_cellphone"]) ],
				        'email' => $_POST["f_email"]
				    ],
				    'items' => [
				        [
				          'id' => '1',
				          'title' => 'Seja Membro',
				          'unit_price' => 300,
				          'quantity' => 1,
				          'tangible' => true
				        ]
				    ]
				]);
			}

		}
	});






	$router->mount("/app", function() use($router){

		$router->get("/", function() {
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


		$router->get("/content/{slug}", function($content_slug){
			$Content = new Content;

			$content = $Content->getContentBySlug($content_slug);
			if($content->rowCount() == 0) header("404");

			$object = $content->fetchObject();

			require "views/app/single-content.php";
		});


		$router->get("/notices", function(){
			require "views/app/notices.php";
		});
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
				    ($_POST["facebook_url"]) ?? $_POST["facebook_url"]
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
	});


	$router->post("/upload/image", function(){
  		// $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://example.com");

		$imageFolder = "uploads/".date("Y\/m\/");

  		reset ($_FILES);
  		$temp = current($_FILES);
  		if (is_uploaded_file($temp['tmp_name'])){

		    // Sanitize input
		    // if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
		    //     header("HTTP/1.1 400 Invalid file name.");
		    //     return;
		    // }

		    // Verify extension
		    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
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

	$router->run();