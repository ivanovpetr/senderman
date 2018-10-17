<?php

namespace App\Traits;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Token;

/**
 * Create different JWTs. Using especially for testing purposes
 * @package App\Traits
 */
trait CreateJWT
{
    /**
     * Create expired token
     *
     * @return Token
     */
    public function createExpiredToken(): Token
    {
        $token = (new Builder())->setIssuer('Big App')
            ->setAudience('Mobile Client')
            ->setSubject('4f1g23a12aa', true)
            ->setIssuedAt(time())
            ->setExpiration(time() - 30)
            ->set('roles', ['enqueue_message'])
            ->sign(app(\Lcobucci\JWT\Signer::class), config('jwt.secret_key'))->getToken();

        return $token;
    }

    /**
     * Create token without roles claim
     *
     * @return Token
     */
    public function createTokenWithoutRoles(): Token
    {
        $token = (new Builder())->setIssuer('Big App')
            ->setAudience('Mobile Client')
            ->setSubject('4f1g23a12aa', true)
            ->setIssuedAt(time())
            ->setExpiration(time() + 3600)
            ->sign(app(\Lcobucci\JWT\Signer::class), config('jwt.secret_key'))
            ->getToken();

        return $token;
    }

    /**
     * Create token with empty roles claim
     *
     * @return Token
     */
    public function createTokenWithEmptyRoles(): Token
    {
        $token = (new Builder())->setIssuer('Big App')
            ->setAudience('Mobile Client')
            ->setSubject('4f1g23a12aa', true)
            ->setIssuedAt(time())
            ->setExpiration(time() + 3600)
            ->set('roles', [])
            ->sign(app(\Lcobucci\JWT\Signer::class), config('jwt.secret_key'))
            ->getToken();

        return $token;
    }

    /**
     * Create token signed with incorrect secret key
     *
     * @return Token
     */
    public function createTokenWithPhonySignature(): Token
    {
        $token = (new Builder())->setIssuer('Big App')
            ->setAudience('Mobile Client')
            ->setSubject('4f1g23a12aa', true)
            ->setIssuedAt(time())
            ->setExpiration(time() + 3600)
            ->set('roles', ['enqueue_message'])
            ->sign(app(\Lcobucci\JWT\Signer::class), "phony")
            ->getToken();

        return $token;
    }

    /**
     * Create totally valid token
     *
     * @return Token
     */
    public function createValidToken(): Token
    {
        $token = (new Builder())->setIssuer('Big App') // Configures the issuer (iss claim)
            ->setAudience('Mobile Client') // Configures the audience (aud claim)
            ->setSubject('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
            ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
            ->set('roles', ['enqueue_message']) // Configures a new claim, called "uid"
            ->sign(app(\Lcobucci\JWT\Signer::class), config('jwt.secret_key'))
            ->getToken(); // Retrieves the generated token
        return $token;
    }
}