<?php
	require_once "application/autoload.php";

	define("PATH", "http://canalsaltoalto.local/");

	if (session_status() == PHP_SESSION_NONE) session_start();


	// Instance Router
	$router = new \Bramus\Router\Router();

	include "routes/site.php";

	include "routes/checkout.php";


	include "routes/app.php";


	include "routes/admin.php";


	include "routes/pagarme.php";

	$router->run();