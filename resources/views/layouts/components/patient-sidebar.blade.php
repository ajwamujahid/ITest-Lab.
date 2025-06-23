
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{url('index')}}" class="header-logo">
            <img src="{{asset('build/assets/images/brand-logos/desktop-logo.png')}}" alt="logo" class="desktop-logo">
            <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="toggle-logo">
            <img src="{{asset('build/assets/images/brand-logos/desktop-dark.png')}}" alt="logo" class="desktop-dark">
            <img src="{{asset('build/assets/images/brand-logos/toggle-dark.png')}}" alt="logo" class="toggle-dark">
            <img src="{{asset('build/assets/images/brand-logos/desktop-white.png')}}" alt="logo" class="desktop-white">
            <img src="{{asset('build/assets/images/brand-logos/toggle-white.png')}}" alt="logo" class="toggle-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
             <!-- Start::Patient Panel -->
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="bx bx-user-circle side-menu__icon"></i>
        <span class="side-menu__label">Patient Panel</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide side-menu__label1">
            <a href="javascript:void(0);">Patient Panel</a>
        </li>

        <!-- Test Form -->
        <li class="slide">
            <a href="{{ url('/patient/test-step1') }}" class="side-menu__item">
                Request Test
            </a>
        </li>

        <!-- Payments -->
        <li class="slide">
            <a href="{{ url('/patient/payments') }}" class="side-menu__item">
                Payments
            </a>
        </li>

        <!-- View Reports -->
        <li class="slide">
            <a href="{{ url('/patient/reports') }}" class="side-menu__item">
                View Reports
            </a>
        </li>
    </ul>
</li>
<!-- End::Patient Panel -->

             <!-- Start::Complain Section -->
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="bx bx-comment-error side-menu__icon"></i>
        <span class="side-menu__label">Complaints</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide side-menu__label1">
            <a href="javascript:void(0);">Complaints</a>
        </li>

        <!-- Lodge Complaint -->
        <li class="slide">
            <a href="{{ url('/complaints/create') }}" class="side-menu__item">Lodge Complaint</a>
        </li>

        <!-- View All Complaints -->
        <li class="slide">
            <a href="{{ url('/complaints') }}" class="side-menu__item">View My Complaints</a>
        </li>

        <!-- Filtered Complaint Statuses -->
        {{-- <li class="slide">
            <a href="{{ url('/complaints?status=in-progress') }}" class="side-menu__item">In-Progress</a>
        </li>
        <li class="slide">
            <a href="{{ url('/complaints?status=resolved') }}" class="side-menu__item">Resolved</a>
        </li>
        <li class="slide">
            <a href="{{ url('/complaints?status=rejected') }}" class="side-menu__item">Rejected</a>
        </li> --}}
    </ul>
</li>
<!-- End::Complain Section -->

                <!-- Start::slide__category -->
<li class="slide__category"><span class="category-name">Interactions</span></li>
<!-- End::slide__category -->
<li class="slide">
    <<a href="{{ url('/chat') }}"
        class="side-menu__item">
        <i class="bx bx-message-dots side-menu__icon"></i>
        <span class="side-menu__label">Chat Support</span>
    </a>
</li>

<!-- End::Chat Support -->
<!-- Start::Rider Test Management -->
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="bx bx-car side-menu__icon"></i>  <!-- changed icon for testing -->
        <span class="side-menu__label">Rider Tests</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide side-menu__label1">
            <a href="javascript:void(0);">Rider Tests</a>
        </li>
        <li class="slide">
            <a href="{{ route('patients.appointments') }}" class="side-menu__item">
                {{-- <i class="bx bx-calendar"></i> --}}
                <span>Coming Riders</span>
            </a>
        </li>
        
        {{-- <li class="slide">
            <a href="{{ url('/riders/review') }}" class="side-menu__item">Rider Review Section</a>
        </li> --}}
    </ul>
</li>

              <!-- Start::slide -->
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="bx bx-calendar-check side-menu__icon"></i>
        <span class="side-menu__label">Appointments</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide side-menu__label1">
            <a href="javascript:void(0);">Appointments</a>
        </li>
        {{-- <li class="slide">
            <a href="{{ route('appointments.index') }}" class="side-menu__item">All Appointments</a>
        </li> --}}
        <li class="slide">
            <a href="{{ route('appointments.physical') }}" class="side-menu__item">
             
                <span class="side-menu__label">Physical Appointments</span>
            </a>
        </li>
        
        <li class="slide">
            <a href="{{ url('appointments/schedule') }}" class="side-menu__item">Schedule Appointment</a>
        </li>
    
    </ul>
    <li class="slide">
        <a href="{{ route('patient.logout') }}" class="side-menu__item"
           onclick="event.preventDefault(); document.getElementById('patient-logout-form').submit();">
            <i class="bx bx-log-out side-menu__icon"></i>
            <span class="side-menu__label">Logout</span>
        </a>
    
        <form id="patient-logout-form" action="{{ route('patient.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</li>
<!-- End::slide -->

              

            </aside> 