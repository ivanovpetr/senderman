<?php

namespace App\Http\Controllers;

use App\Traits\CreateJWT;
use Illuminate\Http\Response;

class TestController extends Controller
{
    use CreateJWT;

    /**
     * Return valid JWT for test purposes
     *
     * @return Response
     */
    public function getToken(): Response
    {
        return response((string) $this->createValidToken(),200);
    }
}