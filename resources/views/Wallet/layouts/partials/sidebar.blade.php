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
        
        @if(Auth::user()->hasPermissionTo('analitics'))
        <a href="{{ url('/wallet') }}" class="NavLink {{ Request::is('wallet/dashboard') || Request::is('wallet') ? '-active' : '' }}">
            <i class="icon-home NavIcon"></i>
            <span> {{ __('Dashboard') }} </span>
        </a>
        @endif
        
        <a href="{{ url('wallet/reseller') }}" class="NavLink {{ Request::is('wallet/reseller') ? '-active' : '' }}">
            <i class="icon-briefcase NavIcon"></i>
            <span> {{ __('Reseller') }} </span>
        </a>
        
        @if(Auth::user()->hasPermissionTo('reseller-user-list'))
        <a href="{{ url('wallet/users') }}" class="NavLink {{ Request::is('wallet/users') ? '-active' : '' }}">
            <i class="icon-people NavIcon"></i>
            <span> {{ __('Users') }} </span>
        </a>
        @endif
                        
        @if(Auth::user()->hasPermissionTo('reseller-voucher-list'))
        <a href="{{ url('wallet/vouchers') }}" class="NavLink {{ Request::is('wallet/vouchers') ? '-active' : '' }}">
            <i class="icon-credit-card NavIcon"></i>
            <span> {{ __('Vouchers') }} </span>
        </a>
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