<?php
	$router->mount("/track", function() use ($router){
		$router->post("/", function() {
            var_dump($_POST);
            http_response_code(200);
        });

    });