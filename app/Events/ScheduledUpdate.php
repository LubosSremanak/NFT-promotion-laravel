<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScheduledUpdate
{
    use Dispatchable, SerializesModels;


    public string $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->$type = $type;
    }
}
