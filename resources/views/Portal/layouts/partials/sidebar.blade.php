<header class="SidebarHeader">
    <a class="LogoLink" href="{{ url('/home') }}">
        <div class="Logo">
            <title>logo</title>
            <img src="{{ asset('assets/img/admin_logo.png') }}" class="img-responsive">
        </div>
    </a>
    <h2 class="Title">
        <a class="Link" href="/">
            <span>JiL Wallet</span>
        </a>
    </h2>
</header>

<div class="SidebarContent">
    <nav class="SidebarNav" id="SidebarNav">
                
        <a href="{{ url('/portalpanel') }}" class="NavLink {{ Request::is('portalpanel/dashboard') || Request::is('portalpanel') ? '-active' : '' }}">
            <i class="icon-home NavIcon"></i>
            <span> {{ __('Dashboard') }} </span>
        </a>
        
        @if(Auth::user()->portal)
        <a href="{{ url('portalpanel/vouchers') }}" class="NavLink {{ Request::is('portalpanel/vouchers') ? '-active' : '' }}">
            <i class="icon-credit-card NavIcon"></i>
            <span> {{ __('Vouchers') }} </span>
        </a>
        
        <!--        <a href="{{ url('portalpanel/reseller') }}" class="NavLink {{ Request::is('portalpanel/reseller') ? '-active' : '' }}">
            <i class="icon-briefcase NavIcon"></i>
            <span> {{ __('Reseller') }} </span>
        </a>-->
        
        @endif
        
    </nav>
</div>

<footer id="SidebarFooter" class="SidebarFooter">
    <nav class="SidebarFooterNav">

        <!--<a href="http://justigniter.io/support" target="_blank" id="SidebarToggleHelpLink" class="NavLink LinkToggleHelp" data-placement="top" data-trigger="hover" title="Help">
            <i class="icon-question Icon" aria-hidden="true"></i>
        </a>--->
        
    </nav>
</footer>