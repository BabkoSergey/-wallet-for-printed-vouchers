@extends('Wallet.layouts.app')

@section('htmlheader_title') {{ __('Reseller') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Reseller') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        {{$reseller->name}}
                    </div>

<!--                    <div class="col-md-6 -text-right">
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('resellers.index') }}"> {{ __('Back to Reseller List') }}</a>                        
                    </div>-->

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {{$reseller->name}}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Address:</strong>
                                    {{$reseller->address}}
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    {{$reseller->status}}
                                </div>
                            </div>                            
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
