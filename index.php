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

	include "routes/checkout.php";




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


		$router->get("/contents", function(){
			require "views/app/contents.php";
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


		$router->get("/clubs", function(){
			require "views/app/clubs.php";
		});


		$router->get("/companies", function(){
			require "views/app/companies.php";
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

		$router->get("/profile", function(){
			
		});
	});


	include "routes/admin.php";

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


	include "routes/pagarme.php";

	$router->run();