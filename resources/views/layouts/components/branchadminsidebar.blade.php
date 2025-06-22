<aside class="app-sidebar sticky" id="sidebar">

    <!-- Sidebar Header -->
    <div class="main-sidebar-header">
        <a href="{{ url('/branchadmin/dashboard') }}" class="header-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
        </a>
    </div>

    <!-- Main Sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>

            <ul class="main-menu">

                <!-- Category -->
                <li class="slide__category"><span class="category-name">Branch Admin</span></li>

                <!-- Dashboard -->
                <li class="slide">
                    <a href="{{ url('/branchadmin/dashboard') }}" class="side-menu__item">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <!-- Test Management -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-flask side-menu__icon"></i>
                        <span class="side-menu__label">Test Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide"><a href="{{ route('branchadmin.tests.pending') }}" class="side-menu__item">⏳ Pending Tests</a></li>
                        <li class="slide"><a href="{{ route('branchadmin.tests.completed') }}" class="side-menu__item">✅ Completed Tests</a></li>
                        <li class="slide"><a href="{{ route('branchadmin.tests.all')  }}" class="side-menu__item">📋 All Tests</a></li>
                    </ul>
                </li>
                {{-- <a href="{{ route('branchadmin.patients.index') }}" class="side-menu__item">
                    <i class="bx bx-calendar side-menu__icon"></i>
                    <span class="side-menu__label">Appointments</span>
                </a>
                 --}}
                 <li class="slide">
                    <a href="{{ route('branchadmin.appointments.index') }}" class="side-menu__item">
                        <i class="bx bx-calendar side-menu__icon"></i>
                        <span class="side-menu__label">Manage Appointments</span>
                    </a>
                </li>
                
                <!-- Reports -->
                {{-- <li class="slide">
                    <a href="{{ url('/branchadmin/reports') }}" class="side-menu__item">
                        <i class="bx bx-file side-menu__icon"></i>
                        <span class="side-menu__label">Reports</span>
                    </a>
                </li> --}}
                <!-- Reports -->
  

<li class="slide">
    <a href="{{ url('/branchadmin/report/profit-loss') }}" class="side-menu__item">
        <i class="bx bx-bar-chart side-menu__icon"></i>
        <span class="side-menu__label">Profit & Loss</span>
    </a>
</li>
<li class="slide">
    <a href="{{ url('/branchadmin/report/income') }}" class="side-menu__item">
        <i class="bx bx-wallet side-menu__icon"></i>
        <span class="side-menu__label">Income Report</span>
    </a>
</li>
<li class="slide">
    <a href="{{ url('/branchadmin/report/expenses') }}" class="side-menu__item">
        <i class="bx bx-receipt side-menu__icon"></i>
        <span class="side-menu__label">Expenses Report</span>
    </a>
</li>
<li class="slide">
    <a href="{{ url('/branchadmin/report/appointments') }}" class="side-menu__item">
        <i class="bx bx-calendar side-menu__icon"></i>
        <span class="side-menu__label">Appointments Report</span>
    </a>
</li>

                <!-- Staff -->
                <li class="slide">
                    <a href="{{ url('/branchadmin/staff') }}" class="side-menu__item">
                        <i class="bx bx-id-card side-menu__icon"></i>
                        <span class="side-menu__label">Branch Staff</span>
                    </a>
                </li>

                <!-- Complaints -->
                <li class="slide">
                    <a href="{{ url('/branchadmin/complaints') }}" class="side-menu__item">
                        <i class="bx bx-comment-detail side-menu__icon"></i>
                        <span class="side-menu__label">Complaints</span>
                    </a>
                </li>
               
<!-- Riders Menu in Sidebar -->
<li class="slide">
    <a href="{{ route('branchadmin.riders.index') }}" class="side-menu__item">
        <i class="bx bx-cycling side-menu__icon"></i>
        <span class="side-menu__label">Riders</span>
    </a>
</li>



               

              <!-- Appointments -->
<li class="slide">
    <a href="{{ route('appointments.reschedule.view') }}" class="side-menu__item">
        <i class="bx bx-calendar side-menu__icon"></i>
        <span class="side-menu__label">Reschedule Appointments</span>
    </a>
</li>

                {{-- <!-- Profile -->
                <li class="slide">
                    <a href="{{ url('/branchadmin/profile') }}" class="side-menu__item">
                        <i class="bx bx-user side-menu__icon"></i>
                        <span class="side-menu__label">My Profile</span>
                    </a>
                </li> --}}
<!-- Inventory Management -->
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="bx bx-box side-menu__icon"></i>
        <span class="side-menu__label">Inventory</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide">
            <a href="{{ route('branchadmin.inventory.view_items') }}" class="side-menu__item">
                📦 View My Inventory
            </a>
            
        </li>
        
        <li class="slide"><a href="{{ url('/branchadmin/create_report') }}" class="side-menu__item">🗂️ Inventory Report</a></li>
        <li class="slide"><a href="{{ route('low.stock.report.create') }}" class="side-menu__item">📉 Report Low Stock</a></li>
        <li class="slide"><a href="{{ route('branchadmin.low.stock.reports') }}" class="side-menu__item">📊 My Low Stock Reports</a></li>
</li>
<!-- Expenses List -->
<li class="slide">
    <a href="{{ route('branchadmin.expenses.index') }}" class="side-menu__item">
        <i class="bx bx-list-ul side-menu__icon"></i>
        <span class="side-menu__label">All Expenses</span>
    </a>
</li>

<!-- Add New Expense -->
<li class="slide">
    <a href="{{ route('branchadmin.expenses.create') }}" class="side-menu__item">
        <i class="bx bx-plus side-menu__icon"></i>
        <span class="side-menu__label">Add Expense</span>
    </a>
</li>


<!-- Income -->
<li class="slide">
  <!-- Sidebar -->
<li class="slide">
    <a href="{{ route('income.index') }}" class="side-menu__item">
        <i class="bx bx-dollar-circle side-menu__icon"></i>
        <span class="side-menu__label">Income</span>
    </a>
</li>

    {{-- <li>
        <a href="{{ route('income.index') }}" class="slide-item">All Income</a>
    </li>
    <li>
        <a href="{{ route('income.create') }}" class="slide-item">Add Income</a>
    </li> --}}
</li>

<!-- Patient Test Summary -->
{{-- <li class="slide">
    <a href="{{ url('/branchadmin/patient-tests/summary') }}" class="side-menu__item">
        <i class="bx bx-bar-chart side-menu__icon"></i>
        <span class="side-menu__label">Test Summary</span>
    </a>
</li> --}}

                <!-- Logout -->
                <li class="slide">
                    <a href="{{ route('branchadmin.logout') }}" class="side-menu__item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out side-menu__icon"></i>
                        <span class="side-menu__label">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('branchadmin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
