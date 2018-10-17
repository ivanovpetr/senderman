<?php

namespace App\Services\Messengers;

use Illuminate\Support\Facades\Log;

/**
 * Boilerplate of service that sends messages to Viber
 * @package App\Services\Messengers
 */
class ViberSender implements Sender
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
        // отправить сообщение по вайбер
        Log::info("Sending viber message: \"{$message}\" to: {$receiver}");
        return true;
    }
}