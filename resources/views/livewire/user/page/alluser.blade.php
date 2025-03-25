<div style="background-color: #1C1C1C">

    <style>
        .splide {
            padding-top: 10px;
            overflow: hidden;
            position: relative;
        }

        .splide__slide {
            overflow: hidden;
        }

        .splide__image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .splide__pagination {
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 2;
            margin: 0;
            padding: 0;
        }

        .splide_pagination_page {
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.504);
            transition: background 0.3s ease, transform 0.3s ease;
            width: 6px;
            height: 6px;
        }

        .splide_pagination_page.is-active {
            background: #c7980b8c;
            width: 8px;
            height: 8px;
        }

        .splide__track--draggable {
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;
        }

        .Splide @media (max-width: 600px) {
            .splide_pagination_page {
                width: 6px;
                height: 6px;
            }
        }
    </style>

    <div style="background-color: #0c0b0b" wire:ignore.self>
        <section class="splide pb-1 pt-0" style=" background-color: #0c0b0b" wire:ignore.self>
            <div class="splide__track" style="" wire:ignore.self>
                <ul class="splide__list" style="" wire:ignore.self>
                    @foreach ($banners as $banner)
                        <li class="splide__slide me-2" style="" wire:ignore.self>
                            <img src="{{ $banner->image }}" alt="Banner Image" class="splide__image" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </div>

    <section style="background-color: #0c0b0b;">

        <div class="d-flex fixed-top px-2 py-2" style="background-color: #0c0b0b00;">
            <div class="d-flex me-auto">
                <a href="/"><i class="fa-solid fa-chevron-left fs-6 rounded-pill text-white" style="background-color: #2423237c; padding-top:13px; padding-bottom: 13px; padding-right: 17px; padding-left: 17px; margin-top: 3px; margin-bottom: 3px;"></i></a>
            </div>
            <div class="position-relative w-100 d-flex">
                <p class="mb-0 rounded px-3 text-center text-white" style="background-color: #24232300; padding-top: 5px; font-size: 17px; font-weight: 500; height: 35px; margin-top: 5px; margin-left: -5px;">Cari Teman</p>
            </div>

            <div class="position-relative w-50">
                {{-- <input type="text" class="messenger-search bg-dark border-primary border text-white" placeholder="Ketik Di sini" wire:model="search" wire:keydown.enter="searchUsers" /> <!-- Menambahkan event Enter --> --}}
                <i class="fa-solid fa-magnifying-glass position-absolute top-50 translate-middle-y icon-shadow rounded-pill end-0 me-2 text-white" style="background-color: #2423237c; padding-top:13px; padding-bottom: 13px; padding-right: 13px; padding-left: 13px; margin-top: -1px; margin-bottom: 2px;" data-bs-toggle="modal" data-bs-target="#searchModal"></i>
            </div>

            <i class="bi bi-funnel fs-5 rounded-pill me-1 text-white shadow-lg" style="background-color: #2423237c; padding-top:8px; padding-bottom: 0px; margin-top: 3px; margin-bottom: 3px; padding-right: 11px; padding-left: 11px;" data-bs-toggle="modal" data-bs-target="#filterModal"></i>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let header = document.querySelector(".fixed-top");

                window.addEventListener("scroll", function() {
                    if (window.scrollY > 50) {
                        header.style.backgroundColor = "#1C1C1C"; // Warna abu-abu transparan
                    } else {
                        header.style.backgroundColor = "transparent"; // Kembali transparan
                    }
                });
            });
        </script>

        <div class="p-3">
            <div class="d-flex align-items-center">
                <p class="fs-6 mb-0 text-white">Selebriti</p>
                <a href="#alluser" class="text-decoration-none ms-auto">
                    <p class="fs-7 text-primary mb-0">Lihat Semua</p>
                </a>
            </div>

            <div class="pb-0 pt-2" style="white-space: nowrap; position: relative; overflow-x: auto">
                <div style="display: inline-flex; min-width: 100%; width: fit-content;">
                    @foreach ($users->filter(fn($user) => $user->id >= 10 && $user->id <= 20) as $user)
                        <a href="/userdetail/{{ $user->id }}" style="display: block; color: inherit; text-decoration: none;">
                            <div class="rounded" style="
                        flex-shrink: 0; 
                        width: 90px; 
                        {{ $loop->last ? "" : "margin-right: 10px;" }} position: relative;
                        background: linear-gradient(to top,  
                        rgba(4 24 65 / 90%),
                        rgba(7 45 101 / 80%),
                        rgba(255, 255, 255) ,
                        rgba(255, 255, 255) ,
                        rgba(255, 255, 255, 0.3)
                        ), url('{{ "storage/" . $user->avatar }}'); 
                        height: 120px;     background-size: cover; 
                        background-position: center;
                        background-blend-mode: multiply;">
                                {{-- <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="d-block rounded" style="height: 120px; width: 100%; border: none; box-shadow: none; object-fit: cover;"> --}}
                                <div class="d-flex mx-2" style="padding-top: 90px;">
                                    <i class="bi bi-person-fill fs-6 text-white" style="margin-top: 3px;"></i>
                                    <p class="fs-8 text-decoration-none mb-0 ms-1 mt-2 text-white" style="width: 100%;">
                                        {{ $friendshipsCount[$user->id] ?? 0 }}
                                    </p>
                                    @if (isset($friendshipsCount[$user->id]) && $friendshipsCount[$user->id] > 45)
                                        <i class="bi bi-patch-check-fill fs-6 ms-auto mt-1" style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); -webkit-background-clip: text; background-clip: text; color: transparent;"></i>
                                    @elseif (isset($friendshipsCount[$user->id]) && $friendshipsCount[$user->id] > 30)
                                        <i class="bi bi-patch-check-fill fs-6 ms-auto mt-1" style="background: linear-gradient(to right,#747474, #999999, #A0A0A0); -webkit-background-clip: text; background-clip: text; color: transparent;"></i>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <style>
        .messenger-search[type="text"] {
            margin: 0px 10px;
            width: calc(100% - 20px);
            border: none;
            padding: 8px 10px;
            border-radius: 6px;
            outline: none;
        }
    </style>

    <section class="mt-2" style="background-color: #0c0b0b">
        <div class="p-3">
            <div class="d-flex align-items-center">
                <p class="fs-6 mb-0 text-white">Rekomendasi</p>
                <a href="#alluser" class="text-decoration-none ms-auto">
                    <p class="fs-7 text-primary mb-0">Lihat Semua</p>
                </a>
            </div>

            <div class="pb-0 pt-2" style="white-space: nowrap; position: relative; overflow-x: auto">
                <div style="display: inline-flex; min-width: 100%; width: fit-content;">
                    @foreach ($users->take(10) as $user)
                        <div class="rounded-pill" style="flex-shrink: 0; width: 63px; {{ $loop->last ? "" : "margin-right: 10px;" }} position: relative;">
                            <a href="/userdetail/{{ $user->id }}" style="display: block; color: inherit; text-decoration: none;">
                                <img src="{{ "storage/" . $user->background }}" alt="{{ $user->username }}" class="d-block rounded-pill" style="height: 63px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
                                <p class="fs-8 mb-0 mt-1 text-center text-white">{{ Str::limit($user->username, 10, "...") }}</p>
                                <div class="d-flex justify-content-center">
                                    <i class="bi bi-person-fill fs-8 text-white" style="margin-top: -2px;"></i>
                                    <p class="fs-12 text-secondary mb-2 text-center" style="margin-left: 1px;"> {{ $friendshipsCount[$user->id] ?? 0 }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- border-top-right-radius: 15px; border-top-left-radius: 15px;  --}}

    <section id="alluser" class="mt-2">
        <div class="d-flex justify-content-center" style="background-color: #0c0b0b; ">
            <div class="d-block m-3">

                <div class="tes">
                    <div class="sticky py-2" id="stickyElement" style="margin-top : -3px;">
                        <p class="mb-0 text-white">Mari Berteman</p>
                    </div>
                </div>

                <style>
                    .tes {
                        min-height: 10vh;
                    }

                    .sticky {
                        position: sticky;
                        top: 1px;
                        color: white;
                        transition: all 0.3s;

                    }

                    .mt-5 {
                        margin-top: 63px !important;
                        z-index: 1000;
                    }

                    .bg-changed {
                        background: #1C1C1C;
                        margin-left: -15px;
                        padding: 10px;
                        width: 500px;
                        border-top: 1px solid #797979;
                        /* border-bottom: 1px solid #797979; */
                    }
                </style>

                <script>
                    window.addEventListener("scroll", function() {
                        let stickyElement = document.getElementById("stickyElement");
                        let elementTop = stickyElement.offsetTop;
                        let scrollPosition = window.scrollY;

                        // Jika sudah melewati titik tertentu dan posisi sticky berubah menjadi fixed
                        if (scrollPosition >= elementTop) {
                            stickyElement.classList.add("mt-5");
                            stickyElement.classList.add("bg-changed");
                            stickyElement.style.position = "fixed";
                            stickyElement.style.top = "0";
                        } else {
                            stickyElement.classList.remove("mt-5");
                            stickyElement.classList.remove("bg-changed");
                            stickyElement.style.position = "sticky";
                            stickyElement.style.top = "1px";
                        }
                    });
                </script>


                <div class="row d-flex justify-content-center" style="margin-top : -50px;">
                    <div class="row g-2 rounded-top p-0 px-1" style="margin-left: 5px; margin-right: -2px;">
                        @if (!empty($searchResults)) <!-- Menggunakan empty() untuk array -->
                            @foreach ($searchResults as $user)
                                <div>
                                    <div style="position: relative;">
                                        <a href="/userdetail/{{ $user->id }}">
                                            <img src="{{ $user->avatar ? asset("storage/" . $user->avatar) : asset("storage/users-avatar/avatar.png") }}" alt="{{ $user->username }}" class="d-block rounded" style="height: 100px; width: 100px; border: none; box-shadow: none; object-fit: cover;">
                                        </a>
                                        <div class="d-flex justify-content-center">
                                            <div class="d-block me-3">
                                                <p class="fs-11 mb-0 mt-1 text-center text-white" style="width: 100%;">{{ Str::limit($user->name) }}</p>
                                                <div class="d-flex justify-content-center">
                                                    <i class="bi bi-person-fill fs-7 text-white" style="margin-top: -1px;"></i>
                                                    <p class="fs-8 text-secondary mb-2 text-center" style="margin-left: 1px;"> {{ $friendshipsCount[$user->id] ?? 0 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Jika tidak ada hasil pencarian, tampilkan data default -->
                            @foreach ($users as $user)
                                <div class="col-4">
                                    <div style="position: relative;">
                                        <a href="/userdetail/{{ $user->id }}">
                                            <img src="{{ "storage/" . $user->avatar }} " alt="{{ $user->name }}" class="d-block rounded" style="height: 103px; width: 103px; border: none; box-shadow: none; object-fit: cover;">
                                        </a>
                                        <div class="d-flex justify-content-center">
                                            <div class="d-block me-2">
                                                <p class="fs-7 mb-0 mt-1 text-center text-white">{{ Str::limit($user->username, 17, "...") }}</p>
                                                <div class="d-flex justify-content-center" style="margin-top: -3px;">
                                                    <i class="bi bi-person-fill fs-8 text-white" style="margin-top: 0px;"></i>
                                                    <p class="fs-8 text-secondary mb-2 text-center" style="margin-left: 1px;"> {{ $friendshipsCount[$user->id] ?? 0 }} </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Filter Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" wire:ignore.self aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-body px-1">
                    <div class="position-relative w-100">
                        <input type="text" class="messenger-search bg-dark border-primary border text-white" placeholder="Ketik Di sini" wire:model="search" wire:keydown.enter="searchUsers" /> <!-- Menambahkan event Enter -->
                        <i class="bi bi-search position-absolute top-50 translate-middle-y end-0 me-4 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gender Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" wire:ignore.self aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title emas" id="filterModalLabel">Filter Berdasarkan Gender</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="genderFilter" class="form-label">Pilih Gender</label>
                        <select id="genderFilter" class="form-select bg-dark text-white" wire:model="genderFilter">
                            @foreach ($genderOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" wire:click="applyGenderFilter" data-bs-dismiss="modal">Terapkan</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push("scripts")
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var splide = new Splide('.splide', {
                type: 'loop',
                autoplay: true,
                interval: 3000,
                perPage: 1,
                pagination: true,
                arrows: false,
                snap: true,
            });

            splide.mount();
        });
    </script>
@endpush
