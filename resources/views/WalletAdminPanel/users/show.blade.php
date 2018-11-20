@extends('WalletAdminPanel.layouts.app')

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
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('users.index') }}"> {{ __('Back to Users List') }}</a>                        
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
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Permissions:</strong>
                                    @if(!empty($permissions))
                                        @foreach($permissions as $v)
                                            <label class="badge badge-info">{{ $v['name'] }}</label>
                                        @endforeach
                                    @endif
                                </div>
                            </div> 
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Reseller:</strong>
                                    @if(!empty($reseller))
                                        <div class="col-md-12" style="margin-left: 75px;">                                                                        
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
                                                        <label class="badge badge-secondary">{{$reseller->status}}</label>
                                                    </div>
                                                </div>                            
                                            </div>                        
                                        </div>
                                    @endif
                                </div>
                            </div> 
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Portal:</strong>
                                    @if(!empty($portal))
                                    <div class="col-md-12" style="margin-left: 75px;">                                                                        
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Name:</strong>
                                                    {{$portal->name}}                                    
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Host:</strong>
                                                    {{$portal->host}}
                                                </div>
                                            </div>       
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Description:</strong>
                                                    {{$portal->description}}
                                                </div>
                                            </div>                                                   
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Status:</strong>
                                                    <label class="badge badge-secondary">{{$portal->status}}</label>
                                                </div>
                                            </div>                            
                                        </div>                        
                                    </div>
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
