<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct($user, $order)
    {
        $this->user = $user;
        $this->order = $order;
    }
}
