<?php

use App\Traits\CreateJWT;

class AuthTest extends TestCase
{
    use CreateJWT;

    public function testValidToken()
    {
        $this->post('api/sendMessages',[],[
            'Authorization' => 'Bearer '.$this->createValidToken()
        ]);
        $this->assertResponseStatus(422);
    }

    public function testExpiredJWT()
    {
        $this->post('api/sendMessages',[],[
            'Authorization' => 'Bearer '.$this->createExpiredToken()
        ]);
        $this->assertResponseStatus(401);
    }

    public function testWrongFormantJWT()
    {
        $this->post('api/sendMessages',[],[
            'Authorization' => 'Bearer '.$this->createTokenWithoutRoles()
        ]);
        $this->assertResponseStatus(401);
    }

    public function testNotAuthorizedJWT()
    {
        $this->post('api/sendMessages',[],[
            'Authorization' => 'Bearer '.$this->createTokenWithEmptyRoles()
        ]);
        $this->assertResponseStatus(403);
    }

    public function testPhonyJWT()
    {
        $this->post('api/sendMessages',[],[
            'Authorization' => 'Bearer '.$this->createTokenWithPhonySignature()
        ]);
        $this->assertResponseStatus(401);
    }

    public function testEmptyToken()
    {
        $this->post('api/sendMessages',[],[
            'Authorization' => 'Bearer '
        ]);
        $this->assertResponseStatus(401);
    }

    public function testInvalidJWT()
    {
        $this->post('api/sendMessages',[],[
            'Authorization' => 'Bearer d.a'
        ]);
        $this->assertResponseStatus(401);
    }

    public function testWithoutToken()
    {
        $this->post('api/sendMessages',[],[]);
        $this->assertResponseStatus(401);
    }
}