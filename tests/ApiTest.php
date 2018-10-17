<?php

use App\Traits\CreateJWT;
use Carbon\Carbon;

class ApiTest extends TestCase
{
    use CreateJWT;
    //correct data
    public function testCorrectRequestBody()
    {
        $this->expectsJobs('App\Jobs\SendTelegramMessageJob');
        $this->post('api/sendMessages',[
            'message' => 'hello',
            'receivers' => ['+79951911212'],
            'messengers' => ['telegram']
        ],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(201);
    }

    public function testCorrectRequestBodyWithTime()
    {
        $this->expectsJobs('App\Jobs\SendTelegramMessageJob');
        $time = Carbon::now()->addMinutes(5)->format('d-m-Y H:i');
        $this->post('api/sendMessages',[
            'message' => 'hello',
            'receivers' => ['+79951911212'],
            'messengers' => ['telegram'],
            'timezone' => 'Europe/Moscow',
            'time' => $time
        ],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(201);
    }

    public function testCorrectRequestBodyToMultipleReceivers()
    {
        $this->expectsJobs('App\Jobs\SendTelegramMessageJob');
        $this->post('api/sendMessages',[
            'message' => 'hello',
            'receivers' => ['+79951911212','+79951911213'],
            'messengers' => ['telegram']
        ],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(201);

    }

    //incorrect data
    public function testEmptyMessageField()
    {
        $this->post('api/sendMessages',[
            'message' => '',
            'receivers' => ['+79951911212'],
            'messengers' => ['telegram']
        ],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(422);
    }

    public function testIncorrectPhoneNumber()
    {
        $this->post('api/sendMessages',[
            'message' => 'hello',
            'receivers' => ['privet'],
            'messengers' => ['telegram']
        ],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(422);
    }

    public function testUnsupportedMessenger()
    {
        $this->post('api/sendMessages',[
            'message' => 'hello',
            'receivers' => ['+79951911212'],
            'messengers' => ['unsupported']
        ],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(422);
    }

    public function testIncorrectTimezone()
    {
        $time = Carbon::now()->addMinutes(5)->format('d-m-Y H:i');
        $this->post('api/sendMessages',[
            'message' => 'hello',
            'receivers' => ['+79951911212'],
            'messengers' => ['telegram'],
            'time' => $time,
            'timezone' => 'incorrect/timezone'
        ],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(422);
    }

    public function testEmptyRequest()
    {
        $this->post('api/sendMessages',[],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(422);
    }

    public function testTimeWithoutTimezone()
    {
        $time = Carbon::now()->addMinutes(5)->format('d-m-Y H:i');
        $this->post('api/sendMessages',[
            'message' => 'hello',
            'receivers' => ['+79951911212'],
            'messengers' => ['telegram'],
            'time' => $time
        ],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(422);
    }
}