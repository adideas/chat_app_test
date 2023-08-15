<?php

namespace Adideas\ChatApp\ChatApp\Channel;

use Adideas\ChatApp\ChatApp\API\MessageText;
use Adideas\ChatApp\Contract\ChatAppPhone;
use Adideas\ChatApp\Contract\ChatAppNotify;
use Adideas\ChatApp\Events\EventCreateTaskSend;
use Adideas\ChatApp\Events\EventNotCreateTaskSend;
use Adideas\ChatApp\Exception\WrongInterfaceException;
use Adideas\ChatApp\Models\ChatAppLicense;
use Adideas\ChatApp\Models\ChatAppToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use Illuminate\Notifications\Notification;

class ChatAppChannel
{
    public function __construct(protected Dispatcher $dispatcher)
    {
    }

    public function send(Model $subject, Notification $notification): void
    {
        // not implements ChatAppPhone
        // not implements ChatAppPhone
        // not implements ChatAppPhone
        // not implements ChatAppPhone
        throw_if(!$subject instanceof ChatAppPhone, new WrongInterfaceException($subject));
        // not implements ChatAppPhone
        // not implements ChatAppPhone
        // not implements ChatAppPhone
        // not implements ChatAppPhone

        /** @noinspection PhpParamsInspection */
        $this->sendMessage($subject, $notification);
    }

    private function sendMessage(ChatAppPhone $subject, ChatAppNotify $notification): void
    {
        $text = $notification->toChatApp($subject);

        $token = ChatAppToken::first()->getToken();
        if (!$token) {
            $this->dispatcher->dispatch(new EventNotCreateTaskSend(
                $subject,
                $notification->getMessage(),
                'ChatApp Token not installed'
            ));
            return;
        }

        /** @var ChatAppLicense $license */
        $license = ChatAppLicense::where('isUse', 1)->first();
        if (!$license) {
            $this->dispatcher->dispatch(new EventNotCreateTaskSend(
                $subject,
                $notification->getMessage(),
                'ChatApp License not installed'
            ));
            return;
        }
        $licenseID = $license->getLicenseId();


        $api = new MessageText($token, $licenseID, $subject->getPhone(), $text);
        $tokenMessage = $api->run();
        if (!$tokenMessage) {
            $this->dispatcher->dispatch(new EventNotCreateTaskSend(
                $subject,
                $notification->getMessage(),
                'ChatApp Message not send'
            ));
            return;
        }

        $this->dispatcher->dispatch(new EventCreateTaskSend($subject, $notification->getMessage(), $tokenMessage));
    }
}
