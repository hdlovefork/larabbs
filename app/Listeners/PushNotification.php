<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;
use JPush\Client;

class PushNotification implements ShouldQueue
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Create the event listener.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        //
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param DatabaseNotification $notification
     * @return void
     */
    public function handle(DatabaseNotification $notification)
    {
//        if(app()->environment('local')){
//            return;
//        }

        $user = $notification->notifiable;

        // 没有 registration_id 的不推送
        if (!$user->registration_id) {
            return;
        }

        // 推送消息
        $this->client->push()
            ->setPlatform('all')
            ->addRegistrationId($user->registration_id)
            ->setNotificationAlert(strip_tags($notification->data['reply_content']))
            ->send();
    }
}
