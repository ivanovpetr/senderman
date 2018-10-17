<?php

namespace App\Services\Messengers;

use Illuminate\Support\Facades\Log;

/**
 * Boilerplate of service that sends messages to Telegram
 * @package App\Services\Messengers
 */
class TelegramSender implements Sender
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
        Log::info("Sending telegram message: \"{$message}\" to: {$receiver}");
        return true;
    }

}