<div>
    <div class="d-flex fixed-top px-2 py-2" style="background-color: #171616;">
        <div class="d-flex me-auto">
            <a href="/create_chat"><i class="fa-solid fa-chevron-left fs-6 rounded-pill text-white" style="background-color: #24232300; padding-top:13px; padding-bottom: 13px; padding-right: 17px; padding-left: 17px; margin-top: 3px; margin-bottom: 3px;"></i></a>
        </div>

        <div class="position-relative w-100 d-flex align-items-center">
            <img src="https://cdn-icons-png.flaticon.com/128/1999/1999625.png" style="width: 35px; height: 35px;">
            <p class="mb-0 rounded px-3 text-center text-white" style="background-color: #24232300; padding-top: 5px; font-size: 17px; font-weight: 500; height: 35px; margin-top: 5px; margin-left: -5px;">Indra Pratama</p>
        </div>

        <div class="position-relative w-50">
            <div class="dropdown">
                <i class="bi bi-three-dots-vertical fs-6 position-absolute top-50 translate-middle-y icon-shadow rounded-pill end-0 me-2 text-white" style="margin-top: 29px;" data-bs-toggle="dropdown" aria-expanded="false"></i>

                <ul class="dropdown-menu bg-dark">
                    <div>
                        <a class="dropdown-item bg-dark fs-10 text-white">
                            Hapus dari Privat
                        </a>
                        {{-- <input type="file" id="imageUpload" wire:model="page_image" style="display: none;"> --}}
                    </div>

                    <div>
                        <a class="dropdown-item bg-dark fs-10 text-white">
                            Bersihkan Pesan
                        </a>
                        {{-- <input type="file" id="backgroundUpload" wire:model="background" style="display: none;"> --}}
                    </div>
                </ul>
            </div>

        </div>
    </div>

    <div style="margin-top: 70px;" class="px-3">
        <div class="d-flex justify-content-center" style="color: #acacac">
            <p class="fs-7 mb-1">Hari Ini</p>
        </div>

        <div class="d-flex justify-content-end mt-2">
            <div style="max-width: 250px; background-color:#000b6d" class="rounded px-3 pt-3">
                <p class="fs-10 text-end" style="color: aliceblue">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, vero!
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-2">
            <div style="max-width: 250px; background-color:#000b6d" class="rounded px-3 pt-3">
                <p class="fs-10 text-end" style="color: aliceblue">
                    Lorem ipsum dolor sit amet consectetur.
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-start mt-2">
            <div style="max-width: 250px; background-color:#282828" class="rounded px-3 pt-3">
                <p class="fs-10 text-start" style="color: aliceblue">
                    Lorem ipsum dolor sit amet consectetur.
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-2">
            <div style="max-width: 250px; background-color:#000b6d" class="rounded px-3 pt-3">
                <p class="fs-10 text-end" style="color: aliceblue">
                    Gasssss
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-start mt-2">
            <div style="max-width: 250px; background-color:#282828" class="rounded px-3 pt-3">
                <p class="fs-10 text-start" style="color: aliceblue">
                    Halo Bro you're smart people
                </p>
            </div>
        </div>
    </div>


    <div class="d-flex align-items-center fixed-bottom px-3 py-3">
        @if (session()->has("pesan_error"))
            <div class="alert alert-danger w-100 p-1">
                {{ session("pesan_error") }}
            </div>
        @endif
        <input type="text" class="form-control custom-placeholder me-2 bg-transparent text-white" wire:model.defer="teks_komentar" placeholder="Ketik disini..." style="flex: 1;" wire:keydown.enter="tambahKomentar" />
        <button class="btn border-0" style="background: linear-gradient(to right, #1547CE, #3d6eaf, #4c89d4);">
            <i class="fa-solid fa-paper-plane fs-5 text-white" style="margin:3px;"></i>
        </button>
    </div>
    <style>
        .custom-placeholder::placeholder {
            color: rgb(159, 159, 159);
            opacity: 1;
        }
    </style>


</div>
