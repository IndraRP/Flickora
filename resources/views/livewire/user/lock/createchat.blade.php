@section("styles")
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
@endsection

<div>
    <div class="d-flex fixed-top px-2 py-2" style="background-color: #0c0b0b00;">
        <div class="position-relative w-100 d-flex">
            <p class="mb-0 ms-auto rounded px-3 text-center text-white" style="background-color: #24232300; padding-top: 5px; font-size: 17px; font-weight: 500; height: 35px; margin-top: 5px; margin-left: -5px;">Chat Privat</p>
        </div>

        <div class="position-relative w-50">
            {{-- <input type="text" class="messenger-search bg-dark border-primary border text-white" placeholder="Ketik Di sini" wire:model="search" wire:keydown.enter="searchUsers" /> <!-- Menambahkan event Enter --> --}}
            <i class="fa-solid fa-magnifying-glass position-absolute top-50 translate-middle-y icon-shadow rounded-pill end-0 me-2 text-white" style="background-color: #2423237c; padding-top:13px; padding-bottom: 13px; padding-right: 13px; padding-left: 13px; margin-top: 4px; margin-bottom: 2px;" data-bs-toggle="modal" data-bs-target="#searchModal"></i>
        </div>
    </div>

    <div class="modal fade" id="searchModal" tabindex="-1" wire:ignore.self aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-body px-1">
                    <div class="position-relative w-100">
                        <input type="text" class="messenger-search bg-dark border-primary border text-white" placeholder="Ketik Di sini" wire:model="search" /> <!-- Menambahkan event Enter -->
                        <i class="bi bi-search position-absolute top-50 translate-middle-y end-0 me-4 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-3 text-white" style="margin-top: 60px;">
        <hr class="my-1" style="border: 0.1px solid white; width: 100%;">

        <a href="/chat_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://cdn-icons-png.flaticon.com/128/1999/1999625.png" style="width: 45px; height: 45px; object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Indra Pratama</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">Halo Bro you're sm...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">sekarang</p>
                </div>
            </div>
        </a>

        <a href="/chat_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://i.pinimg.com/474x/78/8a/e5/788ae53eaea906aaeff3b87e827d4d76.jpg" style="width: 45px; height: 45px;  object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Ricardo Kaka</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">fuck bro...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">3 menit</p>
                </div>
            </div>
        </a>

        <a href="/chat_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://i.pinimg.com/474x/05/49/0c/05490c6c166716655721225474609ef6.jpg" style="width: 45px; height: 45px;   object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Dybala Paulo</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">Hahaa, your pass broo...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">5 menit</p>
                </div>
            </div>
        </a>

        <a href="/chat_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://i.pinimg.com/474x/e0/56/dc/e056dc2c084781e62f26b17b0eb39eef.jpg" style="width: 45px; height: 45px;  object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Kevin DeBry</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">Wow your pass so smooth...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">6 menit</p>
                </div>
            </div>
        </a>

        <a href="/chat_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://cdn-icons-png.flaticon.com/128/1999/1999625.png" style="width: 45px; height: 45px;  object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Ronaldo</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">wtf!!!. Rsma your gf?...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">1 jam</p>
                </div>
            </div>
        </a>



    </div>
</div>

@push("scripts")
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
@endpush
