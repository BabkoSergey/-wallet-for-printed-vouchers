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
        
        <a href="{{ url('/adminpanel') }}" class="NavLink {{ Request::is('adminpanel/dashboard') || Request::is('adminpanel') ? '-active' : '' }}">
            <i class="icon-home NavIcon"></i>
            <span> {{ __('Dashboard') }} </span>
        </a>
        
        @if(Auth::user()->hasPermissionTo('role-list'))
        <a href="{{ route('roles.index') }}" class="NavLink {{ Request::is('adminpanel/roles') ? '-active' : '' }}">
            <i class="icon-user NavIcon"></i>
            <span> {{ __('Manage Role') }} </span>
        </a>
        @endif
        
        @if(Auth::user()->hasPermissionTo('user-list'))
        <a href="{{ route('users.index') }}" class="NavLink {{ Request::is('adminpanel/users') ? '-active' : '' }}">
            <i class="icon-people NavIcon"></i>
            <span> {{ __('Users') }} </span>
        </a>
        @endif
        
        @if(Auth::user()->hasPermissionTo('reseller-list'))
        <a href="{{ route('resellers.index') }}" class="NavLink {{ Request::is('adminpanel/resellers') ? '-active' : '' }}">
            <i class="icon-briefcase NavIcon"></i>
            <span> {{ __('Resellers') }} </span>
        </a>
        @endif
        
        @if(Auth::user()->hasPermissionTo('voucher-list'))
        <a href="{{ route('vouchers.index') }}" class="NavLink {{ Request::is('adminpanel/vouchers') ? '-active' : '' }}">
            <i class="icon-credit-card NavIcon"></i>
            <span> {{ __('Vouchers') }} </span>
        </a>
        @endif
        
        @if(Auth::user()->hasPermissionTo('voucher-type-list'))
        <a href="{{ route('voucherprice.index') }}" class="NavLink {{ Request::is('adminpanel/voucherprice') ? '-active' : '' }}">
            <i class="icon-pencil NavIcon"></i>
            <span> {{ __('Voucher Prices') }} </span>
        </a>
        @endif
        
        @if(Auth::user()->hasPermissionTo('apikey-list') || Auth::user()->hasPermissionTo('portal-list'))
        <div class="NavGroup ">
            <a href="" class="NavLink {{ Request::is('adminpanel/settings_portal') || Request::is('adminpanel/portal') || Request::is('adminpanel/requests/portal') ? '-active' : '' }}">
                <i class="icon-directions NavIcon"></i>
                <p class="badge badge-danger">{{$notis['portal']}}</p>
                <span> {{ __('Portals') }} </span>
            </a>
            <nav class="Nav">
                <div class="CompactNavGroupHeader">
                    <h4 class="NavTitle"> {{ __('Portals') }} </h4>
                    <a href="" class="Button -dismiss DismissBtn">
                        <i class="icon-close Icon"></i>
                    </a>
                </div>
                @if(Auth::user()->hasPermissionTo('portal-list'))
                <a href="{{ route('portal.index') }}" class="NavLink "> {{ __('Portals List') }} </a>
                @endif
                
                @if(Auth::user()->hasPermissionTo('portal-edit'))
                <a href="{{ url('adminpanel/requests/portal') }}" class="NavLink "> {{ __('Addition Requests') }} </a>
                @endif
                
                @if(Auth::user()->hasPermissionTo('portal-create'))
                <a href="{{ url('adminpanel/settings_portal') }}" class="NavLink "> {{ __('Settings') }} </a>
                @endif
                
            </nav>
        </div>        
        
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