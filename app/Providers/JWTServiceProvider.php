<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class JWTServiceProvider extends ServiceProvider
{
    /**
     * Register JWT configuration
     */
    public function register()
    {
        $this->app['config']->set('jwt',[
            'secret_key' => 'kekius',
            'algo' => 'sha256'
        ]);
        $this->app->bind(\Lcobucci\JWT\Signer::class, \Lcobucci\JWT\Signer\Hmac\Sha256::class);
    }
}