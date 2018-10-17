<?php

namespace App\Services;


use Carbon\Carbon;

class MessageManager
{
    /**
     * Create and dispatch message job
     *
     * @param string $message
     * @param string $receiver
     * @param array $messengers
     * @param Carbon|null $time
     * @return bool
     */
    public function enqueueMessage(string $message, string $receiver, array $messengers, Carbon $time = null):bool
    {
        foreach ($messengers as $m){
            $job = app()
                ->make('senderman.'.$m.'.job',["message" => $message, "receiver" => $receiver])
                ->onQueue('messages');
            if(!is_null($time)){
                $job->delay($time);
            }
            dispatch($job);

        }
        return false;
    }
}