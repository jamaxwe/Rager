<x-mail::message>
    Your Order has been shipped!

        Good day! {{ $order->fname }} {{ $order->lname }},
        
        We are pleased to inform you that your order with tracking number of {{ $order->tracking_no }}
        is now being Shipped.
        
        
        Thank you for choosing
        Rager Clothing!
</x-mail::message>