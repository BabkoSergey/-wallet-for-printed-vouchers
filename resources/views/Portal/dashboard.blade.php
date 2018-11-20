@extends('Portal.layouts.app')

@section('htmlheader_title') {{ __('Dashboard') }} @endsection
@push('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/bootstrap.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/animate.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/font-awesome.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/icon.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/font.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/forest_css/app.css') }}"/>
@endpush
@section('main-content')
<header class="PageHeader">
	<h1 class="PageTitle"> {{ __('Dashboard') }} </h1>
</header>

@if (session('status'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	{{ session('status') }}
	<button type="button" class="close button-close" data-dismiss="alert" aria-label="{{ __('Close') }}">
		<span aria-hidden="true"><i class="icon-close Icon"></i></span>
	</button>
</div>
@endif

@if(Auth::user()->portal) 
<section class="vbox">
    <section class="hbox stretch">
        <section id="content">
            <section class="hbox stretch">
                <section>
                    <section class="vbox">
                        <section class="scrollable padder">              

                            <div class="row">
                                <div class="col-sm-12" style="padding-left: 0;padding-right: 0;">
                                    <div class="panel b-a">
                                        <div class="row m-n">
                                            <div class="col-md-4 b-b b-r">
                                                <a href="#" class="block padder-v hover">
                                                    <span class="i-s i-s-2x pull-left m-r-sm">
                                                        <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                                        <i class="i i-stack i-1x text-white"></i>
                                                    </span>
                                                    <span class="clear">
                                                        <span class="h3 block m-t-xs text-danger">{{ $vaucher_count }}</span>
                                                        <small class="text-muted text-u-c">{{ __('Total vouchers activeted') }}</small>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="col-md-4 b-b b-r">
                                                <a href="#" class="block padder-v hover">
                                                    <span class="i-s i-s-2x pull-left m-r-sm">
                                                        <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                                        <i class="i i-users2 i-sm text-white"></i>
                                                    </span>
                                                    <span class="clear">
                                                        <span class="h3 block m-t-xs text-success">{{ $total_users }}</span>
                                                        <small class="text-muted text-u-c">{{ __('Total Users') }}</small>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="col-md-4 b-b b-r">
                                                <a href="#" class="block padder-v hover">
                                                    <span class="i-s i-s-2x pull-left m-r-sm">
                                                        <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                                        <i class="i  i-checked i-sm text-white"></i>
                                                    </span>
                                                    <span class="clear">
                                                        <span class="h3 block m-t-xs text-info">{{ $total_resellers }}</span>	
                                                        <small class="text-muted text-u-c">{{ __('Total Resellers') }}</small>
                                                    </span>
                                                </a>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>           
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">

            @if(!Auth::user()->portal) 
            <div class="card-title">
                <div class="row">
                    <div class="col-md-12">                        
                        {{ __('You do not have a registered portal.') }}
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ __('Your role involves managing the portal, but you do not have a registered portal. Please contact your administrator.') }}
                    </div>
                </div>
            </div>
            @else            
            <div class="card-title">
                <div class="row">
                    <div class="col-md-6">                        
                        {{Auth::user()->portal->name}}
                    </div>

                    <div class="col-md-6 -text-right">
                        <a class="btn btn-success  btn-sm" role="button" href="{{ url('portalpanel/portal/edit') }}"> {{ __('Edit') }}</a>                        
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
                                    {{Auth::user()->portal->name}}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Url:</strong>
                                    <a href="http://{{Auth::user()->portal->host}}" target="_blank">{{Auth::user()->portal->host}}</a>
                                </div>
                            </div>                                                                                    
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    {{Auth::user()->portal->description}}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Status:</strong>
                                    <label class="badge @if(Auth::user()->portal->status == 'active') badge-success @else badge-danger @endif">{{Auth::user()->portal->status}}</label>                                    
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group api-block">
                                    <strong>API KEY:</strong>
                                    <span class="api-hide">XXXXXXXXXXXXXXX</span>
                                    <button class="btn btn-info jq_api_get" data-portal="{{Auth::user()->portal->id}}"><i class="icon-eye icons"></i></button>
                                </div>
                            </div>                                                        
                        </div>                        
                    </div>
                </div>
                               
            </div>
       
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
    
@endpush

@push('scripts')

    <script>
        
        $(function () {
            
            $(document).on('click','.jq_api_get',function (){                                                        
                $.get("{{ url('portalpanel/apikey') }}"+"/"+$(this).attr('data-portal'))
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
