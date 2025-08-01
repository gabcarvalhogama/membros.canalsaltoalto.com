<?php

class PushNotification
{
    private string $appId = "fbd0925d-d9e9-4ad1-b628-29d2fdce12b7";
    private string $authorization = "Basic os_v2_app_7pijexoz5ffndnrifhjp3tqsw6lgquyi3ugunzfbz5xtnchc4g4ilegadhaezuqsmrteug64objqtipzpoo5w4wu5bqkxdjkxtok7vq";
    private array $payload = [];

    // public function __construct(string $appId, string $authorization)
    // {
    //     $this->appId = $appId;
    //     $this->authorization = $authorization;
    // }

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
