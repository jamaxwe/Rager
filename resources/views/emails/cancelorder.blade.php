<x-mail::message>
    

        Good day! {{ $order->fname }} {{ $order->lname }},
        
        We are pleased to inform you that your order with tracking number of {{ $order->tracking_no }}
        has been Cancelled.


        
        Please Ensure that the informations you have provided are correct.
        If you paid with Gcash please CLEARLY show the reference number in the 
        picture of the receipt.
        
        
        Thank you for choosing
        Rager Clothing!
</x-mail::message>