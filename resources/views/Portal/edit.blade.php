@extends('Portal.layouts.app')

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
                        <a class="btn btn-success  btn-sm" role="button" href="{{url('/portalpanel')}}"> {{ __('Back to Dashboard') }}</a>                        
                    </div>

                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">   
                        <form method="POST" action="{{url('/portalpanel/portal/update')}}/{{$portal->id}}" accept-charset="UTF-8" autocomplete="off">
                        @csrf                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>                                    
                                    <input placeholder="Portal name" class="form-control" name="name" type="text" value="@if($portal){{$portal->name}}@endif">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Url:</strong>                                    
                                    <input placeholder="http://your.host" class="form-control" name="host" type="text" value="@if($portal){{$portal->host}}@endif">
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>                                    
                                    <textarea class="form-control" rows="2" name="description" cols="50">@if($portal){{$portal->description}}@endif</textarea>
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>                        
                        </form>                                                
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
                $.get("{{ url('portalpanel/apikey') }}"+"/"+$(this).attr('data-portal'))
                    .done(function (data) {						
                        $('.api-hide').text(data);
                    })
                .fail(function (data) {
                    $('.api-hide').text(data.responseJSON);
                }); 
            });
            
            $(document).on('click','.jq_api_change',function (e){   
                e.preventDefault(); 
                $.get("{{ url('portalpanel/apikey') }}"+"/"+$(this).attr('data-portal')+'/change')
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
