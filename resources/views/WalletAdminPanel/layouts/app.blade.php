<!DOCTYPE html>
<html lang="en">

    @section('htmlheader')
    @include('WalletAdminPanel.layouts.partials.htmlheader')

    @show
    <body>
         <div id="App" class="App sidebar-compact-tablet -sidebar-compact-desktop">
             
            <div class="HeaderContainer">
                @section('mainheader')
                @include('WalletAdminPanel.layouts.partials.mainheader')
            </div>
             
            <div class="SidebarContainer">
                <aside class="AppSidebar">
                    @section('sidebar')
                    @include('WalletAdminPanel.layouts.partials.sidebar')
                </aside>                
            </div>
        
            <div class="SidebarOverlay" id="SidebarOverlay"></div>
            
            <div class="ContentContainer Dashboard">
                <div class="Content">
                    <article class="Page Dashboard">
                        <div class="PageContainer">
                            @yield('main-content')
                        </div>
                    </article>                
                </div>    
            </div>
            
            <div class="FooterContainer">
                @include('WalletAdminPanel.layouts.partials.footer')
            </div>
        
        </div>

        @section('scripts')
        @include('WalletAdminPanel.layouts.partials.scripts')

        @show

    </body>
</html>
