<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\InvoiceCreated;
use App\Listeners\SendInvoiceToWhatsApp;
use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(WhatsAppService::class, function () {
            return new WhatsAppService(
                config('whatsapp.phone_number_id'),
                config('whatsapp.access_token')
            );
        });
    }

    public function boot(): void
    {
        Event::listen(
            InvoiceCreated::class,
            SendInvoiceToWhatsApp::class
        );
    }
}
