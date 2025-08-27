<?php
		
	$router->get("/", function(){
		require "views/site/home.php";
	});

	$router->get("/seja-membro", function(){
		require "views/site/seja-membro-v2.php";
	});


	$router->get("/coworking-space", function(){
		require "views/site/coworking-space.php";
	});

	$router->get("/noticias", function(){
		$Post = new Post;

		$posts = $Post->getPosts(12, 0);
		$total_posts = $Post->getPostsTotalNumber();

		require "views/site/noticias.php";
	});

	$router->get("/noticias/page/{page_number}", function($page_number){

		if((int) $page_number < 1)
			header("Location: /noticias");

		$Post = new Post;

		$posts = $Post->getPosts(12, (($page_number - 1) * 12));
		$total_posts = $Post->getPostsTotalNumber();
		require "views/site/noticias.php";
	});

	$router->get("/quem-somos", function(){
		require "views/site/quem-somos.php";
	});

	$router->get("/guia-de-empreendedoras", function(){
		$Company = new Company;
		$total_companies = $Company->getCompaniesByStatus()->rowCount();
		
		
		$category_id = isset($_GET['category']) ? (int) $_GET['category'] : null;

		if ($category_id) {
			$companies = $Company->getCompaniesByStatusCategoryAndPagination(12, 0, 1, $category_id);
		} else {
			$companies = $Company->getCompaniesByStatusAndPagination(12, 0, 1);
		}


		require "views/site/guia-de-empreendedoras.php";
	});
	$router->get("/guia-de-empreendedoras/page/{page_number}", function($page_number){
		if((int) $page_number < 1)
			header("Location: /guia-de-empreendedoras");

		$Company = new Company;
		
		$total_companies = $Company->getCompaniesByStatus()->rowCount();


		$category_id = isset($_GET['category']) ? (int) $_GET['category'] : null;
		if ($category_id) {
			$companies = $Company->getCompaniesByStatusCategoryAndPagination(12, (($page_number - 1) * 12), 1, $category_id);
		} else {
			$companies = $Company->getCompaniesByStatusAndPagination(12, (($page_number - 1) * 12), 1);
		}


		require "views/site/guia-de-empreendedoras.php";
	});

	$router->get("/privacidade-e-dados", function(){
		require "views/site/privacy-and-data.php";
	});

	$router->get("/politica-de-bom-uso", function(){
		require "views/site/good-use.php";
	});

	$router->get("/menu", function(){
		require "views/site/menu.php";
	});


	$router->get("/post/{slug}", function($post_slug){
		$Post = new Post;

		$post = $Post->getPostBySlug($post_slug);
		if($post->rowCount() == 0) die(header("Location: /"));

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

