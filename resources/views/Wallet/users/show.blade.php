@extends('Wallet.layouts.app')

@section('htmlheader_title') {{ __('User') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('User') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        {{$user->name}}
                    </div>

                    <div class="col-md-6 -text-right">
                        <a class="btn btn-success  btn-sm" role="button" href="{{ url('/wallet/users') }}"> {{ __('Back to Users List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                                                                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {{$user->name}}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    {{$user->email}}
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Roles:</strong>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
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
