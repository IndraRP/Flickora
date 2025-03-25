<div class="container-fluid h-100">
    <div class="row h-100">
        <!-- Daftar Percakapan - Sebelah Kiri -->
        <div class="col-md-4 border-end p-0">
            <div class="chat-list text-white">
                <div class="border-bottom d-flex justify-content-between align-items-center p-3 text-white">
                    <h4 class="mb-0">Percakapan</h4>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createConversationModal">
                        <i class="bi bi-plus-lg"></i> Baru
                    </button>
                </div>

                <div class="conversation-list">
                    @forelse($conversations as $conversation)
                        <div class="conversation-item border-bottom {{ $selectedConversation == $conversation->id ? "bg-primary text-white" : "text-white" }} p-3" wire:click="selectConversation('{{ $conversation->id }}')" wire:key="conversation-{{ $conversation->id }}" style="cursor: pointer;">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    @if ($conversation->is_group)
                                        <div class="group-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                    @else
                                        <div class="user-avatar bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                                            {{ substr($conversation->users->first()->name ?? "U", 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        @if ($conversation->is_group)
                                            {{ $conversation->name }}
                                        @else
                                            {{ $conversation->users->first()->name ?? "Pengguna Tidak Dikenal" }}
                                        @endif
                                    </h6>
                                    <p class="small {{ $selectedConversation == $conversation->id ? "text-white-50" : "text-muted" }} mb-0">
                                        {{ $conversation->lastMessage?->body ?? "Belum ada pesan" }}
                                    </p>
                                </div>
                                @if ($conversation->lastMessage && $conversation->lastMessage->created_at)
                                    <div class="{{ $selectedConversation == $conversation->id ? "text-white-50" : "text-muted" }} small">
                                        {{ $conversation->lastMessage->created_at->format("H:i") }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-muted p-3 text-center text-white">
                            Belum ada percakapan
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Modal untuk Membuat Percakapan Baru -->
            <div class="modal fade" id="createConversationModal" tabindex="-1" aria-labelledby="createConversationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createConversationModalLabel">Buat Percakapan Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @livewire("user.lock.addconver")
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Chat - Sebelah Kanan -->
        <div class="col-md-8 p-0">
            @livewire("user.lock.chatbox")
        </div>
    </div>
</div>
