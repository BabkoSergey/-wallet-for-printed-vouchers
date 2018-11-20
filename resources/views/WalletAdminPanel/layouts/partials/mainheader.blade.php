<header class="AppHeader">
    <div class="HeaderBlock">
        <button class="Button -primary ControlButton" id="HeaderSidebarToggleButton">
            <i class="icon-menu Icon" aria-hidden="true"></i>
        </button>
    </div>
    <div class="HeaderBlock">
        <nav class="ProfileNav">

            <div class="Dropdown NavItem Notifications">      
                <a href="" aria-expanded="false" class="NavLink NotificationsLink" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>                
            </div>
            
            <div class="Dropdown NavItem Profile">
                <!--<a href="" class="DropdownToggle NavLink ProfileLink">
                    <div class="Name"> Language <i class="fa fa-angle-down"></i> </div>
                </a>
                <div class="DropdownContent -end" aria-labelledby="session-language" id="session-language-dropdown">
                    <nav class="Nav">
                        <php foreach ($this->languages as $key => $name) : ?> 
                            <a href="#" rel="<php echo $key; ?>" class="DropdownToggle"> <php if ($key == $this->session->language) : ?> <i class="fa fa-check selected-session-language"></i> <php endif; ?> <php echo $name; ?></a>
                        <php endforeach; ?>
                    </nav>
                </div>-->
            </div>
            
        </nav>
    </div>
</header>