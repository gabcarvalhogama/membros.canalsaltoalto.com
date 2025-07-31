<?php 

	use Endroid\QrCode\Color\Color;
	use Endroid\QrCode\Encoding\Encoding;
	use Endroid\QrCode\ErrorCorrectionLevel;
	use Endroid\QrCode\QrCode;
	use Endroid\QrCode\Label\Label;
	use Endroid\QrCode\Logo\Logo;
	use Endroid\QrCode\RoundBlockSizeMode;
	use Endroid\QrCode\Writer\PngWriter;
	use Endroid\QrCode\Writer\ValidationException;
	
	$router->before('GET|POST', '/admin(?!/(login|recover|recover/updatepwd)$).*', function(){
		$User = new User;

		if(
			// (
			// 	($User->isUserAuthenticated()) == false 
			// 	OR
			// 	$User->isUserAMember(
			// 		(isset($_SESSION["csa_email"]) ? $_SESSION["csa_email"] : null)
			// 	) == false
			// ) 

			// OR
			
			
				($User->isUserAuthenticated()) == false OR 
				$User->isUserAdminByEmail((isset($_SESSION["csa_email"]) ? $_SESSION["csa_email"] : null)) == false)
			{
				die(header("Location: /admin/login"));
			}
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

		$router->get("/recover", function(){
			require "views/admin/recover.php";
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
						<h1>Recupere o seu acesso ao painel administrativo do Canal Salto Alto</h1>
						<p>Olá, recebemos a sua solicitação para recuperação de senha. Para prosseguir com a redefinição da sua senha, clique no botão a seguir:</p>
						<a href='https://canalsaltoalto.com/admin/recover/?token=$token'>QUERO REDEFINIR MINHA SENHA</a>
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
					die(json_encode(["res" => "Desculpe, não foi possível alterar a sua senha. Verifique com o suporte da plataforma e tente novamente.", $_POST]));
				}
			}
		});


		#/admin/medias
		$router->mount("/medias", function() use ($router){
			$router->get("/", function(){
				require_once "views/admin/medias.php";
			});

			$router->get("/view/{media_id}", function($media_id){
				$Media = new Media;
				$getMedia = $Media->getMediaById($media_id);

				if($getMedia->rowCount() == 0)
					die(json_encode(["res" => "Desculpe, não foi possível encontrar este mídia."]));

				$media = $getMedia->fetchAll(PDO::FETCH_ASSOC)[0];

				$media["attributes"] = json_decode($media['attributes'], true);
				die(json_encode(["res" => 1, "media" => $media]));
			});

			$router->post("/edit", function(){
				if(empty($_POST["media_id"]))
					die(json_encode(["res" => "Desculpe, não foi possível identificar a mídia."]));

				$Media = new Media;
				$media = $Media->getMediaById($_POST["media_id"]);
				if($media->rowCount() == 0)
					die(json_encode(["res" => "Desculpe, não foi possível encontrar esta mídia."]));

				$media = $media->fetchObject();

				$attributes = json_decode($media->attributes, true);

				$attributes['alt'] = !empty($_POST["media_alt"]) ? $_POST['media_alt'] : '';
				
				if($Media->updateMedia($_POST["media_id"], json_encode($attributes))){
					die(json_encode(["res" => 1]));
				}
				else{
					die(json_encode(["res" => "Desculpe, não foi possível atualizar a mídia. Atualize a página e tente novamente!"]));
				}
			});
		});

		#/admin/coupons
		$router->mount("/coupons", function() use($router){
			$router->get("/", function(){
				require "views/admin/coupons.php";
			});


			$router->get("/new", function(){
				require "views/admin/coupons-new.php";
			});

			$router->post("/new", function () {
			    // Validações básicas
			    if (empty($_POST["coupon_code"])) {
			        die(json_encode(["res" => "Por favor, informe o código do cupom."]));
			    }
			    if (empty($_POST["coupon_discount_type"]) || !in_array($_POST["coupon_discount_type"], ["percent", "fixed"])) {
			        die(json_encode(["res" => "Por favor, selecione o tipo de desconto válido ('percent' ou 'fixed')."]));
			    }
			    if (empty($_POST["coupon_discount_value"])) {
			        die(json_encode(["res" => "Por favor, informe o valor do desconto."]));
			    }
			    if (empty($_POST["expiration_date"])) {
			        die(json_encode(["res" => "Por favor, informe a data e hora de expiração."]));
			    }

			    $expirationDate = DateTime::createFromFormat("d/m/Y H:i", $_POST["expiration_date"]);
			    if (!$expirationDate) {
			        die(json_encode(["res" => "Data de expiração inválida. Use o formato dd/mm/AAAA HH:mm."]));
			    }

			    // Validar o valor do desconto
			    $discountValue = floatval($_POST["coupon_discount_value"]);
			    if ($discountValue <= 0) {
			        die(json_encode(["res" => "O valor do desconto deve ser maior que zero."]));
			    }


			    // Instanciar o modelo Cupom e tentar salvar
			    $Coupon = new Coupon;

			    if($Coupon->getCouponByCode($_POST["coupon_code"])->rowCount() > 0)
			    	die(json_encode(["res" => "Desculpe, o cupom ".$_POST['coupon_code']." já existe."]));

			    if ($Coupon->create(
			        $_POST["coupon_code"],
			        $_POST["coupon_discount_type"],
			        $discountValue,
			        $expirationDate->format("Y-m-d H:i"),
			        (isset($_POST["status"]) ? intval($_POST["status"]) : 1)
			    )) {
			        die(json_encode(["res" => 1]));
			    } else {
			        die(json_encode(["res" => "Desculpe, não foi possível criar o cupom. Por favor, tente novamente."]));
			    }
			});


			$router->get("/edit/{coupon_id}", function($coupon_id){
				$Coupon = new Coupon;
				$getCoupon = $Coupon->getCouponById($coupon_id);

				if($getCoupon->rowCount() == 0)
					die(header("Location: /admin/coupons"));

				$coupon = $getCoupon->fetchObject();

				require "views/admin/coupons-edit.php";
			});

			$router->get("/view/{coupon_id}", function($coupon_id){
				$Coupon = new Coupon;
				$getCoupon = $Coupon->getCouponById($coupon_id);

				if($getCoupon->rowCount() == 0)
					die(header("Location: /admin/coupons"));

				$coupon = $getCoupon->fetchObject();

				require "views/admin/coupons-view.php";
			});
		});


		#/admin/banners
		$router->mount("/banners", function() use ($router){
			$router->get("/", function(){
				require "views/admin/banners.php";
			});
			$router->get("/new", function(){
				require "views/admin/banners-new.php";
			});
			$router->post("/new", function(){
				if(empty($_POST["position"])){
				    die(json_encode(["res" => "Por favor, selecione uma posição para o banner."]));
				} else if(empty($_POST["link"])){
				    die(json_encode(["res" => "Por favor, informe um link para o banner."]));
				} else if(empty($_POST["banner_order"])){
				    die(json_encode(["res" => "Por favor, informe uma ordem para o banner."]));
				} else if(!isset($_POST["banner_status"])){
				    die(json_encode(["res" => "Por favor, selecione um status para o banner."]));
				} else {
				    // Verificar se as imagens foram enviadas e processá-las
				    if(isset($_FILES["banner_desktop"]) && !empty($_FILES["banner_desktop"]["name"]) &&
				       isset($_FILES["banner_mobile"]) && !empty($_FILES["banner_mobile"]["name"])) {

				        $uploadPath = "uploads/" . date("Y/m/");

				        // Instância para upload de banner desktop
				        $UpinDesktop = new Upin;
				        $UpinDesktop->get($uploadPath, $_FILES["banner_desktop"]["name"], 10, "jpeg,jpg,png,webp", "banner_desktop", 1);
				        $UpinDesktop->run();

				        // Instância para upload de banner mobile
				        $UpinMobile = new Upin;
				        $UpinMobile->get($uploadPath, $_FILES["banner_mobile"]["name"], 10, "jpeg,jpg,png,webp", "banner_mobile", 1);
				        $UpinMobile->run();

				        // Verificação de sucesso dos uploads
				        if($UpinDesktop->res === true && $UpinMobile->res === true) {
				            $pathDesktop = $uploadPath . $UpinDesktop->json[0];
				            $pathMobile = $uploadPath . $UpinMobile->json[0];
				        } else {
				            die(json_encode(["res" => "Por favor, envie imagens válidas para o banner desktop e mobile."]));
				        }
				    } else {
				        die(json_encode(["res" => "Por favor, envie uma imagem para desktop e uma para mobile."]));
				    }

				    // Instância para criação do banner
				    $Banner = new Banner;
				    if($Banner->create(
				        $pathDesktop,
				        $pathMobile,
				        $_POST["position"],
				        $_POST["link"],
				        $_POST["banner_order"],
				        $_POST["banner_status"],
				        USER->iduser
				    )){
				        die(json_encode(["res" => 1]));
				    } else {
				        die(json_encode(["res" => "Desculpe, não foi possível criar o banner. Atualize a página e tente novamente."]));
				    }
				}
			});

			$router->get("/edit/{banner_id}", function($banner_id){
				$Banner = new Banner;
				$banner = $Banner->getBannerById($banner_id);

				if(!$banner){
					header("Location: /admin/banners");
					exit;
				}

				require "views/admin/banners-edit.php";
			});
			$router->post("/edit/{banner_id}", function($banner_id){
				if(empty($_POST["banner_id"]))
				    die(json_encode(["res" => "ID do banner não informado."]));

				// Valida os demais campos
				if(empty($_POST["position"])){
				    die(json_encode(["res" => "Por favor, selecione uma posição para o banner."]));
				} else if(empty($_POST["link"])){
				    die(json_encode(["res" => "Por favor, informe um link para o banner."]));
				} else if(empty($_POST["banner_order"])){
				    die(json_encode(["res" => "Por favor, informe uma ordem para o banner."]));
				} else if(!isset($_POST["banner_status"])){
				    die(json_encode(["res" => "Por favor, selecione um status para o banner."]));
				} else {
				    $Banner = new Banner;
				    $banner = $Banner->getBannerById($_POST["banner_id"]); // Função que busca o banner por ID

				    if(!$banner) die(json_encode(["res" => "Banner não encontrado."]));

				    // Define os caminhos das imagens atuais
				    $pathDesktop = $banner['path_desktop'];
				    $pathMobile = $banner['path_mobile'];

				    $uploadPath = "uploads/" . date("Y/m/");

				    // Verifica se uma nova imagem para desktop foi enviada e faz o upload
				    if(isset($_FILES["banner_desktop"]) && !empty($_FILES["banner_desktop"]["name"])) {
				        $UpinDesktop = new Upin;
				        $UpinDesktop->get($uploadPath, $_FILES["banner_desktop"]["name"], 10, "jpeg,jpg,png,webp", "banner_desktop", 1);
				        $UpinDesktop->run();

				        if($UpinDesktop->res === true) {
				            $pathDesktop = $uploadPath . $UpinDesktop->json[0];
				        } else {
				            die(json_encode(["res" => "Erro ao enviar a nova imagem desktop."]));
				        }
				    }

				    // Verifica se uma nova imagem para mobile foi enviada e faz o upload
				    if(isset($_FILES["banner_mobile"]) && !empty($_FILES["banner_mobile"]["name"])) {
				        $UpinMobile = new Upin;
				        $UpinMobile->get($uploadPath, $_FILES["banner_mobile"]["name"], 10, "jpeg,jpg,png,webp", "banner_mobile", 1);
				        $UpinMobile->run();

				        if($UpinMobile->res === true) {
				            $pathMobile = $uploadPath . $UpinMobile->json[0];
				        } else {
				            die(json_encode(["res" => "Erro ao enviar a nova imagem mobile."]));
				        }
				    }

				    // Atualiza os dados do banner
				    if($Banner->update(
				        $_POST["banner_id"],
				        $pathDesktop,
				        $pathMobile,
				        $_POST["position"],
				        $_POST["link"],
				        $_POST["banner_order"],
				        $_POST["banner_status"],
				        USER->iduser
				    )){
				        die(json_encode(["res" => 1]));
				    } else {
				        die(json_encode(["res" => "Desculpe, não foi possível atualizar o banner. Tente novamente."]));
				    }
				}
			});


			$router->post("/delete/{banner_id}", function($banner_id){
				if(empty($banner_id))
					die(json_encode(["res" => "Desculpe, não foi possível identificar este banner. Atualize a página e tente novamente!"]));

				$Banner = new Banner;
				$banner = $Banner->getBannerById($banner_id);
				if(!$banner)
					die(json_encode(["res" => "Desculpe, não foi possível identificar este banner. Atualize a página e tente novamente!"]));


				if($Banner->delete($banner_id))
					die(json_encode(["res"=> 1]));
				else
					die(json_encode(["res" => "Desculpe, não foi possível apagar o banner do banco de dados."]));

			});
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
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["post_featured_image"]["name"], 10, "jpeg,jpg,png,webp", "post_featured_image", 1);
					$Upin->run();

					if($Upin->res === true) $post_featured_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
				}

				if(!isset($_POST["post_status"]))
					$status = 0;
				else
					$status = intval($_POST["post_status"]);


				$Post = new Post;

				if($Post->create(
					$_POST["post_title"],
					$_POST["post_excerpt"],
					$_POST["post_content"],
					$post_featured_image,
					$_SESSION["csa_email"],
					$status
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
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["post_featured_image"]["name"], 10, "jpeg,jpg,png,webp", "post_featured_image", 1);
					$Upin->run();

					if($Upin->res === true) $post_featured_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					if(empty($_POST["post_actual_featured_image"]))
						die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
					else
						$post_featured_image = $_POST["post_actual_featured_image"];
				}

				if(!isset($_POST["post_status"]))
					$status = 0;
				else
					$status = intval($_POST["post_status"]);


				$Post = new Post;
				if($Post->update(
					$post_id,
					$_POST["post_title"],
					$_POST["post_excerpt"],
					$_POST["post_content"],
					$post_featured_image,
					$status
				)){
					die(json_encode(["res" => 1]));
				}else{
					die(json_encode(["res" => "Desculpe, não foi possível criar o seu post. Atualize a página e tente novamente."]));
				}
			}
		});

		$router->post("/posts/delete/{post_id}", function($post_id){
			if(empty($post_id))
				die(json_encode(["res" => "Desculpe, não foi possível identificar o post. Atualize a página e tente novamente!"]));

			$Post = new Post;
			$getPost = $Post->getPost($post_id);
			if($getPost->rowCount() == 0)
				die(json_encode(["res" => "Desculpe, não foi possível encontrar o post. Atualize a página e tente novamente!"]));

			if($Post->delete($post_id))
				die(json_encode(["res" => 1]));
			else
				die(json_encode(["res" => "Desculpe, não foi possível apagar o post. Atualize a página e tente novamente!"]));

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

				if(!isset($_POST["content_status"]))
					die(json_encode(["res" => "Desculpe, não foi possível encontrar o status. Atualize a página e tente novamente!"]));



				if(isset($_POST["content_status"]))
					$content_status = intval($_POST["content_status"]);
				else
					$content_status = 0;



				if(isset($_FILES["content_featured_image"]) AND !empty($_FILES["content_featured_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["content_featured_image"]["name"], 10, "jpeg,jpg,png,webp", "content_featured_image", 1);
					$Upin->run();

					if($Upin->res === true) $content_featured_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
				}

				// $User = new User;
				// if(($User->isUserAuthenticated()) == false)
				// 	die(json_encode(["res"=>"Oops, parece que você não tem permissão para isso!"]));

				if(empty($_POST["content_publish_date"])){
					if($content_status == 0)
						$published_at = null;
					else
						$published_at = date("Y-m-d H:i:s");
				}
				else{
					$published_at = DateTime::createFromFormat("d/m/Y H:i", $_POST["content_publish_date"])->format("Y-m-d H:i:s");
				}


				$Content = new Content;
				if($Content->create($_POST["content_title"], $_POST["content_excerpt"], $_POST["content_content"], $content_featured_image, $_POST["content_featured_video_url"], $_SESSION["csa_email"], $content_status, $published_at))
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
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["content_featured_image"]["name"], 10, "jpeg,jpg,png,webp", "content_featured_image", 1);
					$Upin->run();

					if($Upin->res === true) $content_featured_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}else{
					$content_featured_image = $_POST["content_featured_image_actual"];
				}


				if(empty($_POST["content_publish_date"])){
					$published_at = date("Y-m-d H:i:s");
				}
				else{
					$published_at = DateTime::createFromFormat("d/m/Y H:i", $_POST["content_publish_date"])->format("Y-m-d H:i:s");
				}


				if(isset($_POST["content_status"]))
					$content_status = intval($_POST["content_status"]);
				else
					$content_status = 0;



				$Content = new Content;
				if($Content->update($content_id, $_POST["content_title"], $_POST["content_excerpt"], $_POST["content_content"], $content_featured_image, $_POST["content_featured_video_url"], $content_status, $published_at))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Não foi possível atualizar este conteúdo. Atualize a página e tente novamente!"]));
			}
		});
		$router->post("/contents/delete/{content_id}", function($content_id){
			if(empty($content_id)){
				die(json_encode(["res" => "Desculpe, não foi possível apagar este conteúdo."]));
			}else{
				$Content = new Content;
				if($Content->delete($content_id))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Não foi possível apagar este conteúdo. Atualize a página e tente novamente!"]));
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
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["club_image"]["name"], 10, "jpeg,jpg,png,webp", "club_image", 1);
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
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["club_image"]["name"], 10, "jpeg,jpg,png,webp", "club_image", 1);
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

		$router->post("/clubs/delete/{club_id}", function($club_id){
			if(empty($club_id)){
				die(json_encode(["res" => "Desculpe, não foi possível apagar este clube."]));
			}else{
				$Club = new Club;
				if($Club->delete($club_id))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Não foi possível apagar este clube. Atualize a página e tente novamente!"]));
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
			}
			// else if(!DateTime::createFromFormat('d/m/Y H:i', $_POST["event_datetime"])->format('Y-m-d H:i')){
			//     die(json_encode(["res" => "Por favor, informe uma data e hora VÁLIDAS para o evento."]));
			// }
			else{
				if(isset($_FILES["event_poster"]) AND !empty($_FILES["event_poster"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["event_poster"]["name"], 10, "jpeg,jpg,png,webp", "event_poster", 1);
					$Upin->run();

					if($Upin->res === true) $event_poster = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem válida."]));
				}else{
					die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
				}


				if(empty($_POST["event_status"]))
					$event_status = 0;
				else
					$event_status = intval($_POST["event_status"]);


				$Event = new Event;
				if($Event->create(
					$_POST["event_title"],
					$_POST["event_excerpt"],
					DateTime::createFromFormat('d/m/Y H:i', $_POST["event_datetime"])->format('Y-m-d H:i'),
					$event_poster,
					$_POST["event_content"],
					$event_status,
					$_SESSION["csa_email"]
				))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, não foi possível cadastrar o evento."]));


			}

		});

		$router->get("/events/{idevent}/qrcode", function($idevent){
			$Event = new Event;
			$getEvent = $Event->getEventById($idevent);

			if($getEvent->rowCount() == 0){
				header("Location: /admin/events");
				exit;
			}

			$event = $getEvent->fetchObject();

			
		});

		$router->get("/events/edit/{idevent}", function($idevent){
			$Event = new Event;
			$getEvent = $Event->getEventById($idevent);

			if($getEvent->rowCount() == 0){
				header("Location: /admin/events");
				exit;
			}

			$event = $getEvent->fetchObject();


			$writer = new PngWriter();
			$qrCode = new QrCode(
				data: 'https://canalsaltoalto.com/app/events/checkin/'.$event->qrcode_uuid,
				encoding: new Encoding('UTF-8'),
				errorCorrectionLevel: ErrorCorrectionLevel::Low,
				size: 1080,
				margin: 10,
				roundBlockSizeMode: RoundBlockSizeMode::Margin,
				foregroundColor: new Color(0, 0, 0),
				backgroundColor: new Color(255, 255, 255)
			);
			$result = $writer->write($qrCode);

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
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["event_poster"]["name"], 10, "jpeg,jpg,png,webp", "event_poster", 1);
					$Upin->run();

					if($Upin->res === true) $event_poster = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem válida."]));
				}else{
					if(empty($_POST["event_poster_actual"]))
						die(json_encode(["res" => "Por favor, envie uma imagem de destaque."]));
					else
						$event_poster = $_POST["event_poster_actual"];
				}

				if(empty($_POST["event_status"]))
					$event_status = 0;
				else
					$event_status = intval($_POST["event_status"]);

				$Event = new Event;

				if($Event->update(
					$idevent,
					$_POST["event_title"],
					$_POST["event_excerpt"],
					DateTime::createFromFormat('d/m/Y H:i', $_POST["event_datetime"])->format('Y-m-d H:i'),
					$event_poster,
					$_POST["event_content"],
					$event_status
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


				if(empty($_POST["notice_status"]))
					$notice_status = 0;
				else
					$notice_status = intval($_POST["notice_status"]);


				$Notice = new Notice;
				if($Notice->create($_POST["notice_title"], $_POST["notice_content"], $notice_status, $_SESSION["csa_email"])){

					
					// echo $response;
					die(json_encode(["res" => 1]));
				}else{
					die(json_encode(["res" => "Não foi possível criar este aviso. Atualize a página e tente novamente!"]));
				}
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

		$router->post("/notices/edit/{notice_id}", function($notice_id){
			if(empty($notice_id))
				die(json_encode(["res" => "Desculpe, não foi possível encontrar este aviso."]));

			$Notice = new Notice;
			if($Notice->getNoticeById($notice_id)->rowCount() == 0)
				die(json_encode(["res" => "Desculpe, não foi possível encontrar este aviso."]));


			if(empty($_POST["notice_title"])){
				die(json_encode(["res"=>"Por favor, informe o título do aviso!"]));
			}else if(empty($_POST["notice_content"])){
				die(json_encode(["res"=>"Por favor, informe o conteúdo do aviso!"]));
			}else if(!isset($_POST["notice_status"])){
				die(json_encode(["res" => "Por favor, informe o status do aviso."]));
			}else if(empty($_POST["notice_publish_date"])){
				die(json_encode(["res" => "Por favor, informe a data de publicação."]));
			}else{
				$Notice = new Notice;
				if($Notice->update($notice_id, $_POST["notice_title"], $_POST["notice_content"], $_POST["notice_status"], 
					DateTime::createFromFormat('d/m/Y H:i', $_POST["notice_publish_date"])->format('Y-m-d H:i'),

					// (date("Y-m-d H:i:s", strtotime()))
				))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Não foi possível atualizar este aviso. Atualize a página e tente novamente!"]));
			}
		});

		$router->post("/notices/delete/{notice_id}", function($notice_id){
			if(empty($notice_id))
				die(json_encode(["res" => "Desculpe, não foi possível encontrar este aviso."]));


			$Notice = new Notice;
			$getNotice = $Notice->getNoticeById($notice_id);

			if($getNotice->rowCount() == 0)
				die(json_encode(["res" => "Desculpe, não foi possível encontrar este aviso."]));


			if($Notice->delete($notice_id))
				die(json_encode(["res" => 1]));
			else
				die(json_encode(["res" => "Desculpe, não foi possível apagar este aviso."]));
		});



		$router->get("/members", function(){
			require "views/admin/members-test.php";
		});
		$router->get("/members-test", function(){
			require "views/admin/members-test.php";
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
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["member_photo"]["name"], 10, "jpeg,jpg,png,webp", "member_photo", 1);
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
		$router->post("/members/membership/new", function(){
			if(empty($_POST["iduser"]))
				die(json_encode(["res" => "Desculpe, não foi possível identificar o membro. Atualize a página e tente novamente!"]));

			if(empty($_POST["new_membership_value"]))
				die(json_encode(["res" => "Por favor, preencha o campo de valor."]));

			if(empty($_POST["new_membership_payment_type"]))
				die(json_encode(["res" => "Por favor, preencha o campo de valor."]));

			if(!in_array($_POST["new_membership_payment_type"], ["pix", "credit_card"]))
				die(json_encode(["res" => "Por favor, informe um método de pagamento válido."]));

			$dataRecebidaFormatada = str_replace('T', ' ', $_POST["new_membership_ends_at"]);
			$dataRecebidaDateTime = new DateTime($dataRecebidaFormatada);

			$dataAtual = new DateTime();
			if ($dataRecebidaDateTime < $dataAtual)
				die(json_encode(["res" => "Por favor, informe uma data de término maior que a data atual para a assinatura."]));


			$Membership = new Membership;

			if($Membership->create(
				$_POST["iduser"],
				$_POST["new_membership_product"],
				$_POST["new_membership_orderid"],
				null,
				$_POST["new_membership_payment_type"],
				$_POST["new_membership_value"],
				str_replace('T', ' ', $_POST["new_membership_starts_at"]),
				str_replace('T', ' ', $_POST["new_membership_ends_at"]),
				'paid'
			)){
				die(json_encode(["res" => 1]));
			}else{
				die(json_encode(["res" => "Desculpe, não foi possível criar a assinatura para o usuário. Verifique os dados e tente novamente!"]));
			}
		});

		$router->post("/members/membership/delete/{idusermembership}", function($idusermembership){
			if(empty($idusermembership))
				die(json_encode(["res" => "Desculpe, não foi possível identificar o ID da assinatura."]));

			$User = new User;

			if($User->deleteUserMembershipById($idusermembership))
				die(json_encode(["res" => 1]));
			else
				die(json_encode(["res" => "Desculpe, não foi possível apagar a assinatura."]));
		});


		# /members/consulting/new
		$router->post("/members/consulting/new", function(){
			if(empty($_POST["user_id"]))
				die(json_encode(["res" => "Por favor, informe o ID do Usuário."]));
			
			if(empty($_POST["consulting_date"]))
				die(json_encode(["res" => "Por favor, informe a data da consultoria."]));
			
			// if(empty($_POST["consulting_observation"]))

			$Consulting = new Consulting;
			$create = $Consulting->create($_POST["user_id"], $_POST["consulting_date"], $_POST["consulting_observation"]);

			if($create === true){
				User::addDiamond($_POST["user_id"], 50.00, null, "consulting_new", "Você ganhou 1 diamante por agendar uma consultoria com o Canal Salto Alto.");
				die(json_encode(["res" => 1]));
			}else{
				die(json_encode(["res" => "Desculpe, não foi possível criar a consultoria."]));
			}
		});

		$router->post("/members/consulting/delete/{user_consulting_id}", function($user_consulting_id){
			if(empty($user_consulting_id))
				die(json_encode(["res" => "Desculpe, não foi possível identificar o ID da consultoria."]));

			$Consulting = new Consulting;

			if($Consulting->deleteConsultingById($user_consulting_id))
				die(json_encode(["res" => 1]));
			else
				die(json_encode(["res" => "Desculpe, não foi possível apagar a consultoria."]));
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
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["member_photo"]["name"], 10, "jpeg,jpg,png,webp", "member_photo", 1);
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

		$router->get("/members/view/{user_id}", function($user_id){
			$User = new User;
			$getUser = $User->getUserById($user_id);

			if($getUser->rowCount() == 0){
				header("Location: /admin/members");
				exit;
			}

			$user = $getUser->fetchObject();


			require "views/admin/members-view.php";
		});


		$router->get("/members/inactive", function(){
			require "views/admin/members-inactive.php";
		});

		$router->get("/members/active", function(){
			require "views/admin/members-active.php";
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
		    		$imageFolder = "uploads/".date("Y\/m\/");
					if (!is_dir($imageFolder)) {
					    mkdir($imageFolder, 0755, true);
					}


					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["company_image"]["name"], 10, "jpeg,jpg,png,webp", "company_image", 1);
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
		    	)){
		    		die(json_encode(["res" => 1]));
		    	}
		    	else{
		    		die(json_encode(["res" => "Desculpe, algo deu errado ao tentar criar a empresa. Atualize a página e tente novamente!"]));
		    	}

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

			    if(!empty($_POST["actual_company_image"]))
			    	$company_image = $_POST["actual_company_image"];
			    else
			    	$company_image = null;

		    	if(isset($_FILES["company_image"]) AND !empty($_FILES["company_image"]["name"])){
					$Upin = new Upin;
					$Upin->get( "uploads/".date("Y\/m\/"), $_FILES["company_image"]["name"], 10, "jpeg,jpg,png,webp", "company_image", 1);
					$Upin->run();

					if($Upin->res === true) $company_image = "uploads/".date("Y\/m\/").$Upin->json[0];
					else die(json_encode(["res"=>"Por favor, envie uma imagem de destaque válida."]));
				}

				$status = (isset($_POST["status"])) ? intval($_POST["status"]) : 2;

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
				    $status
		    	))
		    		die(json_encode(["res" => 1]));
		    	else
		    		die(json_encode(["res" => "Desculpe, algo deu errado ao tentar criar a empresa. Atualize a página e tente novamente!"]));


		    }
		});


		$router->post("/companies/delete/{company_id}", function($company_id){
		    if (empty($company_id)) {
		        die(json_encode(["res" => "Desculpe, não foi possível apagar esta empresa."]));
		    } else {
		        $Company = new Company;
		        
		        // Verifica se a empresa existe
		        $company = $Company->getCompanyById($company_id);
		        if ($company->rowCount() === 0) {
		            die(json_encode(["res" => "Empresa não encontrada."]));
		        }
		        
		        // Tenta deletar a empresa
		        if ($Company->delete($company_id)) {
		            die(json_encode(["res" => 1]));
		        } else {
		            die(json_encode(["res" => "Não foi possível apagar esta empresa. Atualize a página e tente novamente!"]));
		        }
		    }
		});


		$router->get("/companies/approves", function(){
			require "views/admin/companies-approves.php";
		});


		#/admin/publis
		$router->get("/publis", function(){
			require "views/admin/publis.php";
		});

		$router->get("/publis/new", function(){
			require "views/admin/publis-new.php";
		});

		$router->post("/publis/new", function(){
			if(empty($_POST["publi_content"])){
				die(json_encode(["res" => "Por favor, informe um conteúdo para sua publi."]));
			}else if(empty($_POST["publi_creator"])){
				die(json_encode(["res" => "Por favor, selecione uma dona para esta publi."]));
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
			}
			// else if(empty(trim($_POST["publi_title"]))){
			// 	die(json_encode(["res" => "Por favor, informe o título da publi."]));
			// }
			else if(empty(trim($_POST["publi_content"]))){
				die(json_encode(["res" => "Por favor, informe um conteúdo para a publi."]));
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

				if(empty($_POST["publi_status"]))
					$publi_status = 0;
				else
					$publi_status = intval($_POST["publi_status"]);

				$Publi = new Publi;

				if($Publi->update($publi_id, $_POST["publi_content"], $publi_image, $publi_status, $_POST["publi_creator"]))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Desculpe, não foi possível atualizar a publi."]));
			}
		});

		$router->get("/publis/approves", function(){
			require "views/admin/publis-approves.php";
		});

		$router->post("/publis/delete/{publi_id}", function($publi_id){
			if(empty($publi_id)){
				die(json_encode(["res" => "Desculpe, não foi possível apagar esta publi."]));
			}else{
				$Publi = new Publi;
				if($Publi->delete($publi_id))
					die(json_encode(["res" => 1]));
				else
					die(json_encode(["res" => "Não foi possível apagar esta publi. Atualize a página e tente novamente!"]));
			}
		});


		$router->mount("/reports", function() use ($router){
			$router->get("/", function() {});

			$router->get("/birthdays", function(){
				require_once "views/admin/reports-birthdays.php";
			});

			$router->get("/ranking", function(){
				require_once "views/admin/reports-ranking.php";
			});

			$router->get("/orders", function(){
				require_once "views/admin/reports-orders.php";
			});
		});


		$router->get("/logout", function(){
			session_destroy();
			header("Location: /");
		});
	});


	$router->post("/upload/image", function(){
  		// $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://example.com");

		
		$imageFolder = "uploads/".date("Y\/m\/");

		if (!file_exists($imageFolder)) mkdir($imageFolder, 0777, true);

  		reset ($_FILES);
  		$temp = current($_FILES);
  		if (is_uploaded_file($temp['tmp_name'])){

		    // Sanitize input
		    // if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
		    //     header("HTTP/1.1 400 Invalid file name.");
		    //     return;
		    // }

		    // Verify extension
		    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png", "jpeg", "webp"))) {
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