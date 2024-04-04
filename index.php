<?php
	require_once "application/autoload.php";

	if (session_status() == PHP_SESSION_NONE) session_start();


	// Instance Router
	$router = new \Bramus\Router\Router();


	

	$router->run();