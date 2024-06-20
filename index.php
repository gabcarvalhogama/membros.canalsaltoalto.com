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


	});

	$router->run();