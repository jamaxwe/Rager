<x-mail::message>
    Good Day!
    {{ $order->fname }} {{ $order->lname }}

    Your order with tracking number 
    Tracking Number: {{ $order->tracking_no }} is being proccess!
    
    Track your order at
    http://127.0.0.1:8000/track-order
    

    Thanks for choosing
    Rager Clothing!
</x-mail::message>
