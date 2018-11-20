@extends('WalletAdminPanel.layouts.app')

@section('htmlheader_title') {{ __('Portal') }} @endsection

@section('main-content')

<header class="PageHeader">
    <h1 class="PageTitle"> {{ __('Portal') }} </h1>
</header>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-title">
                <div class="row">

                    <div class="col-md-6">                        
                        {{$portal->name}}
                    </div>

                    <div class="col-md-6 -text-right">
                        <a class="btn btn-success  btn-sm" role="button" href="{{ route('portal.index') }}"> {{ __('Back to Portal List') }}</a>                        
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
                                    {{$portal->name}}                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Url:</strong>
                                    <a href="http://{{$portal->host}}" target="_blank">{{$portal->host}}</a>
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Portal admin:</strong>
                                    @if(!empty($users))
                                        @foreach($users as $u)
                                            <label class="badge badge-info bage_link">
                                                <a href="{{ url('adminpanel/users') }}/{{ $u['id'] }}">{{ $u['email'] }}</a>
                                            </label>                                            
                                        @endforeach
                                    @endif
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
                                    <label class="badge @if($portal->status == 'active') badge-success @else badge-danger @endif">{{$portal->status}}</label>                                    
                                </div>
                            </div>                                                        
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group api-block">
                                    <strong>API KEY:</strong>
                                    <span class="api-hide">XXXXXXXXXXXXXXX</span>
                                    <button class="btn btn-info jq_api_get" data-portal="{{$portal->id}}"><i class="icon-eye icons"></i></button>
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
            
            $(document).on('click','.jq_api_get',function (){                                                        
                $.get("{{ url('adminpanel/apikey') }}"+"/"+$(this).attr('data-portal'))
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