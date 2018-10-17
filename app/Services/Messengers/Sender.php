<?php

namespace App\Services\Messengers;

interface Sender
{
    /**
     * Send message
     *
     * @param string $message
     * @param string $receiver
     * @return bool
     */
    public function send(string $message, string $receiver):bool;
}