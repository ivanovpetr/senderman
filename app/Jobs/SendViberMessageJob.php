<?php

namespace App\Jobs;

use App\Services\Messengers\ViberSender;

class SendViberMessageJob extends SendAbstractMessageJob
{
    /**
     * Send queued message via Sender Service
     *
     * @param ViberSender $sender
     *
     * @return void
     */
    public function handle(ViberSender $sender): void
    {
        if(!is_null($this->receiver) || !is_null($this->message)){
            $sender->send($this->message, $this->receiver);
        }
    }
}