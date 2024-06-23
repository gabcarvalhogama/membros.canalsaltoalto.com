<?php 

    // require "application/autoload.php";

    // $pagarme = new PagarMe\Client('sk_33ca088d2f0643229336a8045280a2b8');
    // $transaction = $pagarme->transactions()->create([
    //     'amount' => 10,
    //     'payment_method' => 'Pix',
    //     'customer' => [
    //         'external_id' => $user_id,
    //         'name' => $_POST["f_firstname"]." ".$_POST["f_lastname"],
    //         'type' => 'individual',
    //         'country' => 'br',
    //         'documents' => [
    //           [
    //             'type' => 'cpf',
    //             'number' => $_POST["f_cpf"]
    //           ]
    //         ],
    //         'phone_numbers' => [ '+55'.preg_replace('/\D/', '', $_POST["f_cellphone"]) ],
    //         'email' => $_POST["f_email"]
    //     ],
    //     'items' => [
    //         [
    //           'id' => '1',
    //           'title' => 'Seja Membro',
    //           'unit_price' => 300,
    //           'quantity' => 1,
    //           'tangible' => true
    //         ]
    //     ]
    // ]);

            $imageFolder = "uploads/".date("Y\/m\/");

            echo $imageFolder;

 ?>