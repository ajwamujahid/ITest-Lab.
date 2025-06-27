@extends('layouts.master')

@section('styles')
 
      
@endsection

@section('content')

                <div class="container-fluid">

                    <!-- Start::page-header -->

                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        <div>
                            <p class="fw-semibold fs-18 mb-0">
                                @if(Auth::check())
                                <p class="fw-semibold fs-18 mb-0">Welcome Back: {{ Auth::user()->name }}</p>
                            @else
                                <p>No user logged in</p>
                            @endif
                            </p>
                          
                        </div>
                      
                    </div>

                    <!-- End::page-header -->

                    <!-- Start::row-1 -->
                    
                    
                               
                                <div class="col-xxl-10 col-md-8" style="margin-left:60px;">
                                    <div class="row">
                                        <div class="col-xxl-6 col-md-6">
                                            <div class="card custom-card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top justify-content-between">
                                                        <div>
                                                            <span class="avatar avatar-md avatar-rounded bg-primary">
                                                                <i class="ti ti-users fs-16"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill ms-3">
                                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                                <div>
                                                                    <p class="text-muted mb-0">Total Patients</p>
                                                                    <h4 class="fw-semibold mt-1">1,02,890</h4>
                                                                </div>
                                                                <div id="crm-total-customers"></div>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                                <div>
                                                                    <a class="text-primary" href="javascript:void(0);">View All<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                                                </div>
                                                                <div class="text-end">
                                                                    <p class="mb-0 text-success fw-semibold">+40%</p>
                                                                    <span class="text-muted op-7 fs-11">this month</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-lg-6 col-md-6">
                                            <div class="card custom-card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top justify-content-between">
                                                        <div>
                                                            <span class="avatar avatar-md avatar-rounded bg-secondary">
                                                                <i class="ti ti-wallet fs-16"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill ms-3">
                                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                                <div>
                                                                    <p class="text-muted mb-0">Total Revenue</p>
                                                                    <h4 class="fw-semibold mt-1">$56,562</h4>
                                                                </div>
                                                                <div id="crm-total-revenue"></div>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                                <div>
                                                                    <a class="text-secondary" href="javascript:void(0);">View All<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                                                </div>
                                                                <div class="text-end">
                                                                    <p class="mb-0 text-success fw-semibold">+25%</p>
                                                                    <span class="text-muted op-7 fs-11">this month</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-lg-6 col-md-6">
                                            <div class="card custom-card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top justify-content-between">
                                                        <div>
                                                            <span class="avatar avatar-md avatar-rounded bg-success">
                                                                <i class="ti ti-wave-square fs-16"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill ms-3">
                                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                                <div>
                                                                    <p class="text-muted mb-0">Total Income</p>
                                                                    <h4 class="fw-semibold mt-1">12.08%</h4>
                                                                </div>
                                                                <div id="crm-conversion-ratio"></div>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                                <div>
                                                                    <a class="text-success" href="javascript:void(0);">View All<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                                                </div>
                                                                <div class="text-end">
                                                                    <p class="mb-0 text-danger fw-semibold">-12%</p>
                                                            <span class="text-muted op-7 fs-11">this month</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-lg-6 col-md-6">
                                            <div class="card custom-card overflow-hidden">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top justify-content-between">
                                                        <div>
                                                            <span class="avatar avatar-md avatar-rounded bg-warning">
                                                                <i class="ti ti-briefcase fs-16"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill ms-3">
                                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                                <div>
                                                                    <p class="text-muted mb-0">Total Finance</p>
                                                                    <h4 class="fw-semibold mt-1">2,543</h4>
                                                                </div>
                                                                <div id="crm-total-deals"></div>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                                <div>
                                                                    <a class="text-warning" href="javascript:void(0);">View All<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                                                </div>
                                                                <div class="text-end">
                                                                    <p class="mb-0 text-success fw-semibold">+19%</p>
                                                                    <span class="text-muted op-7 fs-11">this month</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>
                              
                                    <div class="row justify-content-center">
                                        <!-- Line Chart -->
                                        <div class="col-xl-6">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">Monthly Revenue Record</div>
                                                </div>
                                                <div class="card-body">
                                                    <div id="line-chart"></div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Donut Chart -->
                                        <div class="col-xl-6">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">Monthly Patient Record</div>
                                                </div>
                                                <div class="card-body">
                                                    <div id="donut-simple"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                    <!-- End::row-1 -->

                </div>

@endsection

@section('scripts')
 
        <!-- JSVECTOR MAPS JS -->
        <script src="{{asset('build/assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
        <script src="{{asset('build/assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

        <!-- APEX CHARTS JS -->
        <script src="{{asset('build/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- CHARTJS CHART JS -->
        <script src="{{asset('build/assets/libs/chart.js/chart.min.js')}}"></script>

        <!-- CRM-Dashboard -->
        @vite('resources/assets/js/crm-dashboard.js')

        
<!-- APEX CHARTS JS -->
<script src="{{asset('build/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- APEX DATASERIES CHARTS JS -->
<script src="{{asset('build/assets/dataseries.js')}}"></script>

<!--- APEX STOCK PRICES CHARTS JS -->
<script src="{{asset('build/assets/apexcharts-stock-prices.js')}}"></script>

<!-- INTERNAL APEX LINE CHARTS JS -->
@vite('resources/assets/js/apexcharts-line.js')
 <!-- APEX CHARTS JS -->
 <script src="{{asset('build/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

 <!-- INTERNAL APEX PIE CHARTS JS -->
 @vite('resources/assets/js/apexcharts-pie.js')
 
        @endsection

