<?php

namespace App\Listeners;

use App\Events\ScheduledUpdate;

class ScheduleData
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ScheduledUpdate $event
     * @return void
     */
    public function handle(ScheduledUpdate $event)
    {
        error_log("dopici");
    }
}
