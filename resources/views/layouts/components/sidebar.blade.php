
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
                            <li class="slide has-sub">
                                <a href="{{ url('/') }}" class="side-menu__item">
                                    <i class="bx bx-home side-menu__icon"></i>
                                    <span class="side-menu__label">Dashboards</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0);">Dashboards</a>
                                    </li>
                                  
                                    {{-- <li class="slide">
                                        <a href="{{url('index4')}}" class="side-menu__item">Jobs</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('index5')}}" class="side-menu__item">NFT</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('index6')}}" class="side-menu__item">Sales</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('index7')}}" class="side-menu__item">Analytics</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('index8')}}" class="side-menu__item">Projects</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('index9')}}" class="side-menu__item">HRM</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('index10')}}" class="side-menu__item">Stocks</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('index11')}}" class="side-menu__item">Courses</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('index12')}}" class="side-menu__item">Personal</a>
                                    </li> --}}
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            {{-- <li class="slide__category"><span class="category-name">Employees</span></li> --}}
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-user side-menu__icon"></i>
                                    <span class="side-menu__label">Employees</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <!-- All Employees -->
                                     <!-- Add New Employee -->
                                     {{-- <li class="slide">
                                        <a href="{{ url('branch-admin/create') }}" class="side-menu__item">Add Branch Admin</a>
                                    </li> --}}
                                    <li class="slide">
                                        <a href="{{ url('employees') }}" class="side-menu__item">Branch Admins</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('employees.filter') }}" class="side-menu__item">
                                           
                                            <span class="side-menu__label">Branch Managers</span>
                                        </a>
                                    </li>
                                    {{-- <li class="slide">
                                        <a href="{{ route('managers.create') }}" class="side-menu__item">Add Manager</a>

                                    </li> --}}
                                    
                                    <li class="slide">
                                        <a href="{{ url('departments') }}" class="side-menu__item">Departments</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('roles.create') }}" class="side-menu__item">Roles & Permissions</a>
                                    </li>
                                    <!-- Role-specific sections (Optional filtered views) -->
                                    {{-- <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">By Role<i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            {{-- <li><a href="{{ url('employees?role=Super Admin') }}" class="side-menu__item">Super Admins</a></li>
                                            <li><a href="{{ url('employees?role=Branch Manager') }}" class="side-menu__item">Branch Managers</a></li> --}}
                                           
                                           
                                          
                                            
                                            {{-- </ul>
                                        
                                    </li> --}} 
                            
                                    <!-- Additional Modules -->
                                    {{-- <li class="slide">
                                        <a href="{{ url('roles.permission') }}" class="side-menu__item">Roles & Permissions</a>
                                    </li> --}}
                                    {{-- <li class="slide">
                                        <a href="{{ url('branchadmin/create_manager') }}" class="side-menu__item">Add Manager</a>
                                    </li> --}}
                                    
                                    {{-- <li class="slide">
                                        <a href="{{ url('departments') }}" class="side-menu__item">Departments</a>
                                    </li> --}}
                                    {{-- <li class="slide">
                                        <a href="{{ url('attendance') }}" class="side-menu__item">Attendance</a>
                                    </li> --}}
                                    {{-- <li class="slide">
                                        <a href="{{ route('payroll.create') }}" class="side-menu__item">
                                           
                                           Add Payroll
                                        </a>
                                    </li> --}}
                                    <li class="slide">
                                        <a href="{{ route('payroll.index') }}" class="side-menu__item">
                                          
                                          Payroll
                                        </a>
                                    </li>
                                    

                                    
                                    {{-- <li class="slide">
                                        <a href="{{ url('performance-reviews') }}" class="side-menu__item">Performance Reviews</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ url('employee-profiles') }}" class="side-menu__item">Employee Profiles</a>
                                    </li> --}}
                                    <li class="slide">
                                        <a href="{{ url('employee-reports') }}" class="side-menu__item">Reports</a>
                                    </li>
                                </ul>
                            </li>
                            
                            
                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-box side-menu__icon"></i>  <!-- box icon for inventory -->
                                    <span class="side-menu__label">Inventory</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ url('inventory-items') }}" class="side-menu__item">Items List</a>
                                    </li>
                                    {{-- <li class="slide">
                                        <a href="{{ url('inventory-add') }}" class="side-menu__item">Add New Item</a>
                                    </li> --}}
                                    <li class="slide">
                                        <a href="{{ url('inventory-category') }}" class="side-menu__item">Categories</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ url('inventory-reports') }}" class="side-menu__item">Reports</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ url('inventory-stock-levels') }}" class="side-menu__item">Stock Levels</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('low.stock.reports') }}" class="side-menu__item">Low Stock Reports</a>
                                    </li>
                                    
                                </ul>
                            </li>
                         <!-- Test Management Section -->


<li class="slide">
    <a href="{{ url('tests/manage') }}" class="side-menu__item d-flex align-items-center">
        <i class="bx bx-analyse side-menu__icon"></i>
        <span>Lab Test Management</span>
        
        
    </a>
