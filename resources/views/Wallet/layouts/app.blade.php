<!DOCTYPE html>
<html lang="en">

    @section('htmlheader')
    @include('Wallet.layouts.partials.htmlheader')

    @show
    <body>
         <div id="App" class="App sidebar-compact-tablet -sidebar-compact-desktop">
             
            <div class="HeaderContainer">
                @section('mainheader')
                @include('Wallet.layouts.partials.mainheader')
            </div>
             
            <div class="SidebarContainer">
                <aside class="AppSidebar">
                    @section('sidebar')
                    @include('Wallet.layouts.partials.sidebar')
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
                @include('Wallet.layouts.partials.footer')
            </div>
        
        </div>

        @section('scripts')
        @include('Wallet.layouts.partials.scripts')

        @show

    </body>
</html>
