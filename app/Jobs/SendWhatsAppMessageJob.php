<?php

namespace App\Jobs;

use App\Services\Messengers\WhatsAppSender;

class SendWhatsAppMessageJob extends SendAbstractMessageJob
{
    /**
     * Send queued message via Sender Service
     *
     * @param WhatsAppSender $sender
     *
     * @return void
     */
    public function handle(WhatsAppSender $sender): void
    {
        if(!is_null($this->receiver) || !is_null($this->message)){
            $sender->send($this->message, $this->receiver);
        }
    }
}