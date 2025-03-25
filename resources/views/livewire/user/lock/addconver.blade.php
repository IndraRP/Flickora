<div class="create-conversation-container">
    <div class="card bg-dark text-light border-secondary">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Buat Percakapan Baru</h5>
        </div>
        <div class="card-body">
            <!-- Pencarian Pengguna -->
            <div class="form-group mb-3">
                <label for="searchUser" class="text-light">Cari Pengguna</label>
                <input type="text" class="form-control bg-secondary text-light border-0" id="searchUser" wire:model.live.debounce.300ms="searchQuery" placeholder="Ketik nama atau email pengguna">
            </div>

            <!-- Hasil Pencarian -->
            @if (count($searchResults) > 0)
                <div class="search-results mb-3">
                    <div class="list-group">
                        @foreach ($searchResults as $user)
                            <a href="#" class="list-group-item list-group-item-action bg-dark text-light border-secondary" wire:click.prevent="selectUser({{ $user->id }})">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <h6 class="mb-1">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Daftar Pengguna yang Dipilih -->
            @if (count($selectedUsers) > 0)
                <div class="selected-users mb-3">
                    <h6 class="text-light">Pengguna yang Dipilih:</h6>
                    <div class="d-flex flex-wrap">
                        @foreach ($selectedUsers as $index => $user)
                            <div class="badge bg-primary mb-2 me-2 p-2">
                                {{ $user["name"] }}
                                <span class="text-dark ms-1" style="cursor: pointer;" wire:click="removeUser({{ $index }})">×</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Opsi Grup Chat -->
            @if (count($selectedUsers) > 1)
                <div class="form-check mb-3">
                    <input class="form-check-input bg-dark border-secondary" type="checkbox" id="isGroupChat" wire:model.live="isGroup">
                    <label class="form-check-label text-light" for="isGroupChat">
                        Buat sebagai Grup Chat
                    </label>
                </div>
            @endif

            <!-- Nama Grup (jika grup chat) -->
            @if ($isGroup)
                <div class="form-group mb-3">
                    <label for="groupName" class="text-light">Nama Grup</label>
                    <input type="text" class="form-control bg-secondary text-light border-0" id="groupName" wire:model="groupName" placeholder="Masukkan nama grup">
                </div>
            @endif

            <!-- Tombol Buat Percakapan -->
            <button class="btn btn-primary w-100" wire:click="createConversation" wire:loading.attr="disabled">
                <span wire:loading wire:target="createConversation">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                Buat Percakapan
            </button>
        </div>
    </div>
</div>
