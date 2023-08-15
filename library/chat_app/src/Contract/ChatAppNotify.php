<?php

namespace Adideas\ChatApp\Contract;

interface ChatAppNotify
{
    public function __construct(ChatAppMessage $message);

    public function toChatApp(object $subject): string;
    public function via(object $notifiable): array;

    public function getMessage(): ChatAppMessage;
}
