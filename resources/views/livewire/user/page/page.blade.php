@section("styles")
    <style>
        .custom-navbar {
            position: fixed;
            bottom: 46px;
            left: 97%;
            transform: translateX(-50%);
            background: #133a699f;
            border-radius: 100%;
            padding-top: 12px;
            padding-bottom: 30px;
            padding-right: 5px;
            padding-left: 24px;
            display: flex;
            width: 21%;
            align-items: center;
            max-width: 350px;
        }

        .nav-btn {
            width: 5px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: transparent;
            color: white;
            margin-bottom: -9px;
            font-size: 19px;
            border: none;
            margin-bottom: -5px;
        }

        .custom-navbar2 {
            position: fixed;
            bottom: 46px;
            left: 3%;
            transform: translateX(-50%);
            background: #133a699f;
            border-radius: 100%;
            padding-top: 12px;
            padding-bottom: 30px;
            padding-right: 5px;
            padding-left: 42px;
            display: flex;
            width: 21%;
            align-items: center;
            max-width: 350px;
        }

        .nav-btn2 {
            width: 5px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: transparent;
            color: white;
            margin-bottom: -9px;
            font-size: 17px;
            border: none;
            margin-bottom: -5px;
        }

        /* .custom-navbar2 {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                position: fixed;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                bottom: 46px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                left: 3%;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                transform: translateX(-50%);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                background: #133a69cd;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                border-radius: 100%;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                padding-top: 12px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                padding-bottom: 31px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                padding-right: 5px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                padding-left: 28px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                display: flex;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                width: 17%;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                align-items: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                max-width: 350px;

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            .nav-btn2 {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                width: 5px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                height: 20px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                display: flex;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                align-items: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                justify-content: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                border-radius: 50%;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                background: transparent;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                color: white;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                margin-bottom: -9px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                font-size: 18px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                border: none;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                margin-bottom: -5px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } */
    </style>
@endsection

<div style="background-color: #1C1C1C">
    <div style="
    border-bottom-right-radius: 15px; 
    border-bottom-left-radius: 15px; 
    height: 225px; 
    width: 100%; 
    background: linear-gradient(to top,  rgba(1, 4, 30, 0.961),  rgba(1, 20, 46, 0.9), rgba(0, 0, 0, 0.2)), 
                url('{{ asset("storage/" . $background) }}'); 
    background-size: cover; 
    background-position: center;
    background-blend-mode: multiply;
