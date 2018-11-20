@extends('layouts.app')

@section('Spatie')
     @if (isset($Spatie))
        <h2> {{$Spatie}} </h2> 
     @endif
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Portal</div>
                <div class="card-body justify-content-center">                                                                                
                    @if(Auth::user()->portal)
                    <h2>Portal: {{ Auth::user()->portal->name }}</h2>
                    <h2 class="text-center">
                        <a href="{{ url('/portalpanel') }}" class="btn btn-success">                    
                            <span> {{ __('Portal Dashboard') }} </span>
                        </a>
                    </h2>
                    @elseif($user_request)
                    <h2>Register the portal</h2>
                    <p>Register the portal and use the services of JiL Wallet</p>
                    @if(@is_confirm_portal)
                    <p>Need confirmation of the administrator to register a new portal</p>
                    @endif                    
                    <p>Your Request status is <b>"{{$user_request->status}}"</b></p>
                    <h2 class="text-center">
                        <a href="{{ url('/new_portal') }}" class="btn btn-success">                    
                            <span> {{ __('Edit Request') }} </span>
                        </a>
                    </h2>
                    @else
                    <h2>Register the portal</h2>
                    <p>Register the portal and use the services of JiL Wallet</p>
                    @if(@is_confirm_portal)
                    <p>Need confirmation of the administrator to register a new portal</p>
                    @endif 
                    <h2 class="text-center">
                        <a href="{{ url('/new_portal') }}" class="btn btn-success">                    
                            <span> {{ __('Register') }} </span>
                        </a>
                    </h2>
                    @endif
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
