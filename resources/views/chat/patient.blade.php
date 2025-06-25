@extends('layouts.patient-master')

@section('content')
<div class="container py-4">
    {{-- 🧾 Chat with Support --}}
    <div class="card shadow border-0 rounded-4 overflow-hidden">
        {{-- 🔰 Header --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bx bx-headphone"></i> Chat with Support</h5>
            <span class="badge bg-white text-primary fw-semibold px-3 py-1">Support Team</span>
        </div>

        {{-- 💬 Messages --}}
        <div class="card-body bg-light" style="height: 450px; overflow-y: auto;" id="chatBox">
            @forelse ($messages as $message)
                @php
                    $isPatient = auth('patient')->id() === $message->sender_id && $message->sender_type === 'patient';
                @endphp

                <div class="d-flex mb-3 {{ $isPatient ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-3 rounded-3 shadow-sm"
                         style="max-width: 75%; {{ $isPatient ? 'background-color: #D1E7DD;' : 'background-color: #FFFFFF;' }}">
                        <div class="fw-bold mb-1 text-muted small">
                            {{ $isPatient ? '👤 You' : '🧑‍💼 Support' }}
                        </div>

                        {{-- 💬 Message --}}
                        @if ($message->message)
                            <div class="mb-2">{{ $message->message }}</div>
                        @endif

                        {{-- 📎 Attachment --}}
                        @if ($message->attachment)
                            <div class="mt-2">
                                @php
                                    $extension = pathinfo($message->attachment, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp

                                @if ($isImage)
                                    {{-- 🖼️ Show image --}}
                                    <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $message->attachment) }}"
                                             alt="image"
                                             style="max-width: 200px; border-radius: 10px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                                    </a>
                                @else
                                    {{-- 📄 Show download link --}}
                                    <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank" class="text-decoration-none text-primary">
                                        📎 View Attachment
                                    </a>
                                @endif
                            </div>
                        @endif

                        {{-- 🕒 Timestamp + Seen Check --}}
                        <div class="text-muted small text-end mt-1 d-flex align-items-center justify-content-end gap-1">
                            <span>{{ $message->created_at->format('h:i A') }}</span>
                            
                            @if($isPatient)
                                @if($message->is_read)
                                    <i class="bx bx-check-double text-primary fs-5" title="Seen"></i> {{-- ✅✅ Seen --}}
                                @else
                                    <i class="bx bx-check text-muted fs-5" title="Sent"></i> {{-- ✅ Sent --}}
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    No messages yet. Start the conversation!
                </div>
            @endforelse
        </div>

        {{-- ✏️ Send Box --}}
        <div class="card-footer bg-white border-top py-3">
            <form action="{{ route('chat.send') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $chatDeptManagerId }}">
                <input type="hidden" name="receiver_type" value="manager">

                <div class="d-flex align-items-center gap-2">
                   {{-- 📎 Attachment --}}
<label for="attachment" class="btn btn-light border rounded-circle d-flex align-items-center justify-content-center"
style="width: 42px; height: 42px;" title="Attach File">
<i class="bx bx-paperclip fs-5 text-muted"></i>
</label>
<input id="attachment" type="file" name="attachment" class="d-none" onchange="this.form.submit();">

                        {{-- 💬 Message Textarea --}}
                    <div class="flex-grow-1">
                        <textarea name="message"
                                  class="form-control border-0 bg-light rounded-pill px-4 py-2"
                                  placeholder="Type a message..." rows="1"
                                  style="resize: none;"></textarea>
                    </div>

                    {{-- 📤 Send Button --}}
                    <button type="submit" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 44px; height: 44px;">
                        <i class="bx bx-send fs-5 text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

🔽 Scroll to bottom
{{-- @push('scripts')
<script>
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endpush --}}
{{-- @push('scripts')
<script>
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;

    // Optional: live attachment file preview (text only, not image)
    function previewAttachment() {
        const input = document.getElementById('attachment');
        if (input.files.length > 0) {
            const file = input.files[0];
            console.log("📎 Selected file:", file.name);
        }
    }
</script>
@endpush --}}
@push('scripts')
<script>
    // Scroll to bottom on load
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;

    // 🔽 Manual trigger for hidden file input
    document.getElementById('triggerAttachment').addEventListener('click', function () {
        document.getElementById('attachment').click();
    });

    // ✅ Optional: show selected file in console
    function previewAttachment() {
        const input = document.getElementById('attachment');
        if (input.files.length > 0) {
            const file = input.files[0];
            console.log("📎 Selected file:", file.name);
        }
    }
</script>
@endpush

@endsection
