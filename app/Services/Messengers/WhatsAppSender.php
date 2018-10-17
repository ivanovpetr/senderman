<?php

namespace App\Services\Messengers;

use Illuminate\Support\Facades\Log;

/**
 * Boilerplate of service that sends messages to WhatsApp
 * @package App\Services\Messengers
 */
class WhatsAppSender implements Sender
{
    /**
     * Send message
     *
     * @param string $message
     * @param string $receiver
     * @return bool
     */
    public function send(string $message, string $receiver): bool
    {
        //отправить сообщение в вайбер
        Log::info("Sending whatsapp message: \"{$message}\" to: {$receiver}");
        return true;
    }

}