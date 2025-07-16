<?php

use DateTime;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;

class PushNotification
{
    private string $APP_ID = 'fbd0925d-d9e9-4ad1-b628-29d2fdce12b7';
    private string $REST_API_KEY_TOKEN = 'os_v2_app_7pijexoz5ffndnrifhjp3tqsw6lgquyi3ugunzfbz5xtnchc4g4ilegadhaezuqsmrteug64objqtipzpoo5w4wu5bqkxdjkxtok7vq';
    private string $ORGANIZATION_API_KEY_TOKEN = 'os_v2_org_5pohvmsbfbglznhbb2v6iz4udgztavreix5uvgesb5vjw2lsmtqr4ufbkweosimstx2dbk5o4xvtlqk44pjta5c3yymvsmfgw6qzjyq';

    private DefaultApi $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setRestApiKeyToken($this->REST_API_KEY_TOKEN)
            ->setOrganizationApiKeyToken($this->ORGANIZATION_API_KEY_TOKEN);

        $this->apiInstance = new DefaultApi(
            new Client(),
            $config
        );
    }

    public function createNotification(string $enContent): Notification
    {
        $content = new StringMap();
        $content->setEn($enContent);

        $notification = new Notification();
        $notification->setAppId($this->APP_ID);
        $notification->setContents($content);
        $notification->setIncludedSegments(['Subscribed Users']);

        return $notification;
    }

    public function sendNotification(Notification $notification): ?Notification
    {
        try {
            return $this->apiInstance->createNotification($notification);
        } catch (\Exception $e) {
            echo 'Erro ao enviar notificação: ' . $e->getMessage() . PHP_EOL;
            return null;
        }
    }
}
