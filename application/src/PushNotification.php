<?php

class PushNotification
{
    private string $appId;
    private string $authorization;
    private array $payload = [];

    public function __construct(string $appId, string $authorization)
    {
        $this->appId = $appId;
        $this->authorization = $authorization;
    }

    public function setPayload(array $data): void
    {
        $this->payload = array_merge(['app_id' => $this->appId], $data);
    }

    public function sendNotification(): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.onesignal.com/notifications?c=push",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($this->payload),
            CURLOPT_HTTPHEADER => [
                "Authorization: {$this->authorization}",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #: " . $err;
        }

        return $response;
    }
}
