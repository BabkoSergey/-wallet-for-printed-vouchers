@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Edit Portal') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Edit Portal') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        @if ($portal->status == 'disabled')
                            {{ __('Status') }}: <label class="badge badge-danger" style="margin:0 5px;"> {{ __($portal->status) }} </label>
                        @endif
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
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('portal.index') }}"> {{ __('Back to Portal List') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">    
                        {!! Form::model($portal, ['method' => 'PATCH','route' => ['portal.update', $portal->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Url:</strong>
                                    {!! Form::text('host', null, array('placeholder' => 'http://your.host','class' => 'form-control')) !!}
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    {!! Form::textarea('description',null,['class'=>'form-control', 'rows' => 2]) !!}                                    
                                </div>
                            </div>                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    {!! Form::select('status', ['active'=>'active','disabled'=>'disabled'],[$portal->status=>$portal->status], array('class' => 'form-control','single')) !!}                                            
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>                        
                        {!! Form::close() !!}
                                                
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
                        {{ __('API KEY') }}
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">                            
                        <div class="row">                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group api-block">
                                    <strong>API Key:</strong>
                                    <span class="api-hide">XXXXXXXXXXXXXXX</span>                                    
                                    <button class="btn btn-info jq_api_get" data-portal="{{$portal->id}}"><i class="icon-eye icons"></i></button>
                                    <button class="btn btn-danger jq_api_change" data-portal="{{$portal->id}}"><i class="icon-pencil icons"></i></button>
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
        $(function () {
            
            $(document).on('click','.jq_api_get',function (e){   
                e.preventDefault(); 
                $.get("{{ url('adminpanel/apikey') }}"+"/"+$(this).attr('data-portal'))
                    .done(function (data) {						
                        $('.api-hide').text(data);
                    })
                .fail(function (data) {
                    $('.api-hide').text(data.responseJSON);
                }); 
            });
            
            $(document).on('click','.jq_api_change',function (e){   
                e.preventDefault(); 
                $.get("{{ url('adminpanel/apikey') }}"+"/"+$(this).attr('data-portal')+'/change')
                    .done(function (data) {						
                        $('.api-hide').text(data);
                    })
                .fail(function (data) {
                    $('.api-hide').text(data.responseJSON);
                }); 
            });
            
        });
    </script>
    
@endpush
