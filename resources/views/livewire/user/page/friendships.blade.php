<div>

    <div class="fixed-top rounded-bottom px-2 py-2" style="background-color: rgba(12, 11, 11, 0.9);">
        <div class="d-flex">
            <div class="d-flex me-auto pt-1">
                <a href="javascript:void(0)" onclick="handleBack()"><i class="fa-solid fa-chevron-left fs-6 rounded-pill text-white" style="background-color: #24232300; padding-top:13px; padding-bottom: 13px; padding-right: 17px; padding-left: 17px; margin-top: 3px; margin-bottom: 3px;"></i></a>
            </div>
            <div class="position-relative w-100 d-flex pt-1">
                <p class="mb-0 rounded px-3 text-center text-white" style="background-color: #24232300; padding-top: 5px; font-size: 17px; font-weight: 500; height: 35px; margin-top: 5px; margin-left: -5px;">Pertemanan</p>
            </div>

            <div class="ms-auto mt-2">
                <i class="fa-solid fa-magnifying-glass fs-6 rounded-pill me-1 text-white shadow-lg" style="padding-top:8px; padding-bottom: 0px; margin-top: 3px; margin-bottom: 3px; padding-right: 11px; padding-left: 11px;" data-bs-toggle="modal" data-bs-target="#searchModal"></i>
            </div>
        </div>
    </div>

    <!-- Search Filter Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" wire:ignore.self aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-body px-1">
                    <div class="d-flex fixed-top px-2 py-3" style="background-color: rgba(12, 11, 11, 0.9);">
                        <div class="search-container">
                            <input type="text" class="messenger-search bg-dark border-primary border text-white" placeholder="Ketik Di sini" wire:model="search" wire:keydown.enter="searchUsers" />
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .messenger-search {
            width: 100%;
            padding: 10px 40px 10px 15px;
            /* Ruang untuk ikon */
            border-radius: 8px;
            font-size: 14px;
        }

        .search-container {
            position: relative;
            width: 100%;
        }

        .search-container i {
            position: absolute;
            top: 50%;
            right: 23px;
            /* Jarak dari kanan */
            transform: translateY(-50%);
            font-size: 16px;
            color: white;
        }
    </style>

    <script>
        function handleBack() {
            if (document.referrer) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }
    </script>

    {{-- <div class="row d-flex justify-content-center ms-1 px-1" style="margin-top : 115px;">
        <div class="row g-2 rounded-top p-0 px-1" style=" margin-right: -1px;">
            @foreach ($friendships as $user)
                <div class="col-4">
                    <div style="position: relative;">
                        <a href="/userdetail/{{ $user->id }}">
                            <img src="{{ "storage/" . $user->avatar }}" alt="{{ $user->username }}" class="d-block rounded" style="height: 110px; width: 110px; border: none; box-shadow: none; object-fit: cover;">
                        </a>
                        <div class="d-flex justify-content-center">
                            <div class="d-block me-2">
                                <p class="fs-7 mb-0 mt-1 text-center text-white">{{ Str::limit($user->username, 17, "...") }}</p>
                                <div class="d-flex justify-content-center" style="margin-top: -3px;">
                                    <i class="bi bi-person-fill fs-8 text-white" style="margin-top: 0px;"></i>
                                    <p class="fs-8 text-secondary mb-2 text-center" style="margin-left: 1px;">
                                        {{ $friendshipsCount[$user->id] ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}

    <div class="row g-2 rounded-top px-1" style="margin-left:2px; margin-top : 75px;">
        @if (!empty($searchResults))
            @foreach ($searchResults as $user)
                <div class="col-4">
                    <div style="position: relative;">
                        <a href="/userdetail/{{ $user->id }}">
                            <img src="{{ "storage/" . $user->avatar }}" alt="{{ $user->username }}" class="d-block rounded" style="height: 110px; width: 110px; border: none; box-shadow: none; object-fit: cover;">
                        </a>
                        <div class="d-flex justify-content-center">
                            <div class="d-block me-2">
                                <p class="fs-7 mb-0 mt-1 text-center text-white">{{ Str::limit($user->username, 17, "...") }}</p>
                                <div class="d-flex justify-content-center" style="margin-top: -3px;">
                                    <i class="bi bi-person-fill fs-8 text-white" style="margin-top: 0px;"></i>
                                    <p class="fs-8 text-secondary mb-2 text-center" style="margin-left: 1px;">
                                        {{ $friendshipsCount[$user->id] ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Jika tidak ada hasil pencarian, tampilkan data default -->
            @foreach ($friendships as $user)
                <div class="col-4">
                    <div style="position: relative;">
                        <a href="/userdetail/{{ $user->id }}">
                            <img src="{{ "storage/" . $user->avatar }}" alt="{{ $user->username }}" class="d-block rounded" style="height: 110px; width: 110px; border: none; box-shadow: none; object-fit: cover;">
                        </a>
                        <div class="d-flex justify-content-center">
                            <div class="d-block me-2">
                                <p class="fs-7 mb-0 mt-1 text-center text-white">{{ Str::limit($user->username, 17, "...") }}</p>
                                <div class="d-flex justify-content-center" style="margin-top: -3px;">
                                    <i class="bi bi-person-fill fs-8 text-white" style="margin-top: 0px;"></i>
                                    <p class="fs-8 text-secondary mb-2 text-center" style="margin-left: 1px;">
                                        {{ $friendshipsCount[$user->id] ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

</div>
