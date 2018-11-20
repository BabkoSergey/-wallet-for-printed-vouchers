<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    
<!--    <script src="{{ asset('js/app.js') }}" defer></script>
     Fonts 
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
     Styles 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
     Bootstrap core CSS     
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    Wallet Styles 
    <link href="{{ asset('assets/css/escrow.css') }}" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link href="{{ asset('assets/css/datepicker.css') }}" type="text/css">
    
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5a9be2e82326af0013ae4037&product=inline-share-buttons"></script>    
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
    
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
    
    

    @stack('styles')-->
    
    <!--Fonts--> 
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    
    <!--Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!--Bootstrap core CSS-->     
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!--Wallet Styles--> 
    
    <link href="{{ asset('assets/css/escrow.css') }}" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">     
    
    <link rel="shortcut icon" href="favicon.ico">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    
    <!--<link rel="stylesheet" href="{{ asset('assets/css/bundle.css') }}">-->
    <!--<link rel="stylesheet" href="{{ asset('assets/css/wallet.css') }}">-->        
    <link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
    
    @stack('styles')

    
</head>
<body>
        
        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container">                
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'JiL Wallet') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav mr-auto">    
                        @guest
                        
                        @else
                            @if(Auth::user())
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ url('/home') }}">{{ __('Home') }}</a>
                            </li>
                            @endif
                            
                            @if(Auth::user()->hasPermissionTo('admin_panel'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/adminpanel') }}">{{ __('Admin Panel') }}</a>
                            </li>
                            @endif
                            
                            @if(Auth::user()->hasPermissionTo('distributor'))
                            <li class="nav-item">
                                @if(Auth::user()->hasPermissionTo('analitics'))
                                <a class="nav-link" href="{{ url('/wallet') }}">{{ __('Wallet Panel') }}</a>
                                @else
                                <a class="nav-link" href="{{ url('/wallet/reseller') }}">{{ __('Wallet Panel') }}</a>
                                @endif
                            </li>                            
                            @endif
                            
                            @if(Auth::user()->hasPermissionTo('portal'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/portalpanel') }}">{{ __('Portal Panel') }}</a>
                            </li>
                            @endif
                            
                        @endguest
                    </ul>
                    <div class="form-inline my-2 my-lg-0">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-light my-2 my-sm-0 mr-3">{{ __('Login') }}</a>
                            <a href="{{ route('register') }}" class="btn btn-success my-2 my-sm-0">{{ __('Register') }}</a>                            
                        @else
                            
                            <div class="nav-user">
                                <a href="" class="my-2 my-sm-0 mr-3">
                                {{ Auth::user()->name }}
                                </a>                            
                            </div>                            
                            <a href="" class="btn btn-outline-light my-2 my-sm-0 mr-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            
                            <!--<a href="<php echo base_url('account/transactions'); ?>" class="btn btn-success my-2 my-sm-0"><php echo lang('users menu my_account'); ?></a>-->
                            
                        @endguest
                        
                    </div>

                </div>
            </div>
        </nav>
    
        <main>
            <div class="header-st mb-4">
                <div class="container">
                <!-- Content header row -->
                </div>
            </div>
            
            <div class="container">
                @yield('content')
            </div>

        </main>
    
        <footer>

            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <ul class="list-inline">
                                <!--<li class="list-inline-item mr-4"><a href="< echo base_url('agreement'); ?>">< echo lang('core button terms'); ?></a></li>-->                                
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <div class="dropdown dropup text-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <script src="{{ asset('assets/js/bundle.js') }}"></script>
    <script src="{{ asset('assets/js/form.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>

    <script>

    $.fn.datepicker.language['ru'] = {days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                today: 'Today',
                clear: 'Clear',
                dateFormat: 'yyyy-mm-dd',
                timeFormat: 'hh:ii',
                firstDay: 0};
    </script>

    <script>
        $(document).on('click', '.modalbttn', function () {
            $(".modalcontainer").fadeIn("slow");
            $(".modal").fadeIn("slow");
        });

        $(document).on('click', '.close', function () {
            $(".modalcontainer").fadeOut("slow");
            $(".modal").fadeOut("slow");
        });

        $(document).on('click', '.buttons', function () {
            $(".modalcontainer").fadeOut("slow");
            $(".modal").fadeOut("slow");
        });
    </script>

    @stack('scripts')
    
</body>
</html>