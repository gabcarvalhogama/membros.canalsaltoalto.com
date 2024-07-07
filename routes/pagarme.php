<?php
	$router->mount("/pagarme", function() use ($router){
		$router->post("/paid", function(){
			$data = json_decode(file_get_contents('php://input'), true);
			if(empty($data)) die(json_encode(["msg" => "Webhook received: empty body."]));


			if (isset($data['type']) && $data['type'] === 'order.paid') {
			    // Obtenha o ID do pedido
			    if (isset($data['data']['id'])) {
			        $orderId = $data['data']['id'];

			        $User = new User;

			        $starts_at = str_replace("T", " ", $data['data']['charges'][0]['paid_at']);

			        $dateTime = new DateTime($starts_at);
					$dateTime->add(new DateInterval('P365D'));
					$ends_at = $dateTime->format('Y-m-d H:i:s');

			        if($User->updateMembershipByOrderId($orderId, 'paid', $starts_at, $ends_at))
			        	die(json_encode(["res" => 1]));
			        else
			        	die(json_encode(["msg" => "Webhook received: not found order id on update."]));
			    } else {
			        die(json_encode(["msg" => "Webhook received: not found order id."]));
			    }
			} else {
			    echo "Tipo de evento inválido.";
			}
		});
	});