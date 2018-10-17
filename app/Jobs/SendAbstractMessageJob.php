<?php

namespace App\Jobs;

use App\Services\Messengers\Sender;

abstract class SendAbstractMessageJob extends Job
{
    protected $receiver;

    protected $message;

    public $tries = 5;

    /**
     * SendAbstractMessageJob constructor.
     * @param $receiver
     */
    public function __construct(string $message = null, string $receiver = null)
    {
        $this->receiver = $receiver;
        $this->message = $message;
    }
}