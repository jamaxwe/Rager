<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Models\Newsletter;

class NewItemAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $subscriber;

    public function __construct(Product $product, Newsletter $subscriber )
    {
        $this->product = $product;
        $this->subscriber = $subscriber;
    }
    

    public function build(Newsletter $subscriber)
{
    return $this->markdown('emails.newitemnotification')
                ->subject('New Item Added to Our Shop')
                ->with([
                    'productName' => $this->product->item_name,
                    'productDescription' => $this->product->description,
                    'productPrice' => $this->product->price,
                    'productUrl' => route('user.preview', $this->product->id),
                ])->to($this->subscriber->email);
}

    
}