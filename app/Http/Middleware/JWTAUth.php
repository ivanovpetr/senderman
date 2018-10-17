<?php

namespace App\Http\Middleware;

use App\JWT\Exceptions\InvalidTokenException;
use App\JWT\JWT;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JWTAUth
{

    protected $jwt;

    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Authenticate and authorize incoming jwt
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */

    public function handle(Request $request, Closure $next): Closure
    {
        Log::info($request->header('Authorization'));

        if(!$authorization = $request->header('Authorization')){
            throw new UnauthorizedHttpException('','Authorization header not provided');
        }

        $jwt = substr($authorization, strlen('Bearer '));

        try{
            $subject = $this->jwt->getSubject($jwt);
        }catch (InvalidTokenException $e){
            throw new UnauthorizedHttpException('', 'Unauthorized: '.$e->getMessage());
        }

        if(!$subject->can('enqueue_message')){
            throw new AccessDeniedHttpException('Access denied.');
        }

        return $next($request);
    }
}
