<?php
	$router->mount("/pagarme", function() use ($router){
		$router->post("/paid", function(){
			$data = json_decode(file_get_contents('php://input'), true);
			if(empty($data)) die(json_encode(["msg" => "Webhook received: empty body."]));


			if (isset($data['type']) && $data['type'] === 'charge.paid') {
			    // Obtenha o ID do pedido
			    if (isset($data['data']['order']['id'])) {
			        $orderId = $data['data']['order']['id'];



			        $Membership = new Membership;
			        $getMembership = $Membership->getMembershipByOrderId($orderId);
			        if($getMembership->rowCount() > 0 AND $getMembership->fetchObject()->status == 'paid')
			        	die(json_encode(["msg" => "Webhook received: order is already proccessed."]));




			        $User = new User;

			        $starts_at = str_replace("T", " ", $data['data']['paid_at']);

			        $dateTime = new DateTime($starts_at);
					$dateTime->add(new DateInterval('P365D'));
					$ends_at = $dateTime->format('Y-m-d H:i:s');

			        if($User->updateMembershipByOrderId($orderId, 'paid', $starts_at, $ends_at)){

			        	$name = $data["data"]["customer"]["name"];
			        	$email = $data["data"]["customer"]["email"];

			        	$Comunications = new Comunications;

						$email_title = "Seja bem-vinda! - Canal Salto Alto";
						$content = "<div>
							<h1>Seja bem-vinda à Comunidade Canal Salto Alto</h1>
							<p>Olá <b>$name</b>, parabéns por dar mais um SALTO ALTO em seu empreendedorismo se tornando membro do Canal Salto Alto.</p>
							<p>Somos um canal de aprendizado e conexão com outras empreendedoras. Aqui o seu sucesso depende muito da sua participação nas ações que criamos, seja no digital e no presencial.</p>

							<p>Quanto mais você se conectar, mais se desenvolve, conhece novas pessoas e divulga o seu trabalho.</p>

							<p>Fique ligada! A Plataforma de Membros é nosso maior canal de comunicação.</p>

							<p>Você agora é uma membro ativa da Comunidade Canal Salto Alto. Clique no botão abaixo e acesse a plataforma:</p>
							<a href='https://canalsaltoalto.com/app' style='display: block;padding: 20px;border-radius: 5px;background-color: #E54C8E;color: #000;width: 100%;'>ACESSE A PLATAFORMA AGORA</a>
						</div>";
						$email_content = Template::render([
							"email_title" => $email_title,
							"email_content" => $content 
						], "email_general");



	 					$Comunications->sendEmail($email, $email_title, $email_content);

						
						if(Membership::getPaidMembershipsByUserEmail($email)->rowCount() > 1)
							User::addDiamond(User::getUserIdByEmail2($email), 100, null, "renewal", null);
						
						// Referral System Logic
						$payerId = User::getUserIdByEmail2($email);
						$payerUser = $User->getUserById($payerId)->fetchObject();

						if($payerUser && $payerUser->referred_by){
							// Credit diamonds
							User::addDiamond($payerUser->referred_by, 100, null, "referral_bonus", $payerId);

							// Get referrer details for email
							$referrerUser = $User->getUserById($payerUser->referred_by)->fetchObject();
							if($referrerUser){
								$referrerEmail = $referrerUser->email;
								$referrerName = $referrerUser->firstname;
								
								$email_title_ref = "Você ganhou 100 diamantes! 💎";
								$content_ref = "<div>
									<h1>Parabéns, $referrerName!</h1>
									<p>Você acabou de ganhar <b>100 diamantes</b> porque alguém se tornou membro do Canal Salto Alto usando seu link de indicação.</p>
									<p>Continue indicando e ganhe mais benefícios exclusivos!</p>
									<p>Acesse sua conta para ver seu saldo de diamantes.</p>
									<a href='https://canalsaltoalto.com/app' style='display: block;padding: 20px;border-radius: 5px;background-color: #E54C8E;color: #000;width: 100%;'>ACESSAR MINHA CONTA</a>
								</div>";
								
								$email_content_ref = Template::render([
									"email_title" => $email_title_ref,
									"email_content" => $content_ref
								], "email_general");
								
								$Comunications->sendEmail($referrerEmail, $email_title_ref, $email_content_ref);
							}
						}
						



			        	die(json_encode(["res" => 1]));
			        }
			        else{
			        	die(json_encode(["msg" => "Webhook received: not found order id on update."]));
			        }
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