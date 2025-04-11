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

        <a href="/grup_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://i.pinimg.com/474x/18/6b/ec/186bec1ba2207567d10266fc9d21e25e.jpg" style="width: 45px; height: 45px; object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Jual Beli Musang</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">garangan, pakan ayam 50k sak kandange...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">sekarang</p>
                </div>
            </div>
        </a>

        <a href="/grup_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://i.pinimg.com/474x/eb/55/fe/eb55fe9707332b294cf9a305effe64da.jpg" style="width: 45px; height: 45px;  object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Bebek Balap Surabaya</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">fuck bro...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">3 menit</p>
                </div>
            </div>
        </a>

        <a href="/grup_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://i.pinimg.com/474x/f4/28/d3/f428d3ce761fc349c7719f971e78dd49.jpg" style="width: 45px; height: 45px;   object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Sapi Kerdil Surabaya</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">Seng minat, sapi balap...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">5 menit</p>
                </div>
            </div>
        </a>

        <a href="/grup_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://i.pinimg.com/474x/00/bc/26/00bc2669c1259584fd1085c5bd858cfb.jpg" style="width: 45px; height: 45px;  object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Kretek Ilegal</p>
                    <p class="fs-7 mb-0" style="color: rgb(188, 188, 188)">Wow I love win click...</p>
                </div>

                <div class="ms-auto">
                    <p class="fs-7" style="color: rgb(188, 188, 188)">6 menit</p>
                </div>
            </div>
        </a>

        <a href="/grup_detail" class="text-decoration-none text-white">
            <div class="d-flex align-items-center" style="margin-top: 20px;">
                <img src="https://cdn-icons-png.flaticon.com/128/17811/17811354.png" style="width: 45px; height: 45px;  object-fit:cover" class="rounded-pill">
                <div class="ms-2">
                    <p class="fs-10" style="font-weight: 500; margin-bottom:1px;">Ronaldo Fans</p>
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
