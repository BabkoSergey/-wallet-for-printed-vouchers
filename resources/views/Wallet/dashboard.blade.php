@extends('Wallet.layouts.app')

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
<section class="vbox">
	<section class="hbox stretch">
		<section id="content">
			<section class="hbox stretch">
				<section>
					<section class="vbox">
						<section class="scrollable padder">              

							<div class="row">
								<div class="col-sm-12">
									<div class="panel b-a">
										<div class="row m-n">
											<div class="col-md-3 b-b b-r">
												<a href="#" class="block padder-v hover">
													<span class="i-s i-s-2x pull-left m-r-sm">
														<i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
														<i class="i i-stack i-1x text-white"></i>
													</span>
													<span class="clear">
														<span class="h3 block m-t-xs text-danger">{{ $vaucher_count }}</span>
														<small class="text-muted text-u-c">{{ __('Total vouchers') }}</small>
													</span>
												</a>
											</div>
											<div class="col-md-3 b-b">
												<a href="#" class="block padder-v hover">
													<span class="i-s i-s-2x pull-left m-r-sm">
														<i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
														<i class="i i-users2 i-sm text-white"></i>
													</span>
													<span class="clear">
														<span class="h3 block m-t-xs text-success">{{ $total_users }}</span>
														<small class="text-muted text-u-c">{{ __('Total users') }}</small>
													</span>
												</a>
											</div>
											<div class="col-md-3 b-b b-r">
												<a href="#" class="block padder-v hover">
													<span class="i-s i-s-2x pull-left m-r-sm">
														<i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
														<i class="i  i-checked i-sm text-white"></i>
													</span>
													<span class="clear">
														<span class="h3 block m-t-xs text-info">{{ $vaucher_count_sold }}</span>	
														<small class="text-muted text-u-c">{{ __('Vouchers sold') }}</small>
													</span>
												</a>
											</div>
											<div class="col-md-3 b-b">
												<a href="#" class="block padder-v hover">
													<span class="i-s i-s-2x pull-left m-r-sm">
														<i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
														<i class="i i-alarm i-sm text-white"></i>
													</span>
													<span class="clear">
														<span class="h3 block m-t-xs text-primary">{{ $vaucher_count_active }}</span>
														<small class="text-muted text-u-c">{{ __('Vouchers active') }}</small>
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

@endsection


