<!-- Rider Sidebar Updated Version -->
<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="{{ url('rider/dashboard') }}" class="header-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
        </a>
    </div>

    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> 
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> 
                </svg>
            </div>
            <ul class="main-menu">
                <li class="slide__category"><span class="category-name">Rider Dashboard</span></li>

                <li class="slide">
                    <a href="{{ url('/rider/assigned-patients') }}" class="side-menu__item">
                        <i class="bx bx-user-pin side-menu__icon"></i>
                        <span class="side-menu__label">Assigned Patients</span>
                    </a>
                </li>

                {{-- <li class="slide">
                    <a href="{{ route('rider.sample.status') }}" class="side-menu__item">
                        <i class="bx bx-test-tube side-menu__icon"></i>
                        <span class="side-menu__label">Sample Status</span>
                    </a>
                </li> --}}
                
                <li class="slide">
                    <a href="{{ url('/rider/sample-kits') }}" class="side-menu__item">
                        <i class="bx bx-package side-menu__icon"></i>
                        <span class="side-menu__label">Sample Kits (Used/Unused)</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="{{ url('/rider/sample-update') }}" class="side-menu__item">
                        <i class="bx bx-map-pin side-menu__icon"></i>
                        <span class="side-menu__label">Patient Visit Status</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="{{ route('rider.reviews') }}" class="side-menu__item">
                        <i class="bx bx-message-dots side-menu__icon"></i>
                        <span class="side-menu__label">Updated Patient Reviews</span>
                    </a>
                </li>
                
                <li class="slide">
                    <a href="#" class="side-menu__item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out side-menu__icon"></i>
                        <span class="side-menu__label">Logout</span>
                    </a>
                </li>
                
                
            </ul>
        </nav>
    </div>
</aside>
