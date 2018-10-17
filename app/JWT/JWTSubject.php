<?php

namespace App\JWT;

class JWTSubject
{
    /**
     * Subject roles
     *
     * @var array
     */
    private $roles = [];

    /**
     * Subject identifier
     *
     * @var string
     */
    private $identifier;

    /**
     * JWTSubject constructor.
     * @param string $identifier
     * @param array $roles
     */
    public function __construct($identifier, array $roles)
    {
        $this->identifier = $identifier;
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getIdentifier():string
    {
        return $this->identifier;
    }

    /**
     * Check existence subject specified role
     *
     * @param $role
     * @return bool
     */
    public function can($role):bool
    {
        return array_search($role,$this->roles) !== false;
    }
}