">


        <div class="d-flex align-items-center fixed-top px-2 pb-2 pt-0">
            <div class="d-flex me-auto ms-1 mt-2">
                @if ($isPrivate == 1)
                    <i class="fa-solid fa-lock fs-6 text-white" data-bs-toggle="modal" data-bs-target="#nonprivateModal"></i>
                @else
                    <i class="fa-solid fa-lock-open fs-6 text-white" data-bs-toggle="modal" data-bs-target="#privateModal"></i>
                @endif
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{-- style="margin-left: 100px;" --}}
                @if (strlen($user->name) > 15)
                    <div class="dropdown" style="margin-bottom: 6px;">
                        <button class="btn dropdown-toggle mb-0 bg-transparent text-white" style="flex-grow: 1; font-size: 16px;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Str::limit($name, 15, "") }}
                        </button>
                        <ul class="dropdown-menu" style="background-color: rgba(0, 0, 0, 0.4)">
                            <li class="ms-2 text-center text-white">{{ $name }}</li>
                        </ul>
                    </div>
                @else
                    <p class="fs-6 text-white" style="margin-bottom: 9px;">{{ $name }}</p>
                @endif

            </div>


            <div class="d-flex ms-auto mt-2">
                <div class="me-3" style="margin-top:1px;">
                    <a href="/notif">
                        <i class="bi bi-bell-fill text-white"></i>
                    </a>
                </div>

                <!-- Overlay untuk background gelap -->
                <div id="dropdownOverlay" class="overlay"></div>

                <div class="dropdown">
                    <i class="bi bi-three-dots-vertical fs-6 text-white" data-bs-toggle="dropdown" aria-expanded="false"></i>

                    <ul class="dropdown-menu bg-dark">
                        <div>
                            <a class="dropdown-item bg-dark fs-10 text-white" onclick="document.getElementById('imageUpload').click();">
                                Ubah Foto Profil
                            </a>
                            <input type="file" id="imageUpload" wire:model="page_image" style="display: none;">
                        </div>

                        <div>
                            <a class="dropdown-item bg-dark fs-10 text-white" onclick="document.getElementById('backgroundUpload').click();">
                                Ubah Foto Latar Belakang
                            </a>
                            <input type="file" id="backgroundUpload" wire:model="background" style="display: none;">
                        </div>
                    </ul>
                </div>

                <style>
                    .overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.652);
                        /* Warna gelap transparan */
                        z-index: 999;
                        /* Pastikan di atas elemen lain */
                        display: none;
                        /* Default disembunyikan */
                    }
                </style>

                <script>
                    window.addEventListener('downloadFile', event => {
                        const url = event.detail.url;
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = url.substring(url.lastIndexOf('/') + 1);
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    });

                    document.addEventListener("DOMContentLoaded", function() {
                        const dropdown = document.querySelector(".dropdown");
                        const overlay = document.getElementById("dropdownOverlay");

                        dropdown.addEventListener("show.bs.dropdown", function() {
                            overlay.style.display = "block"; // Tampilkan overlay saat dropdown dibuka
                        });

                        dropdown.addEventListener("hide.bs.dropdown", function() {
                            overlay.style.display = "none"; // Sembunyikan overlay saat dropdown ditutup
                        });

                        // Menutup dropdown jika overlay diklik
                        overlay.addEventListener("click", function() {
                            document.querySelector(".dropdown .dropdown-menu.show")?.classList.remove("show");
                            overlay.style.display = "none";
                        });
                    });
                </script>

            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let header = document.querySelector(".fixed-top");

                function updateHeaderColor() {
                    if (window.scrollY === 0) {
                        header.style.backgroundColor = "transparent"; // Transparan jika di atas
                    } else {
                        header.style.backgroundColor = "#1C1C1C"; // Warna jika sudah di-scroll
                    }
                }

                // Atur warna saat halaman pertama kali dimuat
                updateHeaderColor();

                // Ubah warna saat user melakukan scroll
                window.addEventListener("scroll", updateHeaderColor);
            });
        </script>



        <div class="d-flex justify-content-center" style="padding-top: 112px;">
            <img class="rounded-pill mt-1" style="height: 80px; width: 80px; object-fit: cover;" src="{{ $user->page_image ? asset("storage/" . $user->page_image) : asset("storage/") }}" data-bs-toggle="modal" data-bs-target="#ProfilModal">

            <div class="d-block ms-3">
                <div class="d-flex justify-content-around text-center">
                    <div>
                        <p class="fs-6 mb-0 text-white">{{ $postsCount }}</p>
                        <p class="fs-7 mb-2" style="color:rgb(158, 158, 158)">Postingan</p>
                    </div>

                    <div class="">
                        <a href="/friendships" class="text-decoration-none">
                            <p class="fs-6 mb-0 text-white"> {{ $friendshipsCount[$user->id] ?? 0 }}</p>
                            <p class="fs-7 mb-2" style="color:rgb(158, 158, 158)">Pertemanan</p>
                        </a>
                    </div>

                    <div>
                        <p class="fs-6 mb-0 text-white">{{ $totalLikes }}</p>
                        <p class="fs-7 mb-2" style="color:rgb(158, 158, 158)">Disenangi</p>
                    </div>
                </div>

                <div class="d-flex">
                    <a href="/alluser"><button class="btn fs-7 border-0 px-2 text-white" style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); border-radius: 10px; width: 240px;">Cari Teman</button></a>
                    {{-- <button class="btn border-primary fs-7 mx-1 border bg-transparent px-3 text-white" style="border-radius: 10px; width: 80px;">Obrolan</button> --}}
                    {{-- <button class="btn fs-7" style="border-radius: 10px;  width: 80px; background: linear-gradient(to right, #000b57, #5592e2); color: white; border: none;">
                        Undang
                    </button> --}}
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

    <div class="d-flex align-items-center">
        <div class="pb-0 pt-2" style="white-space: nowrap; position: relative; overflow-x: auto;" id="userScroll">
            @if ($highlights->isEmpty())
                <div class="py-3 text-center text-white" style="width: 320px;">
                    <p class="fs-6">Tidak ada highlight tersedia.</p>
                </div>
            @else
                <div style="display: inline-flex; width: fit-content; justify-content: flex-end; margin-right: 0px;">
                    @foreach ($highlights->take(20) as $index => $highlight)
                        <div class="rounded-pill" wire:click="showHighlight({{ $index }})" style="flex-shrink: 0; width: 63px; cursor: pointer; 
                            {{ $loop->last ? "" : "margin-right: 10px;" }} 
                            {{ $loop->first ? "margin-left: 10px;" : "" }} 
                            position: relative;">
                            <img src="{{ asset("storage/" . $highlight->image) }}" alt="{{ $highlight->title }}" class="d-block rounded-pill mt-1" style="height: 63px; width: 100%; object-fit: cover;">
                            <p class="fs-8 mb-0 mt-2 text-center text-white">
                                {{ $highlight->title }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>


        <style>
            .modal-fullscreen {
                max-width: 100% !important;
                width: 100%;
                height: 647px;
                margin: 0;
            }

            .modal-body {
                padding: 0;
            }

            .swiper-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 647px;
            }

            .swiper-slide {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }

            .swiper-slide img {
                max-height: 100%;
                max-width: 100%;
                object-fit: cover;
            }

            .swiper-slide {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 647px;
                position: relative;
            }

            .slide-background {
                width: 100%;
                height: 100%;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
            }
        </style>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(() => {
                    var swiper = new Swiper(".swiper-container", {
                        loop: true, // Biarkan Swiper loop terus
                        slidesPerView: 1,
                        autoplay: {
                            delay: 5000, // Auto-scroll tiap 3 detik
                            disableOnInteraction: false, // Jangan berhenti kalau user geser
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                            renderBullet: function(index, className) {
                                let slide = document.querySelectorAll(".swiper-slide")[index];
                                let highlightId = slide ? slide.getAttribute("data-id") : index;
                                return `<span class="${className}" data-id="${highlightId}"></span>`;
                            },
                        },
                        on: {
                            slideChange: function() {
                                if (!swiper) return; // Pastikan swiper terinisialisasi
                                let selectedIndex = swiper.activeIndex; // Gunakan activeIndex

                                // Emit ke Livewire kalau ada
                                if (typeof Livewire !== "undefined" && Livewire.emit) {
                                    Livewire.emit("updateSelectedIndex", selectedIndex);
                                }

                                // Update title di frontend
                                let titleElement = document.getElementById("highlightTitle");
                                let slides = document.querySelectorAll(".swiper-slide img");
                                if (slides[selectedIndex]) {
                                    titleElement.innerText = slides[selectedIndex].alt;
                                }
                            }
                        }
                    });

                    // Event untuk menampilkan modal dan sinkronisasi Swiper
                    window.addEventListener("open-modal", (event) => {
                        var modal = new bootstrap.Modal(document.getElementById("highlightModal"));
                        modal.show();

                        setTimeout(() => {
                            if (swiper) {
                                swiper.update();
                                swiper.slideTo(event.detail.selectedIndex, 0);
                            }
                        }, 300);
                    });

                    // Event untuk update Swiper jika ada perubahan dari Livewire
                    window.addEventListener("update-swiper", (event) => {
                        if (swiper) {
                            swiper.slideTo(event.detail.selectedIndex, 300);
                        }
                    });

                    // Pastikan Swiper tetap sinkron saat modal ditampilkan
                    document.getElementById("highlightModal").addEventListener("shown.bs.modal", function() {
                        if (swiper) {
                            swiper.update();
                        }
                    });

                }, 300);
            });
        </script>

        <div class="parent-container">
            <div class="d-flex align-items-center justify-content-center position-outside">
                <i class="bi bi-images fs-6 text-white" style="margin-right: 20px" onclick="document.getElementById('highlightUpload').click();">
                </i>
                <input type="file" id="highlightUpload" wire:model="highlight" style="display: none;">
            </div>
        </div>

        <style>
            /* Pastikan parent tidak menyebabkan overflow */
            .parent-container {
                position: relative;
                width: 35%;
                height: 122px;
                /* Atur tinggi sesuai kebutuhan */
                overflow-x: hidden;
                /* Cegah halaman melebar */
                background: rgba(211, 211, 211, 0);
                /* Untuk cek batas parent */
            }

            /* Elemen tetap terlihat keluar dari parent */
            .position-outside {
                position: absolute;
                right: -27px;
                /* Keluar dari batas parent */
                top: 50%;
                transform: translateY(-50%);
                width: 65px;
                height: 115px;
                background-color: #133a699f;
                border-radius: 80px 0 0 80px;
                z-index: 10;
            }
        </style>



        <!-- Modal Input Title -->
        <div wire:ignore.self class="modal fade" id="highlightpostModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title">Tambahkan Judul</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-3 text-center">
                        <!-- Tampilkan Preview Gambar -->
                        @if ($imagePreview)
                            <img src="{{ $imagePreview }}" class="img-fluid rounded" style="max-height: 420px; width: 347px; object-fit:cover;" loading="lazy">
                        @endif

                        <div class="mt-2">
                            <div class="d-flex justify-content-start">
                                <label for="title" class="form-label fs-7 mb-1">Inputkan Judul</label>
                            </div>
                            <input type="text" wire:model="title" maxlength="10" placeholder="Maks. 10 karakter" class="form-control bg-dark text-center text-white">
                            <p class="fs-8 text-danger text-start">maksimal 10 karakter</p>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center border-0 pb-4 pt-0" style="margin-top: -25px;">
                        <button wire:click="saveHighlight" class="btn rounded border-0 text-white" style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); width: 200px;">Upload</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Event Modal -->
        <script>
            window.addEventListener('show-modal', () => {
                var modal = new bootstrap.Modal(document.getElementById('highlightpostModal'));
                modal.show();
            });

            window.addEventListener('hide-modal', () => {
                var modal = bootstrap.Modal.getInstance(document.getElementById('highlightpostModal'));
                modal.hide();
            });
        </script>


    </div>
    {{-- 
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var container = document.getElementById("userScroll");
            container.scrollLeft = container.scrollWidth;
        });
    </script> --}}

    {{-- <div style="margin-left: 100px;">
        <div class="rounded-pill fixed-top bg-white" style="padding: 10px; margin-left: 327px; margin-top: 100px;">
            <a href="/alluser">
                <i class="bi bi-images fs-6 text-dark ms-1"></i>
            </a>
        </div>
    </div> --}}


    <div style="background-color: #0c0b0b; padding-left: 5px; padding-right:5px; border-top-right-radius: 15px; border-top-left-radius: 15px; ">
        <div class="d-flex justify-content-around px-3 pt-3">
            <div class="menu-item active" onclick="scrollToSection(0)">
                <a class="text-decoration-none">
                    <i class="bi bi-grid-3x3-gap-fill fs-5 text-white"></i>
                </a>
            </div>

            <div class="menu-item" onclick="scrollToSection(1)">
                <a class="text-decoration-none">
                    <i class="bi bi-camera-reels-fill fs-5 text-white"></i>
                </a>

            </div>

            <div class="menu-item" onclick="scrollToSection(2)">
                <a class="text-decoration-none">
                    <i class="bi bi-person-lines-fill fs-3 text-white"></i>
                </a>
            </div>

        </div>

        <hr class="style-two mb-0 mt-1">

        <div class="d-flex justify-content-center mt-2" style="padding-bottom: 40px;">
            <div class="content-container" onscroll="highlightActiveSection()" style="padding-bottom:40px;">
                <div class="content-section" id="foto">
                    @if ($posts->isEmpty())
                        <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px;">
                            <img src="{{ asset("images/animasi3.svg") }}" style="width: 300px; height: auto;" loading="lazy">
                        </div>
                        <div style="margin-top: 0px;">
                            <p class="text-center text-white">Belum ada postingan.</p>
                        </div>
                    @else
                        <div class="row g-2 rounded-top p-0 px-1">
                            <div id="foto"></div>
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
                    @if ($videos->isEmpty())
                        <div class="" id="video">
                            <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px;">
                                <img src="{{ asset("images/animasi2.svg") }}" style="width: 300px; height: auto;" loading="lazy">
                            </div>
                            <div style="margin-top: 0px;">
                                <p class="text-center text-white">Belum ada ditandai.</p>
                            </div>
                        </div>
                    @else
                        <div class="row g-2 rounded-top p-0 px-1">
                            <div id="video"></div>
                            @foreach ($videos->reverse() as $video)
                                @if ($video->video)
                                    <div class="col-4">
                                        <div style="position: relative; cursor: pointer;" wire:click="saveUserAndVideoIdToSession({{ $video->id }})">

                                            {{-- Thumbnail Video --}}
                                            <video style="height: 111px; width: 100%; object-fit: cover; border-radius: 8px;" muted>
                                                <source src="{{ asset("storage/" . $video->video) }}" type="video/mp4">
                                            </video>

                                            {{-- Ikon Play --}}
                                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
                                            background: rgba(0, 0, 0, 0.5); border-radius: 50%; width: 40px; height: 40px; display: flex; 
                                            align-items: center; justify-content: center;">
                                                <i class="fa fa-play text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    @endif
                </div>

                <div class="content-section">
                    @if ($tags->isEmpty())
                        <div class="" id="tag">
                            <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px;">
                                <img src="{{ asset("images/animasi2.svg") }}" style="width: 300px; height: auto;" loading="lazy">
                            </div>
                            <div style="margin-top: 0px;">
                                <p class="text-center text-white">Belum ada ditandai.</p>
                            </div>
                        </div>
                    @else
                        <div class="row g-2 rounded-top p-0 px-1">
                            <div id="tag"></div>
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



        <!-- MODAL DITEMPATKAN DI LUAR LOOP -->
        {{-- @foreach ($posts as $post)
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


    </div>

    <style>
        .style-two {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));
        }
    </style>

    <!-- Modal -->
    <div class="modal fade" wire.ignore id="ProfilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body">
                    <img class="rounded" style="height: 350px; width: 100%; object-fit: cover;" src="{{ $user->page_image ? asset("storage/" . $user->page_image) : asset("storage/") }}">
                </div>
            </div>
        </div>
    </div>

    <div class="custom-navbar d-flex justify-content-between align-items-center container">
        <button class="nav-btn" id="photoBtn" onclick="document.getElementById('postUpload').click();">
            <span><i class="bi bi-camera-fill mt-3 text-white"></i></span>
        </button>
        <!-- Input File Disembunyikan -->
        <input type="file" id="postUpload" class="d-none" wire:model="post">
    </div>

    <script>
        window.addEventListener('show-post', () => {
            var modal = new bootstrap.Modal(document.getElementById('postModal'));
            modal.show();
        });

        window.addEventListener('hide-post', () => {
            var modal = bootstrap.Modal.getInstance(document.getElementById('postModal'));
            modal.hide();
        });
    </script>


    {{-- <div class="custom-navbar2 d-flex justify-content-between align-items-center container">
        <button class="nav-btn2" id="videoBtn" onclick="document.getElementById('videoUpload').click();">
            <span><i class="fa-solid fa-video text-white"></i></span>
        </button>

        <!-- Input File Disembunyikan -->
        <input type="file" class="d-none" id="videoUpload" wire:model="video" accept="video/mp4,video/mkv,video/avi,video/mov">
    </div> --}}


    <div class="custom-navbar2 d-flex justify-content-between align-items-center container">
        <button class="nav-btn2" id="videoBtn" onclick="document.getElementById('videoUpload').click();">
            <span><i class="fa-solid fa-video mt-1 text-white"></i></span>
        </button>
        <!-- Input File Disembunyikan -->
        <input type="file" id="videoUpload" class="d-none" wire:model="video" accept="video/*">
    </div>

    <!-- Modal Private-->
    <div class="modal fade" id="privateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body py-5">
                    <div class="d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/10484/10484590.png" style="width:100px; width:100px; ">
                    </div>
                    <div class="mt-4 text-center">
                        <p class="fs-6 text-white">Apakah Anda Yakin untuk memprivate akun ini?</p>
                        <p class="fs-7 text-white">Private akun akan membuat orang yang belum berteman dengan anda tidak bisa melihat postingan anda</p>
                    </div>
                    <div class="d-flex justify-content-evenly mx-2 mt-2">
                        <button type="button" class="btn border-danger border text-white" style="width: 130px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                        <button wire:click="togglePrivate" class="border-0 text-white" style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); border-radius: 10px; width: 130px; height: 40px;">Privat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nonprivateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body py-5">
                    <div class="d-flex justify-content-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/12795/12795843.png" style="width:100px; width:100px; ">
                    </div>
                    <div class="mt-4 text-center">
                        <p class="fs-6 text-white">Apakah Anda Yakin untuk membuka private akun ini?</p>
                        <p class="fs-7 text-white">Membuka Private akun akan membuat orang yang belum berteman dengan anda bisa melihat postingan anda</p>
                    </div>
                    <div class="d-flex justify-content-evenly mx-2 mt-2">
                        <button type="button" class="btn border-danger border text-white" style="width: 130px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                        <button wire:click="togglePrivate" class="border-0 text-white" style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4); border-radius: 10px; width: 130px; height: 40px;">Buka Privat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function navbarHandler() {
            return {
                triggerFileInput() {
                    this.$refs.fileInput.click();
                },
                handleFileUpload(event) {
                    // Cek file yang diupload
                    const file = event.target.files[0];
                    if (file) {
                        console.log('File yang diupload:', file.name);
                    }
                }
            };
        }


        function navbarHandler2() {
            return {

                triggerFileInput() {
                    // Menggunakan x-ref untuk mencari input file
                    this.$refs.fileInput.click();
                },

            };
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.querySelector(".content-container");
            const sections = document.querySelectorAll(".content-section");
            const menuItems = document.querySelectorAll(".menu-item");
            const sectionIds = ["foto", "video", "tag"];

            function updateActiveSection() {
                let currentIndex = 0;
                sections.forEach((section, index) => {
                    if (container.scrollLeft >= section.offsetLeft - section.offsetWidth / 2) {
                        currentIndex = index;
                    }
                });
                updateActiveButton(currentIndex);
                history.replaceState(null, null, `#${sectionIds[currentIndex]}`);
            }

            function scrollToSection(index) {
                container.scrollTo({
                    left: sections[index].offsetLeft,
                    behavior: "smooth"
                });
                updateActiveButton(index);
                history.replaceState(null, null, `#${sectionIds[index]}`);
            }

            function updateActiveButton(index) {
                menuItems.forEach((item, i) => {
                    item.classList.toggle("active", i === index);
                });
            }

            container.addEventListener("scroll", function() {
                clearTimeout(container.scrollTimeout);
                container.scrollTimeout = setTimeout(updateActiveSection, 100);
            });

            // Jika ada hash di URL, scroll otomatis ke bagian tersebut
            if (window.location.hash) {
                const targetId = window.location.hash.substring(1);
                const targetIndex = sectionIds.indexOf(targetId);
                if (targetIndex !== -1) {
                    scrollToSection(targetIndex);
                }
            }

            menuItems.forEach((item, index) => {
                item.addEventListener("click", () => scrollToSection(index));
            });
        });
    </script>



</div>
