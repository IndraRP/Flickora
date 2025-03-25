<div class="h-100 d-flex flex-column">
    @if (!$showChatbox)
        <!-- Tampilan awal ketika belum ada chat yang dipilih -->
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="text-center text-white">
                <i class="bi bi-chat-dots-fill" style="font-size: 4rem;"></i>
                <h4 class="mt-3">Pilih percakapan untuk memulai</h4>
            </div>
        </div>
    @else
        <!-- Header chat -->
        <div class="chat-header border-bottom d-flex align-items-center p-3">
            <div class="avatar me-3">
                @if ($conversation && $conversation->is_group)
                    <div class="group-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                @elseif ($otherUser)
                    <div class="user-avatar bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                        {{ substr($otherUser->name ?? "U", 0, 1) }}
                    </div>
                @endif
            </div>
            <div>
                <h5 class="mb-0 text-white">
                    @if ($conversation && $conversation->is_group)
                        {{ $conversation->name }}
                    @elseif ($otherUser)
                        {{ $otherUser->name }}
                    @else
                        Percakapan
                    @endif
                </h5>
                <small class="text-white-50">
                    @if ($otherUser)
                        {{ $otherUser->email }}
                    @endif
                </small>
            </div>
        </div>

        <!-- Body chat -->
        <div class="chat-body flex-grow-1 overflow-auto p-3" style="height: calc(100% - 130px);" id="chat-messages">
            @foreach ($messages as $message)
                <div class="message-item {{ $message->user_id == Auth::id() ? "text-end" : "" }} mb-3">
                    <div class="d-inline-block {{ $message->user_id == Auth::id() ? "bg-primary text-white" : "bg-light text-dark" }} rounded p-2" style="max-width: 70%;">
                        <div class="message-content">{{ $message->body }}</div>
                        <div class="message-time small {{ $message->user_id == Auth::id() ? "text-white-50" : "text-muted" }}">
                            {{ $message->created_at->format("H:i") }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Footer chat / input pesan -->
        <div class="chat-footer border-top p-3">
            <form wire:submit.prevent="sendMessage" class="d-flex">
                <input type="text" wire:model.defer="messageText" class="form-control me-2" placeholder="Ketik pesan..." required>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    @endif

    <script>
        // Auto-scroll ke pesan terbaru
        document.addEventListener('livewire:initialized', () => {
            const scrollToBottom = () => {
                const chatContainer = document.getElementById('chat-messages');
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            };

            // Scroll ke bawah setelah pesan dimuat
            Livewire.hook('message.processed', (message, component) => {
                if (component.name === 'user.lock.chatbox') {
                    setTimeout(scrollToBottom, 100);
                }
            });
        });
    </script>
</div>
