<?php

namespace App\Listeners;

use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LogCookie
{
    /**
     * Handle the event.
     */
    public function handle(ResponseReceived $event): void
    {
        Log::info(Cookie::getQueuedCookies());
    }
}
