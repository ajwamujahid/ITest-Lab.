@extends('layouts.patient-master')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-primary">
        <i class="bx bx-notepad"></i> Your Medical Reports
    </h3>
    

    @if($testRequests->isEmpty())
        <div class="alert alert-info">
            No reports available yet.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($testRequests as $test)
                <div class="col">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <p class="card-text mt-4"> 
                                <strong>Patient Name:</strong>{{ $test->name ?? 'Test Report' }}
                                 <br>
                                 <strong>Test Name:</strong> {{ $test->test_name ?? 'N/A' }} <br>
                                 <strong>Test Type:</strong> {{ $test->test_type ?? 'N/A' }} <br>
                                <strong>Date:</strong> {{ $test->created_at->format('d M, Y') }} <br>
                                <strong>Report Status:</strong> 
                                <span class="badge bg-success">Available</span>
                            </p>

                            @if($test->report_file_path)
                                <a href="{{ asset('storage/' . $test->report_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                     View Report
                                </a>
                                <a href="{{ asset('storage/' . $test->report_file_path) }}" download class="btn btn-sm btn-primary">
                                     Download
                                </a>
                            @else
                                <span class="text-muted">No file attached</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
