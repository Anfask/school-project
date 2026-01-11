<?php

namespace App\Listeners;

use App\Events\NewAdmissionQueryEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewAdmissionQueryAlert
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
    public function handle(NewAdmissionQueryEvent $event): void
    {
        //
    }
}
