<?php
		
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

	$router->get("/menu", function(){
		require "views/site/menu.php";
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