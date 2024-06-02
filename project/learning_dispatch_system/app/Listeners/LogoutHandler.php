<?php

namespace App\Listeners;

use App\Consts\UserEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use Inertia\Inertia;

class LogoutHandler
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if($event->guard === UserEnum::GENERAL->guardName()){
            Inertia::share('auth', null);
        }
    }
}
