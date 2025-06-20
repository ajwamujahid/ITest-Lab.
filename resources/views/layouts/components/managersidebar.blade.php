<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="{{ url('/manager/dashboard') }}" class="header-logo">
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
            <ul class="main-menu">
                <li class="slide__category"><span class="category-name">Manager Dashboard</span></li>

                @php
                $manager = Auth::guard('manager')->user();
                $department = \App\Models\Department::where('manager_id', $manager->id)->first();
            
                $roleName = strtolower($department->name ?? '');
                $departmentName = strtolower($department->description ?? ''); // optional
            @endphp
            
            @if($roleName === 'chat' || $departmentName === 'chat')
                <li class="slide">
                    <a href="{{ route('chat.manager') }}" class="side-menu__item">
                        <i class="bx bx-chat side-menu__icon"></i>
                        <span class="side-menu__label">Patient Chat</span>
                    </a>
                </li>
            @endif
            
            {{-- Physical Appointment Manager --}}

            @php
            $manager = Auth::guard('manager')->user();
            $department = \App\Models\Department::where('manager_id', $manager->id)->first();
        
            $roleName = strtolower($department->name ?? '');
            $departmentName = strtolower($department->description ?? ''); // optional
        @endphp
@if($roleName === 'physical appointment manager' || $departmentName === 'appointments')
<li class="slide">
    <a href="{{ route('physical-tests.index') }}" class="side-menu__item">
        <i class="bx bx-plus-medical side-menu__icon"></i>
        <span class="side-menu__label">Assign Physical Appointments</span>
    </a>
</li>
<li class="slide">
    <a href="{{ route('physical-tests.assigned') }}" class="side-menu__item">
        <i class="bx bx-calendar-check side-menu__icon"></i>
        <span class="side-menu__label">View Assigned Appointments</span>
    </a>
</li>
@endif
  {{-- Report Upload --}}
            
            @php
            $user = Auth::guard('manager')->user();
            $role = strtolower($user->role->name ?? '');
            $department = $user->department->name ?? 'N/A';
        
            // dd([
            //     'role' => $role,
            //     'department' => $department,
            //     'manager_id' => $user->id,
            // ]);
        @endphp
                @if(strtolower($department) === 'lab tester')
                <li class="slide">
                    <a href="{{ route('reports.upload') }}" class="side-menu__item">
                        <i class="bx bx-upload side-menu__icon"></i>
                        <span class="side-menu__label">Upload Reports</span>
                    </a>
                </li>
                @endif
                

                {{-- Sample Collection Manager --}}

                @php
                $manager = Auth::guard('manager')->user();
                $department = \App\Models\Department::where('manager_id', $manager->id)->first();
            
                $roleName = strtolower($department->name ?? '');
                $departmentName = strtolower($department->description ?? ''); // optional
            @endphp
               @if($roleName === 'physical appointment manager' || $departmentName === 'appointments')

                <li class="slide">
                    <a href="{{ route('sample.assign') }}" class="side-menu__item">
                        <i class="bx bx-collection side-menu__icon"></i>
                        <span class="side-menu__label">Assign Sample Collection</span>
                    </a>
                </li>
                @endif

{{-- Sample Kit Manager --}}

@php
$manager = Auth::guard('manager')->user();
$department = \App\Models\Department::where('manager_id', $manager->id)->first();

$roleName = strtolower($department->name ?? '');
$departmentName = strtolower($department->description ?? ''); // optional
@endphp
@if($roleName === 'physical appointment manager' || $departmentName === 'appointments')
    <li class="slide">
        <a href="{{ route('kits.assign') }}" class="side-menu__item">
            <i class="bx bx-package side-menu__icon"></i>
            <span class="side-menu__label">Assign Kits to Riders</span>
        </a>
    </li>
    <li class="slide">
        <a href="{{ route('kits.assigned') }}" class="side-menu__item">
            <i class="bx bx-list-ul side-menu__icon"></i>
            <span class="side-menu__label">View Assigned Kits</span>
        </a>
    </li>
@endif


                {{-- Logout --}}
                <li class="slide">
                    <a href="#" class="side-menu__item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out side-menu__icon"></i>
                        <span class="side-menu__label">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('manager.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
