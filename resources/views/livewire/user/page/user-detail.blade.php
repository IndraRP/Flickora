<div style="background-color: #1C1C1C">
    <div style="
    border-bottom-right-radius: 15px; 
    border-bottom-left-radius: 15px; 
    height: 225px; 
    width: 100%; 
    background: linear-gradient(to top,  rgba(1, 4, 30, 0.961),  rgba(1, 13, 30, 0.876), rgba(0, 0, 0, 0.087)), 
                url('{{ asset("storage/" . $user->background) }}'); 
    background-size: cover; 
    background-position: center;
">


        <div class="d-flex align-items-center fixed-top pb-3 pt-1" style="padding-left: 13px; padding-right: 13px;">
            <div class="d-flex me-auto mt-2">
                <i href="javascript:void(0)" onclick="handleBack()" class="fa-solid fa-chevron-left fs-6 fs-2 text-white"></i>
            </div>

            <div class="d-flex justify-content-center mt-2">
                {{-- style="margin-left: 100px;" --}}
                @if (strlen($user->name) > 15)
                    <div class="dropdown">
                        <button class="btn dropdown-toggle mb-0 bg-transparent text-white" style="flex-grow: 1; font-size: 16px;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Str::limit($user->name, 15, "") }}
                        </button>
                        <ul class="dropdown-menu" style="background-color: rgba(0, 0, 0, 0.4)">
                            <li class="ms-2 text-center text-white">{{ $user->name }}</li>
                        </ul>
                    </div>
                @else
                    <p class="fs-6 mb-0 text-white">{{ $user->name }}</p>
                @endif

            </div>

            <div class="d-flex ms-auto mt-2">
                {{-- <i class="bi bi-three-dots fs-6 text-white"></i>
                @if ($isPrivate == 1)
                    <i class="fa-solid fa-lock fs-6 text-white"></i>
                @else
                    <i class="fa-solid fa-lock-open fs-6 text-white"></i>
                @endif --}}

            </div>
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

        <script>
            function handleBack() {
                if (document.referrer) {
                    window.history.back();
                } else {
                    window.location.href = '/';
                }
            }
        </script>

        <div class="d-flex justify-content-center" style="padding-top: 112px;">
            <img class="rounded-pill mt-1" wire:click="setUser({{ $user->id }})" style="height: 80px; width: 80px; object-fit: cover;" src="{{ asset("storage/" . $user->avatar) }}" data-bs-toggle="modal" data-bs-target="#ProfilModal">

            <div class="d-block ms-3">
                <div class="d-flex justify-content-around text-center">
                    <div>
                        <p class="fs-6 mb-0 text-white">{{ $postsCount }}</p>
                        <p class="fs-7 mb-2" style="color:rgb(158, 158, 158)">Postingan</p>
                    </div>

                    <div class="mx-4">
                        <p class="fs-6 mb-0 text-white"> {{ $friendshipsCount[$user->id] ?? 0 }}</p>
                        <p class="fs-7 mb-2" style="color:rgb(158, 158, 158)">Teman</p>
                    </div>

                    <div>
                        <p class="fs-6 mb-0 text-white">{{ $totalLikes }}</p>
                        <p class="fs-7 mb-2" style="color:rgb(158, 158, 158)">Disukai</p>
                    </div>
                </div>

                <div class="d-flex">
                    <!-- Tombol Obrolan -->
                    @php
                        // Ambil ID dari URL saat ini
                        $currentUserId = auth()->id(); // ID user yang sedang login
                        $viewedUserId = request()->segment(2); // ID user yang sedang dilihat dari URL
                    @endphp

                    <a href='@if ($friendshipStatus && $friendshipStatus->status == "approved" && ($friendshipStatus->user_id == $currentUserId || $friendshipStatus->friend_id == $currentUserId)) {{ url("/chatify/" . $viewedUserId) }} 
                             @else 
                                javascript:void(0); @endif'>
                        <button class="btn fs-7 me-2 bg-transparent px-4" style="width: 115px; border-radius: 10px; padding-right: 35px; padding-left: 35px;
                        @if (!$friendshipStatus || $friendshipStatus->status != "approved" || ($friendshipStatus->user_id != $currentUserId && $friendshipStatus->friend_id != $currentUserId)) color: var(--bs-secondary); 
                            border-color: var(--bs-secondary); 
                            opacity: 0.5; 
                            cursor: not-allowed;
                        @else 
                            color: var(--bs-primary); 
                            border-color: var(--bs-primary); @endif" @if (!$friendshipStatus || $friendshipStatus->status != "approved" || ($friendshipStatus->user_id != $currentUserId && $friendshipStatus->friend_id != $currentUserId)) disabled @endif>
                            Obrolan
                        </button>
                    </a>

                    <!-- Tombol Undang -->
                    <button class="btn fs-7" wire:click="invite({{ $userId }})" style="width: 115px; border-radius: 10px; background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); color: white; border: none;" @if ($isFriend) disabled class="opacity-100"
                    @elseif($friendshipStatus && $friendshipStatus->status == "pending") 
                        disabled class="opacity-50"
                    @else
                        class="opacity-100" @endif>
                        Undang
                    </button>


                </div>
            </div>

        </div>
    </div>

    <style>
        #userScroll {
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
            scrollbar-width: none;
            /* Firefox */
        }

        #userScroll::-webkit-scrollbar {
            display: none;
            /* Safari dan Chrome */
        }
    </style>

    @if (!$friendshipStatus)
    @else
        <div class="pb-0 pt-3" style="white-space: nowrap; position: relative; overflow-x: auto; padding-left: 10px; padding-right: 10px;" id="userScroll">
            <div style="display: inline-flex; min-width: 100%; width: fit-content; justify-content: flex-end;">
                @foreach ($users->take(10) as $user)
                    <div class="rounded-pill" style="flex-shrink: 0; width: 63px; {{ $loop->last ? "" : "margin-right: 10px;" }} position: relative;">
                        <img src="{{ asset("storage/" . $user->background) }}" alt="{{ $user->username }}" class="d-block rounded-pill border border-white" style="height: 63px; width: 100%; border: none; box-shadow: none; object-fit: cover;">
                        <p class="fs-8 mb-0 mt-2 text-center text-white">1234567890</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var container = document.getElementById("userScroll");
            container.scrollLeft = container.scrollWidth;
        });
    </script>

    <div style="background-color: #0c0b0b; padding-left: 5px; padding-right:5px; border-top-right-radius: 15px; border-top-left-radius: 15px; ">
        <div class="d-flex justify-content-around px-3 pt-3">
            <div class="menu-item active" onclick="scrollToSection(0)">
                <i class="bi bi-grid-3x3-gap-fill fs-5 text-white"></i>
            </div>

            <div class="menu-item" onclick="scrollToSection(1)">
                <i class="bi bi-camera-reels-fill fs-5 text-white"></i>
            </div>

            <div class="menu-item" onclick="scrollToSection(2)">
                <i class="bi bi-person-lines-fill fs-3 text-white"></i>
            </div>
        </div>

        <hr class="style-two mb-0 mt-1">

        <div class="d-flex justify-content-center mt-2" style="padding-bottom: 40px;">
            <div class="content-container" onscroll="highlightActiveSection()" style="padding-bottom:40px;">
                <div class="content-section">
                    @if ($posts->isEmpty())
                        <div class="">
                            <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px;">
                                <img src="{{ asset("images/animasi1.svg") }}" style="width: 300px; height: auto;" loading="lazy">
                            </div>
                            <div style="margin-top: 0px;">
                                <p class="text-center text-white">Belum ada postingan.</p>
                            </div>
                        </div>
                    @else
                        <div class="row g-2 rounded-top p-0 px-1">
                            @foreach ($posts->reverse() as $post)
                                <div class="col-4">
                                    <div style="position: relative;">
                                        <img src="{{ asset("storage/" . $post->image) }}" class="d-block rounded" style="height: 111px; width: 111px; border: none; box-shadow: none; object-fit: cover; cursor: pointer; 
                                        {{ $this->isPostReported($post->id) ? "filter: blur(10px); background-color: rgba(0, 0, 0, 0.5);" : "" }};" wire:click="saveUserAndPostIdToSession({{ $post->id }})" loading="lazy">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>


                <div class="content-section">
                    <div class="">
                        <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px;">
                            <img src="{{ asset("images/animasi3.svg") }}" style="width: 300px; height: auto;" loading="lazy">
                        </div>
                        <div style="margin-top: 0px;">
                            <p class="text-center text-white">Belum ada postingan video.</p>
                        </div>
                    </div>
                </div>

                <div class="content-section">
                    @if ($tags->isEmpty())
                        <div class="">
                            <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px;">
                                <img src="{{ asset("images/animasi2.svg") }}" style="width: 300px; height: auto;" loading="lazy">
                            </div>
                            <div style="margin-top: 0px;">
                                <p class="text-center text-white">Belum ada ditandai.</p>
                            </div>
                        </div>
                    @else
                        <div class="row g-2 rounded-top p-0 px-1">
                            @foreach ($tags->reverse() as $tag)
                                @if ($tag->post)
                                    {{-- Pastikan post tidak null --}}
                                    <div class="col-4">
                                        <div style="position: relative;">
                                            <img src="{{ asset("storage/" . $tag->post->image) }}" class="d-block rounded" style="height: 111px; width: 111px; border: none; box-shadow: none; object-fit: cover; cursor: pointer; 
                                        {{ $this->isPostReported($tag->post->id) ? "filter: blur(10px); background-color: rgba(0, 0, 0, 0.5);" : "" }};" wire:click="saveUserAndTagIdToSession({{ $tag->id }})" loading="lazy">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function scrollToSection(index) {
            const container = document.querySelector('.content-container');
            const sections = document.querySelectorAll('.content-section');
            container.scrollTo({
                left: sections[index].offsetLeft,
                behavior: "smooth"
            });

            updateActiveButton(index);
        }

        function highlightActiveSection() {
            const container = document.querySelector('.content-container');
            const sections = document.querySelectorAll('.content-section');
            let currentIndex = 0;

            sections.forEach((section, index) => {
                if (container.scrollLeft >= section.offsetLeft - section.offsetWidth / 2) {
                    currentIndex = index;
                }
            });

            updateActiveButton(currentIndex);
        }

        function updateActiveButton(index) {
            document.querySelectorAll('.menu-item').forEach((item, i) => {
                item.classList.toggle('active', i === index);
            });
        }
    </script>

    <style>
        .content-container {}

        #header {
            background: transparent;
            color: white;
            transition: background 0.3s, color 0.3s;
        }

        #header.scrolled {
            background: white;
            color: black;
        }

        #header svg {
            transition: color 0.3s;
        }

        .menu-item {
            cursor: pointer;
            position: relative;
        }

        .menu-item.active::after {
            content: "";
            position: absolute;
            background-color: #000000;
            transform: translateX(-50%);
            border-radius: 3px;
        }

        .menu-item.active i {
            background: linear-gradient(to right, #1547CE, #3d6eaf, #4c89d4);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }

        .content-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .content-section {
            min-width: 100%;
            scroll-snap-align: start;
            padding: 1px;
        }

        .gallery {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .gallery img {
            width: 100%;
            border-radius: 15px;
            object-fit: cover;
        }
    </style>

    {{-- <div class="mt-3" style="background-color: #0b0b0c; padding-left: 5px; padding-right:5px; border-top-right-radius: 15px; border-top-left-radius: 15px; ">
        <div class="d-flex justify-content-around px-3 pt-3">
            <i class="bi bi-grid-3x3-gap-fill fs-5" style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); -webkit-background-clip: text; background-clip: text; color: transparent;"></i>
            <i class="bi bi-camera-reels-fill fs-5 text-white"></i>
            <i class="bi bi-person-lines-fill fs-3 text-white"></i>
        </div>

        <hr class="style-two mb-0 mt-1">

        <!-- Grid Postingan -->
        <div class="d-flex justify-content-center mt-2" style="padding-bottom: 20px;">
            <div class="row g-2 rounded-top p-0 px-1">
                @foreach ($posts as $post)
                    <div class="col-4">
                        <div style="position: relative;">
                            <img src="{{ asset("storage/" . $post->image) }}" class="d-block {{ !$friendshipStatus && $isPrivate == 1 ? "blur-content" : "" }} rounded" style="height: 111px; width: 111px; border: none; box-shadow: none; object-fit: cover; cursor: pointer;
                                   {{ !$friendshipStatus && $isPrivate == 1 ? "filter: blur(6px);" : "" }}" wire:click="saveUserAndPostIdToSession({{ $post->id }})">
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}

    @if (!$friendshipStatus)
        <div class="d-flex justify-content-center pb-3" data-bs-toggle="modal" data-bs-target="#UndangModal">
            <div class="d-block">
                <div class="d-flex justify-content-center">
                    <i class="bi bi-cloud-arrow-up-fill fs-3 text-white"></i>
                </div>
                <p class="text-white" style="margin-top: -5px;">Lihat Lebih Banyak</p>
            </div>
        </div>
    @else
    @endif

    <div class="modal fade" id="UndangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body py-5">
                    <div class="d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/9977/9977298.png" style=" width: 150px; height: 150px;">
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <p class="fs-6 text-center text-white">Untuk melihat lebih banyak postingan, anda harus undang pertemanan terlebih dahulu.</p>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <button type="button" class="btn border-primary border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                        <button wire:click="invite({{ $userId }})" class="border-primary ms-3 rounded border text-white" style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); width: 100px; height: 40px;">Undang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}


    {{-- <!-- MODAL DITEMPATKAN DI LUAR LOOP -->
        @foreach ($posts as $post)
            <div class="modal fade" id="PostModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content bg-dark">
                        <div class="modal-header text-align-center border-0 pb-0">
                            <h5 class="modal-title text-white" id="exampleModalLongTitle">{{ $user->name }}</h5>

                            @php
                                $isLiked = $post->likes->where("user_id", auth()->id())->count() > 0;
                            @endphp

                            <i class="bi {{ $isLiked ? "bi-heart-fill text-danger" : "bi-heart text-white" }} fs-5 ms-auto mt-2" wire:click="toggleLike({{ $post->id }})" style="cursor: pointer;"></i>
                        </div>
                        <div class="modal-body pt-1 text-center">
                            <img class="rounded" style="height: 350px; width: 100%; object-fit: cover;" src="{{ asset($post->image) }}">

                            @php
                                $words = explode(" ", $post->content);
                                $firstLine = implode(" ", array_slice($words, 0, 10)); // 10 kata pertama
                                $secondLine = implode(" ", array_slice($words, 10)); // Sisanya
                            @endphp

                            <p class="fs-6 mt-3 text-white">
                                {{ $firstLine }}
                                @if ($secondLine)
                                    <br>{{ $secondLine }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}



    <style>
        .style-two {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));
        }

        .blur-content {
            filter: blur(5px);
            pointer-events: none;
        }
    </style>

    <!-- Modal -->
    <div class="modal fade" id="ProfilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body">
                    <img class="rounded" style="height: 350px; width: 100%; object-fit: cover;" src="{{ asset($avatar) }}">
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Modal untuk setiap postingan -->
    <div class="modal fade" id="PostModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ $user->name }}</h5>
                </div>
                <div class="modal-body text-center">
                    <img class="rounded" style="height: 350px; width: 100%; object-fit: cover;" src="{{ asset($post->image) }}">
                    <p class="fs-7 mt-3 text-white">{{ $post->content }}</p>
                </div>
            </div>
        </div>
    </div> --}}

</div>
