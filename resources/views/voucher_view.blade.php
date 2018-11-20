<!DOCTYPE html>
<html lang="en">

    <head>
        
        <title>Voucher</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="favicon.ico">        
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/voucher.css') }}"/>

    </head>

    <body>
        @foreach($vouchers as $key=>$voucher)
        
        <div class="voucher-block page-break">

            <div class="voucher-logo">
                <div class="is-logo-content">
                    <img src="{{ asset('assets/img/main-logo.jpg') }}">
                </div>                
            </div>

            <div class="voucher-date">
                <span class="is-date">{{$dates[$key]['date']}}</span>
                <span class="is-time">{{$dates[$key]['time']}}</span>
            </div>

            <div class="voucher-row-info">
                <span class="is-name">Distributeur:</span>
                <span class="is-value">MagicShop</span>
            </div>

            <div class="voucher-row-info">
                <span class="is-name">Point de vente:</span>
                <span class="is-value">@if($voucher->reseller) {{$voucher->reseller->name}} @else @endif</span>
            </div>

            <div class="voucher-row-info">
                <span class="is-name">Reference:</span>
                <span class="is-value">{{$voucher->reference}}</span>
            </div>

            <div class="voucher-row-info">
                <span class="is-name">Expire le:</span>
                <span class="is-value">@if($voucher->expire) {{$voucher->expire}} @else {{ __('Never') }} @endif</span>
            </div>
            
            <div class="voucher-row-info">
                <span class="is-name">Montant En TTC:</span>
                <span class="is-value">{{$voucher->price}} Da</span>
            </div>

            <div class="voucher-center">
                <span class="is-amount">{{$voucher->price}}</span>
            </div>

            <div class="voucher-logo voucher-logo-wallet">
                <div class="is-logo-content">
                    <img src="{{ asset('assets/img/main-logo.jpg') }}">
                </div>                
            </div>

            <div class="voucher-center">
                <span class="is-code-text">Code - <span class="arabic">الرمز</span></span>
            </div>
            
            <div class="voucher-center voucher-code">
                <span class="is-code">{{$voucher->voucher}}</span>
            </div>
            
            <div class="voucher-center voucher-description-ltr">
                <span class="is-description-ltr">
                    Veuillez enter le code dans l'application, un acces Internet est indispensable pour l'activation
                </span>                
            </div>
            
            <div class="voucher-center voucher-description-rtl">                
                <span class="is-description-rtl arabic">
                    يرجى إدخال الرمز في التطبيق
                </span>
            </div>
            <div class="voucher-center voucher-description-rtl">                
                <span class="is-description-rtl arabic">                  
                    ربط بالانترنت ضروري لتفعيل الكود`
                </span>
            </div>
            
            <div class="footer"></div>

        </div>
        
        @endforeach
    </body>
</html>
