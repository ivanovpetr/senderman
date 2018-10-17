<?php

namespace App\Jobs;

use App\Services\Messengers\TelegramSender;

class SendTelegramMessageJob extends SendAbstractMessageJob
{
    /**
     * Send queued message via Sender Service
     *
     * @param TelegramSender $sender
     *
     * @return void
     */
    public function handle(TelegramSender $sender): void
    {
        if(!is_null($this->receiver) || !is_null($this->message)){
            $sender->send($this->message, $this->receiver);
        }
    }
}
