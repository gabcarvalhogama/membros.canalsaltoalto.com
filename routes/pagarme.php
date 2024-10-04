<?php
	$router->mount("/pagarme", function() use ($router){
		$router->post("/paid", function(){
			$data = json_decode(file_get_contents('php://input'), true);
			if(empty($data)) die(json_encode(["msg" => "Webhook received: empty body."]));


			if (isset($data['type']) && $data['type'] === 'charge.paid') {
			    // Obtenha o ID do pedido
			    if (isset($data['data']['order']['id'])) {
			        $orderId = $data['data']['order']['id'];

			        $User = new User;

			        $starts_at = str_replace("T", " ", $data['data']['paid_at']);

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


		// $router->get("/cc", function(){
		// 	$Checkout = new Checkout();
		// 	$customerData = [
		// 	    'name' => 'Gabriel Carvalho Gama',
		// 	    'type' => 'individual',
		// 	    'email' => 'gabriel@hatoria.com',
		// 	    'document' => '14962940767',
		// 	    'document_type' => 'CPF',
		// 	    'phones' => [
	 //                'home_phone' => [
	 //                    'country_code' => '55',
	 //                    'area_code' => 27,
	 //                    'number' => 998031679
	 //                ]
	 //        	],
		// 	];

		// 	$itemData = [
		// 	    'amount' => 29700,
		// 	    'quantity' => 1,
		// 	    'description' => 'Membro CSA - Anual',
		// 	    'code' => 0
		// 	];

		// 	$paymentMethod = [
	 //            [
	 //                'payment_method' => 'credit_card',
	 //                'credit_card' => [
	 //                	'recurrence' => false,
	 //                	'installments' => 12,
	 //                	'statement_descriptor' => 'SALTOALTO',
	 //                	'card' => [
	 //                		'number' => '5316812107562213',
	 //                		'holder_name' => 'Gabriel Carvalho Gama',
	 //                		'exp_month' => 4,
	 //                		'exp_year' => 32,
	 //                		'cvv' => 836,
	 //                		'billing_address' => [
		//                 		"line_1" => "Av. Teste, 1066",
	 //                        	"zip_code" => "29900020",
	 //                        	"city" => "Linhares",
	 //                        	"state" => "ES",
	 //                        	"country" => "BR"
	 //                		]
	 //                	]
	 //                ],
	 //            ]
	 //        ];

		// 	$orderResponse = $Checkout->createOrder($customerData, $paymentMethod, $itemData);
		// 	echo "<pre>";
		// 	var_dump($orderResponse);
		// 	echo "</pre>";	


		// 	// if (isset($orderResponse->id)) {
		// 	// 	$_SESSION["csa_order_id"] = $orderResponse->id;

		// 	// 	$User->addMembership($user->iduser, 1, $orderResponse->id, 'credit_card', 297.00, null, null, 'pending');

			    
		// 	// } else {
		//  //    	die(json_encode(["res" => "Erro ao criar o pedido:" . json_encode($orderResponse)]));
		// 	// }

		// });
	});