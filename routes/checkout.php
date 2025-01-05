<?php
	
	// Checkout
	$router->get("/checkout", function(){
		require "views/site/checkout.php";
	});

	$router->get("/checkout/cities/{uf}", function($uf){
		if(empty($uf)){
			die(json_encode(["res" => "Algo deu errado ao obter as cidades. Atualize a página e tente novamente."]));
		}else{
			$cities = User::getCitiesByUf($uf);

			if($cities->rowCount() > 0){
				die(json_encode(["res" => 1, "cities" => $cities->fetchAll(PDO::FETCH_ASSOC)]));
			}else{
				die(json_encode(["res" => "Algo deu errado ao obter as cidades. Atualize a página e tente novamente."]));
			}
		}
	});

	$router->post("/checkout/check-email", function(){
		if(empty($_POST["f_auth_email"])){
			die(json_encode(["res" => "Por favor, informe o seu e-mail para começar."]));
		}else{
			$User = new User;

			if($User->getUserByEmail($_POST["f_auth_email"])->rowCount() > 0){
				die(json_encode(["res" => 1, "has_email" => 1]));
			}else{
				die(json_encode(["res" => 1, "has_email" => 0]));
			}
		}
	});


	$router->post("/checkout/login", function(){
		if(empty($_POST["f_auth_email"])){
			die(json_encode(["res" => "Por favor, informe o seu e-mail para começar."]));
		}else if(empty($_POST["f_auth_password"])){
			die(json_encode(["res" => "Por favor, informe a sua senha para avançar."]));
		}else{
			$User = new User;
			if($User->login($_POST["f_auth_email"], $_POST["f_auth_password"])){
				$_SESSION["csa_email"] = $_POST["f_auth_email"];
				$_SESSION["csa_password"] = $_POST["f_auth_password"];

				die(json_encode(["res"=>1, "user" => $User->getUserByEmail($_SESSION["csa_email"])->fetchObject()]));
			}else{
				die(json_encode(["res"=>"O e-mail ou senha estão incorretos. Verifique os dados e tente novamente!"]));
			}
		}
	});


	$router->post("/checkout", function(){
		$User = new User;
		if(($User->isUserAuthenticated()) == false){
			if(empty($_POST["f_firstname"])){
				die(json_encode(["res"=>"Por favor, informe seu nome!", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_lastname"])){
				die(json_encode(["res"=>"Por favor, informe seu sobrenome.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_cpf"])){
				die(json_encode(["res"=>"Por favor, informe seu C.P.F.", "step" => "enterpreneur"]));
			}else if(!User::validateCPF($_POST["f_cpf"])){
				die(json_encode(["res"=>"Por favor, informe um C.P.F. válido.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_birthdate"])){
				die(json_encode(["res"=>"Por favor, informe sua data de nascimento.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_zipcode"])){
				die(json_encode(["res"=>"Por favor, informe um CEP válido.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_state"])){
				die(json_encode(["res"=>"Por favor, informe o seu estado.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_city"])){
				die(json_encode(["res"=>"Por favor, informe sua cidade.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_address"])){
				die(json_encode(["res"=>"Por favor, informe seu endereço.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_neighborhood"])){
				die(json_encode(["res"=>"Por favor, informe o seu bairro.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_cellphone"])){
				die(json_encode(["res"=>"Por favor, informe seu celular.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_email"])){
				die(json_encode(["res"=>"Por favor, informe o seu e-mail.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_password"])){
				die(json_encode(["res"=>"Por favor, informe uma senha.", "step" => "enterpreneur"]));
			}else if(empty($_POST["f_rpassword"])){
				die(json_encode(["res"=>"Por favor, repita sua senha.", "step" => "enterpreneur"]));
			}else if($_POST["f_password"] != $_POST["f_rpassword"]){
				die(json_encode(["res"=>"As senhas digitadas não combinam.", "step" => "enterpreneur"]));
			}

			// else if(empty($_POST["f_cnpj"])){
			// 	die(json_encode(["res"=>"Por favor, informe seu CNPJ para se tornar membro.", "step" => "company"]));
			// }else if(!User::validateCNPJ($_POST["f_cnpj"])){
			// 	die(json_encode(["res"=>"Por favor, informe um CNPJ válido para se tornar membro.", "step" => "company"]));
			// }


			else if(empty($_POST["f_payment_method"])){
				die(json_encode(["res"=>"Por favor, selecione uma forma de pagamento válida.", "step" => "payment"]));
			}else{
				if($_POST["f_payment_method"] == "cc"){
					if(empty($_POST["f_cc_number"])){
						die(json_encode(["res"=>"Por favor, informe os números do Cartão de Crédito.", "step" => "payment"]));
					}else if(empty($_POST["f_cc_holdername"])){
						die(json_encode(["res"=>"Por favor, informe o Nome Completo que está no Cartão de Crédito.", "step" => "payment"]));
					}else if(empty($_POST["f_cc_expirationdate"])){
						die(json_encode(["res"=>"Por favor, informe a data de expiração do Cartão de Crédito.", "step" => "payment"]));
					}else if(!(DateTime::createFromFormat('m/y', $_POST["f_cc_expirationdate"]) && DateTime::createFromFormat('m/y', $_POST["f_cc_expirationdate"])->format('m/y') === $_POST["f_cc_expirationdate"] && DateTime::createFromFormat('m/y', $_POST["f_cc_expirationdate"]) > new DateTime('last day of previous month'))){
						die(json_encode(["res"=>"Por favor, verifique a data de validade do Cartão de Crédito.", "step" => "payment"]));
					}else if(empty($_POST["f_cc_cvv"])){
						die(json_encode(["res"=>"Por favor, informe o CVV do Cartão de Crédito.", "step" => "payment"]));
					}
				}

				if($User->getUserByEmail($_POST["f_email"])->rowCount() > 0)
					die(json_encode(["res"=>"O e-mail informado já foi utilizado. Informe um novo e-mail para continuar!", "step" => "enterpreneur"]));
				// if($User->getUserByCPF($_POST["f_cpf"])->rowCount() > 0)
					// die(json_encode(["res"=>"O CPF informado já foi utilizado. Informe um novo CPF para continuar!", "step" => "enterpreneur"]));
				// if($User->getUserByCellphone($_POST["f_cellphone"])->rowCount() > 0)
				// 	die(json_encode(["res"=>"O Celular informado já foi utilizado. Informe um novo Celular para continuar!", "step" => "enterpreneur"]));

				$isUserCreated =  $User->create(
					(isset($_POST["f_firstname"])) ? $_POST["f_firstname"] : null,
					(isset($_POST["f_lastname"])) ? $_POST["f_lastname"] : null,
					(isset($_POST["f_cpf"])) ? $_POST["f_cpf"] : null,
					(isset($_POST["f_birthdate"])) ? $_POST["f_birthdate"] : null,
					(isset($_POST["f_zipcode"])) ? $_POST["f_zipcode"] : null,
					(isset($_POST["f_state"])) ? $_POST["f_state"] : null,
					(isset($_POST["f_city"])) ? $_POST["f_city"] : null,
					(isset($_POST["f_address"])) ? $_POST["f_address"] : null,
					(isset($_POST["f_address_number"])) ? $_POST["f_address_number"] : null,
					(isset($_POST["f_neighborhood"])) ? $_POST["f_neighborhood"] : null,
					(isset($_POST["f_complement"])) ? $_POST["f_complement"] : null,
					(isset($_POST["f_cellphone"])) ? $_POST["f_cellphone"] : null,
					(isset($_POST["f_email"])) ? $_POST["f_email"] : null,
					(isset($_POST["f_password"])) ? $_POST["f_password"] : null,
					0
				);

				if(!$isUserCreated)
					die(json_encode(["res"=>"Algo deu errado ao criar o seu usuário. Atualize a página e tente novamente!", "step" => "enterpreneur"]));

				$user = $User->getUserByEmail($_POST["f_email"])->fetchObject();
				$_SESSION["csa_email"] = $_POST["f_email"];
				$_SESSION["csa_password"] = $_POST["f_password"];
			}
		}else{
			// no needing for check fields emptynesses 'cause user is already authenticated
			$user = $User->getUserByEmail($_SESSION["csa_email"])->fetchObject();
		}

		// Membership Price
		$aVistaPrice = 199;
		$cartaoPrice = 238.80;

		$isMemberEligibleForRenewallDiscount = $User->isMemberEligibleForRenewallDiscount($user->iduser);


		$coupon_id = null;
		if(!empty($_POST["f_coupon"])){

			$Coupon = new Coupon;

			$coupon = $Coupon->getCouponByCode($_POST["f_coupon"]);

			if($coupon->rowCount() == 0)
				die(json_encode(["res" => "Desculpe, o cupom informado não foi encontrado."]));

			$couponObj = $coupon->fetchObject();

			// if($couponObj->expiration_date )
			$current_date = new DateTime();

			// Convertendo a string recebida do MySQL para um objeto DateTime
			$expiration_date_obj = new DateTime($couponObj->expiration_date);

			if ($current_date > $expiration_date_obj)
				die(json_encode(["res" => "Desculpe, o cupom informado já expirou."]));


			if($couponObj->discount_type == "percent"){
				$aVistaPrice = ($aVistaPrice*(1-($couponObj->discount_value/100)));
				$cartaoPrice = ($cartaoPrice*(1-($couponObj->discount_value/100)));
			}else{
				$aVistaPrice = ($aVistaPrice - $couponObj->discount_value);
				$cartaoPrice = ($cartaoPrice - $couponObj->discount_value);
			}
		}


		if(empty($user->cellphone)){
			$phone_number = "27996959895";
		}else{
			$phone_number = $user->cellphone;
		}


		$Checkout = new Checkout();
		$customerData = [
		    'name' => $user->firstname . " ".$user->lastname,
		    'type' => 'individual',
		    'email' => $user->email,
		    'document' => $user->cpf,
		    'document_type' => 'CPF',
		    'phones' => [
                'home_phone' => [
                    'country_code' => '55',
                    'area_code' => substr($phone_number, 0, 2),
                    'number' => substr($phone_number, 2)
                ]
        	],
		];


		switch($_POST["f_payment_method"]){
			case "pix":
				$itemData = [
				    'amount' => str_replace(".", "", number_format($aVistaPrice, 2, '.', '')),
				    'quantity' => 1,
				    'description' => 'Comunidade - Canal Salto Alto (1 ano)'
				];

				$paymentMethod = [
		            [
		                'pix' => [
		                    'expires_in' => '900'
		                ],
		                'payment_method' => 'pix'
		            ]
		        ];

				$orderResponse = $Checkout->createOrder($customerData, $paymentMethod, $itemData);


				if (isset($orderResponse->id)) {
					$_SESSION["csa_order_id"] = $orderResponse->id;

					$User->addMembership($user->iduser, 1, $orderResponse->id, $coupon_id, 'pix', $aVistaPrice, null, null, 'pending');

				    if ( $orderResponse->charges[0]->last_transaction->success == true ) {
				        $qrCodeUrl = $orderResponse->charges[0]->last_transaction->qr_code_url;
				        $qrCode = $orderResponse->charges[0]->last_transaction->qr_code;



				        die(json_encode(["res" => 1, "qr_code" => $qrCode, "qr_code_url" => $qrCodeUrl, "order_id" => $orderResponse->id]));
				    } else {
				    	die(json_encode(["res" => "Desculpe, não foi possível gerar o QR Code.", "step" => "payment"]));
				    }
				} else {
			    	die(json_encode(["res" => "Erro ao criar o pedido:" . $orderResponse->message,  "step" => "payment", $orderResponse]));
				}
			break;

			case "credit_card":
				$itemData = [
				    'amount' => str_replace(".", "", number_format($cartaoPrice, 2, '.', '')),
				    'quantity' => 1,
				    'description' => 'Comunidade - Canal Salto Alto (1 ano)',
				    'code' => 0
				];

				$paymentMethod = [
		            [
		                'payment_method' => 'credit_card',
		                'credit_card' => [
		                	'recurrence' => false,
		                	'installments' => (empty($_POST["f_cc_installments"])) ? 1 : intval($_POST["f_cc_installments"]),
		                	'statement_descriptor' => 'SALTOALTO',
		                	'card' => [
		                		'number' => preg_replace('/\D/', '', $_POST["f_cc_number"]),
		                		'holder_name' => $_POST["f_cc_holdername"],
		                		'exp_month' => intval(explode("/", $_POST["f_cc_expirationdate"])[0]),
		                		'exp_year' => intval(explode("/", $_POST["f_cc_expirationdate"])[1]),
		                		'cvv' => $_POST["f_cc_cvv"],
		                		'billing_address' => [
			                		"line_1" => $user->address,
		                        	"zip_code" => $user->zipcode,
		                        	"city" => $user->address_city_name,
		                        	"state" => $user->address_state_name,
		                        	"country" => "BR"
		                		]
		                	]
		                ],
		            ]
		        ];

		        $orderResponse = $Checkout->createOrder($customerData, $paymentMethod, $itemData);

				if (isset($orderResponse->id)) {
					$_SESSION["csa_order_id"] = $orderResponse->id;


					if($orderResponse->charges[0]->status == 'paid'){
						$paid_at = str_replace("T", " ", $orderResponse->charges[0]->paid_at);
						$dateTime = new DateTime($paid_at);
						$dateTime->add(new DateInterval('P365D'));
						$ends_at = $dateTime->format('Y-m-d H:i:s');


						$User->addMembership($user->iduser, 1, $orderResponse->id, $coupon_id, 'credit_card', $cartaoPrice, $paid_at, $ends_at, 'paid');


				        die(json_encode(["res" => 1, "order_id" => $orderResponse->id]));
					}else if($orderResponse->charges[0]->status == 'pending'){
						$User->addMembership($user->iduser, 1, $orderResponse->id, $coupon_id, 'credit_card', $cartaoPrice, null, null, '');

				        die(json_encode(["res" => 1, "order_id" => $orderResponse->id]));
					}else{
				    	die(json_encode(["res" => "Desculpe, o cartão retornou um erro. Verifique seus dados e tente novamente!", $orderResponse, "step" => "payment"]));
					}
				} else {
					$arr = get_object_vars($orderResponse->errors);
					// $arr = reset($arr);
					$arr = current($arr);
			    	die(json_encode(["res" => "Erro ao criar o pedido: " . Checkout::translate($arr[0]), "step" => "payment"]));
				}
			break;

			default:
				die(json_encode(["res" => "Por favor, selecione uma forma de pagamento válida.", "step" => "payment"]));
				exit;
		}
	});


	$router->post("/checkout/check-coupon", function(){
		if(empty($_POST["f_coupon"])){
			die(json_encode(["res" => "Desculpe, o cupom enviado é inválido."]));
		}else{
			$Coupon = new Coupon;

			$coupon = $Coupon->getCouponByCode($_POST["f_coupon"]);

			if($coupon->rowCount() == 0)
				die(json_encode(["res" => "Desculpe, o cupom informado não foi encontrado."]));

			$couponObj = $coupon->fetchObject();

			// if($couponObj->expiration_date )
			$current_date = new DateTime();

			// Convertendo a string recebida do MySQL para um objeto DateTime
			$expiration_date_obj = new DateTime($couponObj->expiration_date);

			if ($current_date > $expiration_date_obj)
				die(json_encode(["res" => "Desculpe, o cupom informado já expirou."]));


			die(json_encode(["res" => 1, "coupon" => [ 
				"code" => $couponObj->code,
				"discount_type" => $couponObj->discount_type,
				"discount_value" => $couponObj->discount_value,
				"expiration_date" => $couponObj->expiration_date
			]]));
		}
	});



	$router->get("/checkout/check-payment", function(){
		if(!isset($_SESSION["csa_order_id"]) OR empty($_SESSION["csa_order_id"]))
			die(json_encode(["res" => "Desculpe, não foi possível identificar o seu pedido."]));

		$User = new User;


		$getMembership = $User->getUserMembershipByOrderId($_SESSION["csa_order_id"]);

		if($getMembership->rowCount() < 1)
			die(json_encode(["res" => "Desculpe, não foi possível encontrar o seu pedido no banco de dados.", $_SESSION['csa_order_id']]));
		
		$membership = $getMembership->fetchAll(PDO::FETCH_OBJ)[0];

		die(json_encode(["res" => 1, "status" => $membership->status]));
	});