<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompleteOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ordercomplete')
                    ->subject('Order has been delivered')
                    ->with([
                        'trackingNumber' => $this->order->tracking_no,
                        'firstName' => $this->order->fname,
                        'lastName' => $this->order->lname,
                        // Add more data as needed
                    ])
                    ->to($this->order->email);
    }
}
