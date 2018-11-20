@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Voucher Price') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Voucher Price') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        {{$vouchertype->price}}
                    </div>

                    <div class="col-md-6 -text-right">
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('voucherprice.index') }}"> {{ __('Back to Voucher Prices List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <div class="row">
<!--                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {{$vouchertype->name}}                                    
                                </div>
                            </div>-->
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Price:</strong>
                                    {{$vouchertype->price}}
                                </div>
                            </div>                                                        
<!--                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Validity, days:</strong>
                                    {{$vouchertype->validity}}
                                </div>
                            </div>                            -->
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection