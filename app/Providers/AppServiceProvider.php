<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     * @return void
     */
    public function register():void
    {
        $this->registerConfig();

        $this->registerBindings();
    }

    /**
     * Register app config
     * @return void
     */
    protected function registerConfig():void
    {
        $this->app['config']->set('senderman', [
            'supportedMessengers' => [
                'telegram',
                'viber',
                'whatsapp'
            ]
        ]);
    }

    /**
     * Register app bindings
     * @return void
     */
    protected function registerBindings():void
    {

        $this->app->bind('senderman.telegram', \App\Services\Messengers\TelegramSender::class);
        $this->app->bind('senderman.viber', \App\Services\Messengers\ViberSender::class);
        $this->app->bind('senderman.whatsapp', \App\Services\Messengers\WhatsAppSender::class);
        $this->app->bind('senderman.telegram.job', \App\Jobs\SendTelegramMessageJob::class);
        $this->app->bind('senderman.viber.job', \App\Jobs\SendViberMessageJob::class);
        $this->app->bind('senderman.whatsapp.job', \App\Jobs\SendWhatsAppMessageJob::class);
    }
}
