<?php
	require_once "application/autoload.php";

	define("PATH", "https://canalsaltoalto.com/");

	if (session_status() == PHP_SESSION_NONE) session_start();

	$User = new User;
	// if((($User->isUserAuthenticated()) == false OR $User->isUserAMember((isset($_SESSION["csa_email"]) ? $_SESSION["csa_email"] : null)  ) == 0) AND !($User->isUserAdminByEmail($_SESSION["csa_email"]))){

	if($User->isUserAuthenticated()){
		$user = $User->getUserByEmail($_SESSION["csa_email"])->fetchObject();
	}
	else{
		$user = (object) [];
	}

	define("USER", $user);

	// Instance Router
	$router = new \Bramus\Router\Router();

	include "routes/site.php";

	include "routes/checkout.php";

	include "routes/app.php";

	include "routes/admin.php";


	include "routes/pagarme.php";

	$router->run();