<?php
	$router->mount("/webhook", function() use ($router){
		$router->post("/payment/confirmation", function(){

            // {
            //     "invoice_slug": "abc123",
            //     "amount": 1000,
            //     "paid_amount": 1010,
            //     "installments": 1,
            //     "capture_method": "credit_card",
            //     "transaction_nsu": "UUID",
            //     "order_nsu": "UUID-do-pedido",
            //     "receipt_url": "https://comprovante.com/123",
            //     "items": [...]
            // }

            $data = json_decode(file_get_contents('php://input'), true);

            // grava payload do webhook em arquivo de log (adiciona, nunca sobrescreve)
            $logDir = __DIR__ . '/../storage/logs';
            if(!is_dir($logDir)){
                mkdir($logDir, 0755, true);
            }
            $logFile = $logDir . '/webhook_payments.log';

            $entry = [
                'timestamp' => date('c'),
                'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? null,
                'payload' => $data
            ];

            $json = json_encode($entry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            file_put_contents($logFile, $json . PHP_EOL, FILE_APPEND | LOCK_EX);

            if(empty($data["order_nsu"])){
                http_response_code(400);
                die(json_encode(["msg" => "Webhook received: obad gateway."]));
            }

            $Membership = new Membership;
            $getMembership = $Membership->getMembershipByOrderId($data["order_nsu"]);

            if($getMembership->rowCount() < 1)
                die(json_encode(["msg" => "Webhook received: order not found."]));


            $membership = $getMembership->fetchObject();
            if($membership->status == "paid")
                die(json_encode(["msg" => "Webhook received: membership already paid."]));
            // if($data["paid_amount"] < $membership->price)
            //     die(json_encode(["msg" => "Webhook received: paid amount is less than membership price."]));

            $User = new User;
            $getUser = $User->getUserById($membership->iduser);
            if($getUser->rowCount() < 1)
                die(json_encode(["msg" => "Webhook received: user not found."]));

            $user = $getUser->fetchObject();


            $starts_at = date("Y-m-d H:i:s");
            $dateTime = new DateTime($starts_at);
            $dateTime->add(new DateInterval('P365D'));
            $ends_at = $dateTime->format('Y-m-d H:i:s');

            if($User->updateMembershipByOrderId($data["order_nsu"], 'paid', $starts_at, $ends_at)){

                $name = $user->firstname;
                $email = $user->email;

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
                

                die(json_encode(["res" => 1]));
            }
            else{
                die(json_encode(["msg" => "Webhook received: not found order id on update."]));
            }
        });

    });