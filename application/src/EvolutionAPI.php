<?php   

    class EvolutionAPI {
        const BASE_URL = 'https://evo.juridicopro.com/';
        const API_KEY = '659547E4H829315DGAIAAE39F0D57E33';
        const INSTANCE_NAME = 'canalsaltoalto';
        private $headers;
        public function __construct() {
            $this->headers = [
                'Content-Type: application/json',
                'apikey: ' . self::API_KEY
            ];
        }

        public function sendTextMessage($to, $message)
        {
            $url = self::BASE_URL . 'message/sendText/' . self::INSTANCE_NAME;
            $data = [
                'number' => $to,
                'text' => $message
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new Exception('Curl error: ' . $error);
            }

            return json_decode($response, true);
        }

    }