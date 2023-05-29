<?php

namespace App\Services;

use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;
use GuzzleHttp;

class OneSignalService
{
    protected $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken("ZTQwOTE2OWItMzA1Ny00M2VkLTk5N2UtOTgzMTZkOGU2Yjhj")
            ->setUserKeyToken("ZGY2Mjk2OWYtNTEyYS00MmE5LWJhY2QtYTMzNjIyYjY0YTI3");

        $this->apiInstance = new DefaultApi(
            new GuzzleHttp\Client(),
            $config
        );
    }

    public function sendNotification($content)
    {
        // Create notification model
        $stringMap = new StringMap();
        $stringMap->setEn($content);

        $notification = new Notification();
        $notification->setAppId("d2817b7a-06b0-4bd4-b957-979697f6be8a");
        $notification->setContents($stringMap);
        $notification->setIncludedSegments(['Subscribed Users']);

        // Send the notification
        $result = $this->apiInstance->createNotification($notification);

        return $result;
    }
}