</li>

                            
                        <!-- Start::slide -->
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="bx bx-git-branch side-menu__icon"></i>
        <span class="side-menu__label">Branches</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>

    <ul class="slide-menu child1">
        @foreach($branches as $branch)
            <li class="slide">
                <a href="{{ url($branch->name) }}" class="side-menu__item">
                    {{ $branch->name }}
                </a>
            </li>
        @endforeach
    </ul>
</li>

<!-- ✅ Add Button outside UL -->
<div class="px-3 mt-2">
    <button type="button" class="btn btn-sm btn-success w-100" data-bs-toggle="modal" data-bs-target="#addBranchModal">
        + Add Branch
    </button>
</div>

<!-- Modal Partial -->
@include('partials.branch-modal')

                            <!-- End::slide -->

                           
                            <!-- Start::slide__category -->
                            {{-- <li class="slide__category"><span class="category-name">General</span></li> --}}
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                         <!-- Complaints Section -->
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="bx bx-file-blank side-menu__icon"></i>
        <span class="side-menu__label">Complaints</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1 mega-menu">

        <!-- Patient Complaints -->
        <li class="slide has-sub">
            <a href="javascript:void(0);" class="side-menu__item">
                <span class="side-menu__label">Patient Complaints</span>
                <i class="fe fe-chevron-right side-menu__angle"></i>
            </a>
            <ul class="slide-menu child2">
                {{-- <li class="slide">
                    <a href="{{ url('patient-complaints/pending') }}" class="side-menu__item">Pending</a>
                </li>
                <li class="slide">
                    <a href="{{ url('patient-complaints/resolved') }}" class="side-menu__item">Resolved</a>
                </li>
                <li class="slide">
                    <a href="{{ url('patient-complaints/rejected') }}" class="side-menu__item">Rejected</a>
                </li>
                <li class="slide">
                    <a href="{{ url('patient-complaints/in-progress') }}" class="side-menu__item">In Progress</a>
                </li> --}}
                <li class="slide">
                    <a href="{{ url('patient-complaints/view') }}" class="side-menu__item">View Complaint</a>
                </li>
            </ul>
        </li>
        
        <!-- Branch Complaints -->
        {{-- <li class="slide has-sub">
            <a href="javascript:void(0);" class="side-menu__item">
                <span class="side-menu__label">Branch Complaints</span>
                <i class="fe fe-chevron-right side-menu__angle"></i>
            </a>
            <ul class="slide-menu child2">
                <li class="slide">
                    <a href="{{ url('branch-complaints/pending') }}" class="side-menu__item">Pending</a>
                </li>
                <li class="slide">
                    <a href="{{ url('branch-complaints/resolved') }}" class="side-menu__item">Resolved</a>
                </li>
                <li class="slide">
                    <a href="{{ url('branch-complaints/rejected') }}" class="side-menu__item">Rejected</a>
                </li>
                <li class="slide">
                    <a href="{{ url('branch-complaints/in-progress') }}" class="side-menu__item">In Progress</a>
                </li>
            </ul>
        </li> --}}

    </ul>
</li>


  <!-- Start::slide -->
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="bx bx-money side-menu__icon"></i>
        <span class="side-menu__label">Finance</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide">
            <a href="{{ url('finance/revenue') }}" class="side-menu__item">Total Revenue</a>
          </li>
          
          <li class="slide">
            <a href="{{ url('finance/expenses') }}" class="side-menu__item">Total Expenses</a>
          </li>
          
          <li class="slide">
            <a href="{{ url('finance/profit-loss') }}" class="side-menu__item">Profit & Loss Statement</a>
   
        </li>
          
          {{-- <li class="slide">
            <a href="{{ url('finance/budget') }}" class="side-menu__item">Budget Management</a>
          </li> --}}
          
          <li class="slide">
            <a href="{{ url('finance/cash-flow') }}" class="side-menu__item">Cash Flow</a>
          </li>
          
          <li class="slide">
            <a href="{{ url('finance/invoices') }}" class="side-menu__item">Invoices</a>
          </li>
          
          <li class="slide">
            <a href="{{ url('finance/payments') }}" class="side-menu__item">Payments</a>
          </li>
    </ul>
