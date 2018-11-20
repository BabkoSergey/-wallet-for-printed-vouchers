@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Api Key') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Api Key') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        {{$api_key->api_host}}
                    </div>

                    <div class="col-md-6 -text-right">
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('apikey.index') }}"> {{ __('Back to Api Key List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Api Key:</strong>
                                    {{$api_key->api_key}}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Url:</strong>
                                    <a href="http://{{$api_key->api_host}}" target="_blank">{{$api_key->api_host}}</a>
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    {{$api_key->status}}
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

@push('styles')
    
@endpush

@push('scripts')

    <script>

    </script>
    
@endpush