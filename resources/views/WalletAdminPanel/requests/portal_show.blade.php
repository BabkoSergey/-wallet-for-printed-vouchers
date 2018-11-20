@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Portal Request') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Portal Request') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        {{ __('Request') }}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 -text-right">
                        <a class="btn btn-success  btn-sm" role="button" href="{{ url('adminpanel/requests/portal') }}"> {{ __('Back to Portal Requests List') }}</a>                        
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
                                    {{$request->request->name}}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Host:</strong>
                                    <a href="{{$request->request->host}}" target="_blank">{{$request->request->host}}</a>
                                </div>
                            </div>                                                                                         
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    {{$request->request->description}}
                                </div>
                            </div>                                                                                         
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    <b>{{$request->status}}</b>
                                    @if(Auth::user()->hasPermissionTo('portal-create'))
                                    <a class="btn btn-success btn-sm pull-right" style="margin-left: 10px;" role="button" href="{{ url('adminpanel/requests/portal') }}/{{$request->id}}/approve"> {{ __('Approve') }}</a>                        
                                    @endif
                                    @if(Auth::user()->hasPermissionTo('portal-delete') && $request->status == 'pending')
                                    <a class="btn btn-danger btn-sm pull-right" style="margin-left: 10px;" role="button" href="{{ url('adminpanel/requests/portal') }}/{{$request->id}}/disable"> {{ __('Disable') }}</a>                        
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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">
                    <div class="col-md-12">                        
                        {{ __('User') }}
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