</li>
<!-- End::slide -->

                            {{-- <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{url('widgets')}}" class="side-menu__item">
                                    <i class="bx bx-gift side-menu__icon"></i>
                                    <span class="side-menu__label">Widgets<span class="badge bg-danger-transparent ms-2">Hot</span></span>
                                </a>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Web Apps</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-grid-alt side-menu__icon"></i>
                                    <span class="side-menu__label">Apps<span class="badge bg-secondary-transparent ms-2">New</span></span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0);">Apps</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('full-calendar')}}" class="side-menu__item">Full Calendar</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('gallery')}}" class="side-menu__item">Gallery</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('sweet-alerts')}}" class="side-menu__item">Sweet Alerts</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Projects<span class="badge bg-secondary-transparent ms-2">New</span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="{{url('projects-list')}}" class="side-menu__item">Projects List</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('projects-overview')}}" class="side-menu__item">Project Overview</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('projects-create')}}" class="side-menu__item">Create Project</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Jobs<span class="badge bg-secondary-transparent ms-2">New</span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="{{url('job-details')}}" class="side-menu__item">Job Details</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('job-company-search')}}" class="side-menu__item">Company Search</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('job-search')}}" class="side-menu__item">Job Search</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('job-post')}}" class="side-menu__item">Job Post</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('job-list')}}" class="side-menu__item">Job List</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('job-candidate-search')}}" class="side-menu__item">Search Candidate</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('job-candidate-details')}}" class="side-menu__item">Candidate Details</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">NFT<span class="badge bg-secondary-transparent ms-2">New</span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="{{url('nft-marketplace')}}" class="side-menu__item">Market Place</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('nft-details')}}" class="side-menu__item">NFT Details</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('nft-create')}}" class="side-menu__item">Create NFT</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('nft-wallet-integration')}}" class="side-menu__item">Wallet Integration</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('nft-live-auction')}}" class="side-menu__item">Live Auction</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">CRM<span class="badge bg-secondary-transparent ms-2">New</span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="{{url('crm-contacts')}}" class="side-menu__item">Contacts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('crm-companies')}}" class="side-menu__item">Companies</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('crm-deals')}}" class="side-menu__item">Deals</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('crm-leads')}}" class="side-menu__item">Leads</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Crypto<span class="badge bg-secondary-transparent ms-2">New</span>
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="{{url('crypto-transactions')}}" class="side-menu__item">Transactions</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('crypto-currency-exchange')}}" class="side-menu__item">Currency Exchange</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('crypto-buy-sell')}}" class="side-menu__item">Buy & Sell</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('crypto-marketcap')}}" class="side-menu__item">Marketcap</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('crypto-wallet')}}" class="side-menu__item">Wallet</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-layer side-menu__icon"></i>
                                    <span class="side-menu__label">Nested Menu</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0);">Nested Menu</a>
                                    </li>
                                    <li class="slide">
                                        <a href="javascript:void(0);" class="side-menu__item">Nested-1</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Nested-2
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="javascript:void(0);" class="side-menu__item">Nested-2-1</a>
                                            </li>
                                            <li class="slide has-sub">
                                                <a href="javascript:void(0);" class="side-menu__item">Nested-2-2
                                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                                <ul class="slide-menu child3">
                                                    <li class="slide">
                                                        <a href="javascript:void(0);" class="side-menu__item">Nested-2-2-1</a>
                                                    </li>
                                                    <li class="slide">
                                                        <a href="javascript:void(0);" class="side-menu__item">Nested-2-2-2</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Tables & Charts</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-table side-menu__icon"></i>
                                    <span class="side-menu__label">Tables<span class="badge bg-success-transparent ms-2">3</span></span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0);">Tables</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('tables')}}" class="side-menu__item">Tables</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('grid-tables')}}" class="side-menu__item">Grid JS Tables</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('data-tables')}}" class="side-menu__item">Data Tables</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-bar-chart-square side-menu__icon"></i>
                                    <span class="side-menu__label">Charts</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0);">Charts</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Apex Charts
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="{{url('apex-line-charts')}}" class="side-menu__item">Line Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-area-charts')}}" class="side-menu__item">Area Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-column-charts')}}" class="side-menu__item">Column Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-bar-charts')}}" class="side-menu__item">Bar Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-mixed-charts')}}" class="side-menu__item">Mixed Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-rangearea-charts')}}" class="side-menu__item">Range Area Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-timeline-charts')}}" class="side-menu__item">Timeline Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-candlestick-charts')}}" class="side-menu__item">CandleStick
                                                    Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-boxplot-charts')}}" class="side-menu__item">Boxplot Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-bubble-charts')}}" class="side-menu__item">Bubble Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-scatter-charts')}}" class="side-menu__item">Scatter Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-heatmap-charts')}}" class="side-menu__item">Heatmap Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-treemap-charts')}}" class="side-menu__item">Treemap Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-pie-charts')}}" class="side-menu__item">Pie Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-radialbar-charts')}}" class="side-menu__item">Radialbar Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-radar-charts')}}" class="side-menu__item">Radar Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="{{url('apex-polararea-charts')}}" class="side-menu__item">Polararea Charts</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('chartjs-charts')}}" class="side-menu__item">Chartjs Charts</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('echarts')}}" class="side-menu__item">Echart Charts</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Maps & Icons</span></li>
                            <!-- End::slide__category --> --}}

                            <!-- Start::slide -->
                            {{-- <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-map side-menu__icon"></i>
                                    <span class="side-menu__label">Maps</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0);">Maps</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('google-maps')}}" class="side-menu__item">Google Maps</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('leaflet-maps')}}" class="side-menu__item">Leaflet Maps</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{url('vector-maps')}}" class="side-menu__item">Vector Maps</a>
                                    </li>
                                </ul>
                            </li> --}}
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            {{-- <li class="slide">
                                <a href="{{url('icons')}}" class="side-menu__item">
                                    <i class="bx bx-store-alt side-menu__icon"></i>
                                    <span class="side-menu__label">Icons</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                        </ul> --}}
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->

            </aside>
            