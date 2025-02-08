<?php
class Checkout {

    private $api_key = 'sk_58b436886817489dbd5dd21075068a36:';
    // private $api_key = 'sk_test_a44dbc37771547dfb5a6017fda8d3e46:';
    private $base_url = 'https://api.pagar.me/core/v5/orders';

    public function createOrder($customerData, $paymentMethod, $itemData) {
        $data = [
            'customer' => $customerData,
            'payments' => $paymentMethod,
            'items' => [$itemData]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic " . base64_encode($this->api_key),
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);

        // var_dump(curl_getinfo($curl));

        $err = curl_error($curl);

        curl_close($curl);

        return json_decode($response);
    }

    public function getOrder($order_id) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->base_url."/".$order_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic " . base64_encode($this->api_key),
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }

    public static function translate($msg){
        if($msg == "The number field is not a valid card number")
            return "O número do cartão enviado não é válido";
        else
            return "";
    }
}
?>
