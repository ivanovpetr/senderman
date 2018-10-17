<?php

namespace App\JWT;

use App\JWT\Exceptions\InvalidTokenException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Token;

class JWT
{
    /**
     * Jwt Parser Instance
     *
     * @var Parser
     */
    private $jwtParser;

    /**
     * Jwt sign algorithm
     *
     * @var Signer
     */
    private $signer;

    /**
     * JWT constructor.
     * @param Parser $jwtParser
     * @param Signer $signer
     */
    public function __construct(Parser $jwtParser, Signer $signer)
    {
        $this->jwtParser = $jwtParser;
        $this->signer = $signer;
    }

    /**
     * Create Token instance from pure jwt string
     * @param string $jwtString
     * @return Token
     */
    private function parseToken(string $jwtString): Token
    {
        return $this->jwtParser->parse($jwtString);
    }

    /**
     * Verify token against secret key
     * @param Token $token
     * @return bool
     */
    private function verifyToken(Token $token): bool
    {
        return $token->verify($this->signer,config('jwt.secret_key'));
    }

    /**
     * Validate token and return subject instance
     * @param string $jwtString
     * @return JWTSubject
     * @throws InvalidTokenException
     */
    public function getSubject(string $jwtString): JWTSubject
    {
        try {
            $token = $this->parseToken($jwtString);
        } catch (\Exception $e) {
            throw new InvalidTokenException('Invalid Token.');
        }

        if(!$this->verifyToken($token)){
            throw new InvalidTokenException('Invalid signature.');
        }

        if($token->isExpired()){
            throw new InvalidTokenException('Token expired.');
        }

        if($token->hasClaim('roles') && is_array($token->getClaim('roles'))){
            return new JWTSubject($token->getClaim('sub'), $token->getClaim('roles'));
        }else{
            throw new InvalidTokenException('Roles claim does not exist in token');
        }
    }
}