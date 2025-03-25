<div>
    <div class="text-white">
        <div class="fixed-top border-0 p-3" style="background-color:#171717">
            <h5 class="modal-title ms-2">Postingan Baru</h5>
        </div>

        <div class="mx-4 text-center" style="margin-top: 85px;">
            <!-- Tampilkan Preview Gambar -->
            @if ($imagePreview)
                <img src="{{ $imagePreview }}" class="img-fluid mb-3 rounded" style="max-height: 420px; width: 350px; object-fit: cover;">
            @endif

            <div class="d-flex justify-content-start">
                <label for="content" class="form-label fs-7 mb-1">Deskripsi Post</label>
            </div>
            <textarea class="form-control bg-dark text-white" wire:model="content" required></textarea>

            <!-- Tagging Friends -->
            <div>
                <!-- Form pencarian teman -->
                <div class="relative mt-3">
                    <div class="form-group text-start">
                        <label for="friendSearch" class="fs-7 mb-1 text-white">Tag Teman</label>
                        <input type="text" id="friendSearch" class="form-control bg-dark text-white" placeholder="Ketik nama teman..." wire:model.live.debounce.300ms="searchQuery">
                    </div>

                    <div wire:loading wire:target="searchQuery" class="mt-1 text-white">
                        <small>Mencari...</small>
                    </div>

                    <!-- Hasil pencarian -->
                    @if (!empty($searchResults) && count($searchResults) > 0)
                        <div class="bg-secondary absolute z-10 mt-1 w-full rounded p-2">
                            @foreach ($searchResults as $friend)
                                <div class="hover:bg-primary cursor-pointer rounded p-2 text-white" wire:click="addTaggedUser({{ $friend["id"] }})">
                                    <div class="d-flex align-items-center">
                                        @if (isset($friend["avatar"]))
                                            <img src="{{ asset("storage/" . $friend["avatar"]) }}" class="rounded-circle mr-2" width="30" height="30" alt="Profile">
                                        @else
                                            <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center mr-2" style="width: 30px; height: 30px;">
                                                <span>{{ substr($friend["name"], 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <span>{{ $friend["name"] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Daftar teman yang sudah ditandai -->
                    <div class="mt-2">
                        @foreach ($taggedUsers as $index => $userId)
                            <span class="badge bg-primary me-1" wire:click="removeTaggedUser({{ $index }})" style="cursor: pointer;">
                                {{ $this->getUserName($userId) }} ×
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- <p class="text-white">Debug Search Query: {{ $debugSearchQuery }}</p> --}}

        </div>

        <div class="d-flex justify-content-center border-0 pb-5 pt-3">
            <button wire:click="savePost" class="btn rounded border-0 text-white" style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); width: 200px;">
                Upload
            </button>
        </div>
    </div>
</div>
