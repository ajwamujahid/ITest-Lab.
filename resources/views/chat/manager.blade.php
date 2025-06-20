@extends('layouts.manager-master')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4 overflow-hidden">
        {{-- 🔰 Header --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bx bx-user-voice"></i> Patients Who Have Messaged</h5>
            <span class="badge bg-white text-primary fw-semibold px-3 py-1">{{ $patients->count() }} total</span>
        </div>

        {{-- 📜 Patient List --}}
        <div class="card-body p-0">
            @if($patients->isEmpty())
                <div class="p-4 text-center text-muted">
                    <i class="bx bx-message-square-x fs-2"></i>
                    <p class="mb-0">No patients have messaged yet.</p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($patients as $patient)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-light d-flex justify-content-center align-items-center"
                                 style="width: 40px; height: 40px;">
                                <i class="bx bx-user fs-4 text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">
                                    {{ $patient->name }}
                                    @if($patient->unread > 0)
                                        <span class="badge bg-danger ms-2">{{ $patient->unread }}</span>
                                    @endif
                                </div>
                                <div class="text-muted small">ID: {{ $patient->id }}</div>
                            </div>
                        </div>
                
                        <a href="{{ route('chat.manager.view', ['patientId' => $patient->id]) }}"
                           class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                            <i class="bx bx-chat"></i> Chat
                        </a>
                    </li>
                @endforeach
                
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
