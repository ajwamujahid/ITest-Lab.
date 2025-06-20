@extends('layouts.patient-master')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0"><i class="bx bx-chat"></i> Chat with Support</h5>
            <span class="badge bg-white text-primary px-3 py-1 fw-semibold">🟢 Live</span>
        </div>

        {{-- Typing indicator --}}
        <div id="typing-indicator" class="px-4 py-1 text-muted small" style="display: none;">
            💬 Support is typing...
        </div>

        <div class="card-body px-4 py-3" style="height: 420px; overflow-y: auto;" id="chat-box">
            @forelse($messages as $msg)
                <div class="d-flex mb-3 {{ $msg->sender_id == auth('patient')->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-3 shadow-sm rounded-3 
                        {{ $msg->sender_id == auth('patient')->id() 
                            ? 'bg-primary text-white rounded-end-0' 
                            : 'bg-light text-dark rounded-start-0' }}" 
                        style="max-width: 75%; position: relative;">

                        <div class="fw-bold mb-2">
                            <span class="badge 
                                {{ $msg->sender_id == auth('patient')->id() 
                                    ? 'bg-white text-primary' 
                                    : 'bg-secondary text-white' }}">
                                {{ $msg->sender_id == auth('patient')->id() ? '🧑 You' : '💬 Support' }}
                            </span>
                        </div>

                        <div class="mb-2">{!! nl2br(e($msg->message)) !!}</div>

                        @if($msg->attachment)
                            @php
                                $ext = strtolower(pathinfo($msg->attachment, PATHINFO_EXTENSION));
                                $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                            @endphp
                            <div class="mt-2">
                                @if(in_array($ext, $imageTypes))
                                    <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $msg->attachment) }}" class="img-fluid rounded shadow-sm border" style="max-height: 200px;" alt="Attachment">
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                                        📄 <span>Open {{ strtoupper($ext) }}</span>
                                    </a>
                                @endif
                            </div>
                        @endif

                        {{-- Message time and status --}}
                        <div class="text-end small mt-2">
                            <span class="{{ $msg->sender_id == auth('patient')->id() ? 'text-white-50' : 'text-muted' }}">{{ $msg->created_at->format('h:i A') }}</span>
                            @if($msg->sender_id == auth('patient')->id())
                                <span class="text-success ms-2">✓✓</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted my-5">No messages yet. Start the conversation!</p>
            @endforelse
        </div>

        {{-- Chat Input --}}
        <div class="card-footer bg-light rounded-bottom-4 border-top-0">
            <form action="{{ route('chat.send') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                @csrf
                <input type="hidden" name="receiver_id" value="1">

                {{-- File --}}
                <label for="attachment" class="btn btn-light shadow-sm p-2 rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                    <i class="bx bx-paperclip fs-5 text-primary"></i>
                </label>
                <input type="file" id="attachment" name="attachment" class="d-none" accept="image/*,audio/*,.pdf,.doc,.docx">

                {{-- Voice --}}
                <label for="voice" class="btn btn-light shadow-sm p-2 rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                    <i class="bx bx-microphone fs-5 text-primary"></i>
                </label>
                <input type="file" id="voice" name="attachment" class="d-none" accept="audio/*">

                {{-- Input & Emoji --}}
                <div class="flex-grow-1 position-relative">
                    <textarea id="message" name="message" class="form-control shadow-sm rounded-pill px-4 py-2" placeholder="Type a message..." rows="1" style="resize: none;" required></textarea>

                    {{-- Emoji Picker --}}
                    <emoji-picker id="emoji-picker" class="position-absolute bg-white border rounded" style="bottom: 55px; right: 10px; display: none;"></emoji-picker>
                </div>

                {{-- Emoji Toggle --}}
                <button type="button" id="emoji-toggle" class="btn btn-light shadow-sm p-2 rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                    😊
                </button>

                {{-- Send --}}
                <button type="submit" class="btn btn-primary rounded-circle shadow-sm d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                    <i class="bx bx-send fs-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script type="module">
    import 'https://cdn.jsdelivr.net/npm/emoji-picker-element@1.6.2/index.js';

    const chatBox = document.getElementById('chat-box');
    const typingIndicator = document.getElementById('typing-indicator');
    const textarea = document.getElementById('message');
    const picker = document.getElementById('emoji-picker');
    const emojiToggle = document.getElementById('emoji-toggle');

    // Auto-scroll
    window.onload = () => {
        chatBox.scrollTop = chatBox.scrollHeight;
    };

    // Typing indicator
    textarea.addEventListener('input', () => {
        typingIndicator.style.display = 'block';
        clearTimeout(window.typingTimeout);
        window.typingTimeout = setTimeout(() => {
            typingIndicator.style.display = 'none';
        }, 2000);
    });

    // Toggle Emoji Picker
    emojiToggle.addEventListener('click', () => {
        picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
    });

    // Insert emoji into message
    picker.addEventListener('emoji-click', (e) => {
        const emoji = e.detail.unicode;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        textarea.value = textarea.value.slice(0, start) + emoji + textarea.value.slice(end);
        textarea.focus();
        textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
    });

    // Hide emoji picker when clicking outside
    document.addEventListener('click', (e) => {
        if (!picker.contains(e.target) && e.target !== emojiToggle) {
            picker.style.display = 'none';
        }
    });
</script>
{{-- 
<script>
    const chatBox = document.getElementById('chat-box');
    const typingIndicator = document.getElementById('typing-indicator');
    const textarea = document.getElementById('message');
    const picker = document.getElementById('emoji-picker');
    const emojiToggle = document.getElementById('emoji-toggle');

    // Auto-scroll
    window.onload = () => {
        chatBox.scrollTop = chatBox.scrollHeight;
    };

    // Typing indicator
    textarea.addEventListener('input', () => {
        typingIndicator.style.display = 'block';
        clearTimeout(window.typingTimeout);
        window.typingTimeout = setTimeout(() => {
            typingIndicator.style.display = 'none';
        }, 2000);
    });

    // Toggle Emoji Picker
    emojiToggle.addEventListener('click', () => {
        picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
    });

    // Insert emoji into message
    picker.addEventListener('emoji-click', (e) => {
        const emoji = e.detail.unicode;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        textarea.value = textarea.value.slice(0, start) + emoji + textarea.value.slice(end);
        textarea.focus();
        textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
    });

    // Hide emoji picker when clicking outside
    document.addEventListener('click', (e) => {
        if (!picker.contains(e.target) && e.target !== emojiToggle) {
            picker.style.display = 'none';
        }
    });
</script> --}}

{{-- Styles --}}
<style>
    textarea.form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    .btn:focus {
        box-shadow: none !important;
    }
    textarea::-webkit-scrollbar {
        display: none;
    }
    emoji-picker {
        z-index: 1050;
        width: 300px;
        max-height: 250px;
        overflow-y: auto;
    }
</style>
@endsection
