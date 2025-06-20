@extends('layouts.rider-master')

@section('content')
<div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📍 Patient Location Tracking</h4>
        </div>

        <div class="card-body">
            @if($patient && $testRequest)
                <div class="row align-items-center mb-4">
                    <div class="col-md-3 text-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="bx bx-user-circle" style="font-size: 60px;"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h5 class="mb-1">{{ $patient->name }}</h5>
                        <p class="mb-1"><strong>Phone:</strong> {{ $patient->phone }}</p>
                        <p class="mb-0"><strong>Address:</strong> {{ $testRequest->address ?? 'N/A' }}</p>
                    </div>
                </div>
            @else
                <p class="text-danger">🚫 Patient information is currently not available.</p>
            @endif

            <div id="map" style="height: 450px; width: 100%; border:1px solid #dee2e6;" class="rounded shadow-sm mt-3"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function initMap() {
    const riderLocation = { lat: {{ $rider->latitude ?? '0' }}, lng: {{ $rider->longitude ?? '0' }} };
    const branchLocation = { lat: {{ $branch->latitude ?? '0' }}, lng: {{ $branch->longitude ?? '0' }} };

    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: riderLocation,
        mapTypeId: 'roadmap',
    });

    const riderMarker = new google.maps.Marker({
        position: riderLocation,
        map: map,
        label: { text: "🧍 Rider", className: "marker-label" },
        icon: {
            url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
        }
    });

    const branchMarker = new google.maps.Marker({
        position: branchLocation,
        map: map,
        label: { text: "🏥 Branch", className: "marker-label" },
        icon: {
            url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png"
        }
    });

    const line = new google.maps.Polyline({
        path: [riderLocation, branchLocation],
        geodesic: true,
        strokeColor: "#0d6efd",
        strokeOpacity: 0.8,
        strokeWeight: 4,
        map: map
    });
}
</script>

{{-- Load Google Maps with API key --}}
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap">
</script>


<style>
    .marker-label {
        font-weight: bold;
        color: #000;
        font-size: 14px;
    }
</style>
@endsection
