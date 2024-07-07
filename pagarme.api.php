<?php
	$router->mount("/pagarme", function() use ($router){
		$router->get("/paid", function(){
			echo "paid";
		});
	});