{{-- <div>
    <div style="background: linear-gradient(to right, #1547CE, #3d6eaf,  #4c89d4);
    z-index: 2; height:300px;">
        <div class="d-flex justify-content-center" style="padding-top: 60px;">
            <div class="d-block text-center">
                <img src="https://i.pinimg.com/474x/03/47/b3/0347b3676e6f6b8757ff2315c5710d44.jpg" class="bordered-image rounded-pill" style="width: 120px; height: 120px; object-fit: cover;" />
                <p class="mb-0 text-white" style="margin-top: 10px;">{{ $users["name"] }}</p>
                <p class="fs-7" style="color:#c1c1c1; margin-top: -2px;">{{ $users["email"] }}</p>

            </div>
        </div>

        <style>
            .bordered-image {
                border: 4px solid #fff;
                /* Warna putih */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                /* Bayangan lembut */
            }
        </style>

        <div>

            <div class="mx-3 rounded py-4" style="background-color: #0c0b0b; margin-top: 5px;">
                <div class="d-flex align-items-center fs-10 px-4 py-3" data-bs-toggle="modal" data-bs-target="#EditProfil">
                    <i class="bi bi-pencil-square text-white"></i>
                    <p class="fs-10 mb-0 ms-3 text-white">Edit Profile</p>
                    <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                </div>


                <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4">
                    <i class="bi bi-shield-lock text-white"></i>
                    <p class="fs-10 mb-0 ms-3 text-white">Edit Password</p>
                    <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                </div>

                <a href="/notif" class="text-decoration-none">
                    <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4">
                        <i class="bi bi-bell text-white"></i>
                        <p class="fs-10 mb-0 ms-3 text-white">Notifikasi Pertemanan</p>
                        <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                    </div>
                </a>

                <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4" onclick="window.location.href='mailto:indraridho08@gmail.com'" style="cursor: pointer;">
                    <i class="bi bi-headset text-white"></i>
                    <p class="fs-10 mb-0 ms-3 text-white">Hubungi Kami</p>
                    <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                </div>


                <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4" data-bs-toggle="modal" data-bs-target="#LogoutModal">
                    <i class="bi bi-box-arrow-right text-danger"></i>
                    <p class="text-danger fs-10 mb-0 ms-3">Logout</p>
                    <i class="fa-solid fa-chevron-right text-danger ms-auto"></i>
                </div>

            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="EditProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fs-7">
                    <form wire:submit.prevent="updateProfile">

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control bg-dark text-white" id="name" wire:model="users.name" required>
                            @error("users.name")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control bg-dark text-white" id="email" wire:model="users.email" required>
                            @error("users.email")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control bg-dark text-white" id="username" wire:model="users.username" required>
                            @error("users.username")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input type="text" class="form-control bg-dark text-white" id="address" wire:model="users.address">
                            @error("users.address")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control bg-dark text-white" id="no_hp" wire:model="users.no_hp">
                            @error("users.no_hp")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="laki_laki" value="laki_laki" wire:model="users.gender">
                                <label class="form-check-label" for="laki_laki">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="perempuan" value="perempuan" wire:model="users.gender">
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                            @error("users.gender")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="LogoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body py-5">
                    <div class="d-flex justify-content-center">
                        <img class="" style="height: 150px; width: 150px; object-fit: cover;" src="https://cdn-icons-png.flaticon.com/128/9119/9119167.png">
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <p class="fs-6 text-white">Apakah Anda Yakin untuk Keluar???</p>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <a href="/bio"><button class="btn border-primary mb-2 border text-white" style="width: 100px; height: 40px;">Tidak</button></a>
                        <button wire:click="logout" class="btn btn-danger ms-3 text-white" style="width: 100px; height: 40px;">Ya, Yakin</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div> --}}

<div>
    <style>
        .header {
            background: linear-gradient(to top, rgb(0, 0, 0), rgba(0, 0, 0, 0.643), rgba(0, 0, 0, 0.505)), url({{ asset("storage/" . $users["background"]) }});
            background-size: cover;
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 20px;
            padding-right: 20px;
            color: white;
            position: relative;
        }

        .header::after {
            content: "";
            position: absolute;
            bottom: -30px;
            left: 0;
            width: 100%;
            height: 54px;
            background: #1c1c1c00;
            border-radius: 50% 50% 0 0;
        }

        .profile-image {
            position: absolute;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 90px;
            height: 90px;
            border-radius: 20px;
            border: 3px solid white;
            z-index: 1;
        }

        .edit-icon {
            position: absolute;
            top: 83px;
            right: 110px;
            background: rgba(0, 0, 0, 0.838);
            color: white;
            border-radius: 15%;
            width: 26px;
            height: 26px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            cursor: pointer;
            z-index: 2;
        }
    </style>

    <div>
        <div class="header">
            <div class="position-relative">
                <img class="profile-image" src="{{ asset("storage/" . $users["avatar"]) }}" style="object-fit: cover;" alt="Meditation">
                <div class="edit-icon" data-bs-toggle="modal" data-bs-target="#EditAvatar"><i class="bi bi-pencil-square"></i></div>
            </div>

            <div style="margin-top: 115px;">
                <h5 class="fs-6 mb-0">{{ $users["name"] }}</h5>
                <p class="fs-10">{{ $users["email"] }} </p>
                {{-- <p class="fs-10">{{ $users["address"] }}</p> | <span>{{ $users["no_hp"] }} </span> --}}
            </div>

            <div class="d-flex justify-content-around" style="font-size: 14px;">
                <a href="/chatify" class="text-decoration-none">
                    <div class="d-block justify-content-center">
                        <i class="bi bi-chat-left-text-fill text-white" style="font-size: 12px;"></i>
                        <p class="fs-7 mb-0 text-white">100</p>
                        <p class="fs-8" style="color:rgb(119, 119, 119);">Pesan Baru</p>
                    </div>
                </a>


                <a href="/" class="text-decoration-none">
                    <div class="d-block justify-content-center text-white">
                        <i class="bi bi-postcard-heart-fill"></i>
                        <p class="fs-7 mb-0 text-white">{{ $postsCount }}</p>
                        <p class="fs-8" style="color:rgb(119, 119, 119);">Postingan</p>
                    </div>
                </a>

                <a href="/friendships" class="text-decoration-none">
                    <div class="d-block justify-content-center">
                        <i class="bi bi-person-vcard-fill text-white"></i>
                        <p class="fs-7 mb-0 text-white">{{ $friendshipsCount[$users["id"]] ?? 0 }}</p>
                        <p class="fs-8" style="color:rgb(119, 119, 119);">
                            Pertemanan
                        </p>
                    </div>
                </a>

                <a href="/grup" class="text-decoration-none">
                    <div class="d-block justify-content-center">
                        <i class="bi bi-people-fill text-white"></i>
                        <p class="fs-7 mb-0 text-white">100</p>
                        <p class="fs-8" style="color:rgb(119, 119, 119);">Grup Diikuti</p>
                    </div>
                </a>

            </div>
        </div>

        <div style=" z-index: 4;">
            <div class="mx-3 rounded py-3" style="background-color: #0c0b0b; margin-top: 20px;">
                <div class="d-flex align-items-center fs-10 px-4 py-3" data-bs-toggle="modal" data-bs-target="#EditProfil">
                    <i class="bi bi-pencil-square text-white"></i>
                    <p class="fs-10 mb-0 ms-3 text-white">Edit Profile</p>
                    <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                </div>

                <div>
                    @if ($hasPin)
                        <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4" data-bs-toggle="modal" data-bs-target="#EditPin">
                            <i class="bi bi-file-earmark-lock text-white" style="font-size: 17px"></i>
                            <p class="fs-10 mb-0 ms-3 text-white">Ubah Pin</p>
                            <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                        </div>
                    @endif

                    @if (!$hasPin)
                        <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4" data-bs-toggle="modal" data-bs-target="#BuatPin">
                            <i class="bi bi-file-earmark-lock text-white" style="font-size: 17px"></i>
                            <p class="fs-10 mb-0 ms-3 text-white">Buat Pin</p>
                            <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                        </div>
                    @endif
                </div>


                <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4" data-bs-toggle="modal" data-bs-target="#EditPassword">
                    <i class="bi bi-shield-lock text-white"></i>
                    <p class="fs-10 mb-0 ms-3 text-white">Ubah Kata Sandi</p>
                    <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                </div>

                <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4" onclick="window.location.href='mailto:indraridho08@gmail.com'" style="cursor: pointer;">
                    {{-- <i class="bi bi-headset text-white"></i> --}}
                    <i class="bi bi-telephone-outbound fs-10 text-white"></i>
                    <p class="fs-10 mb-0 ms-3 text-white">Hubungi Kami</p>
                    <i class="fa-solid fa-chevron-right ms-auto text-white"></i>
                </div>

                <div class="d-flex align-items-center fs-6 mt-2 px-4 pb-4" data-bs-toggle="modal" data-bs-target="#LogoutModal">
                    <i class="bi bi-box-arrow-right text-danger"></i>
                    <p class="text-danger fs-10 mb-0 ms-3">Logout</p>
                    <i class="fa-solid fa-chevron-right text-danger ms-auto"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Data Diri-->
    <div class="modal fade" id="EditProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <div class="text-center">
                        <div id="lottie2" class="d-flex justify-content-center align-items-center pt-3" style="margin-top: -15px; margin-left: 70px; width: 200px; height: 200px; transform: translateY(-10px);" x-data="{ animation: null }" x-init="animation = lottie.loadAnimation({
                            container: $el,
                            renderer: 'svg',
                            loop: true,
                            autoplay: true,
                            path: '{{ asset("images/animation2.json") }}'
                        });" wire:ignore>
                        </div>

                    </div>
                </div>
                <div class="modal-body fs-7" style="margin-top: -50px;">
                    <form wire:submit.prevent="updateProfile">

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control bg-dark text-white" id="name" wire:model="users.name" required>
                            @error("users.name")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Aktif</label>
                            <input type="email" class="form-control bg-dark text-white" id="email" wire:model="users.email" required>
                            @error("users.email")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control bg-dark text-white" id="username" wire:model="users.username" wire:keyup="checkUsername" wire:key="username-field" required>
                            @if ($isUsernameAvailable !== null)
                                @if (session()->has("error"))
                                    <small class="text-danger">{{ session("error") }}</small>
                                @elseif ($isUsernameAvailable)
                                    <small class="text-success">Username Tersedia</small>
                                @else
                                    <small class="text-danger">Username sudah dipakai</small>
                                @endif
                            @endif

                        </div>


                        <div class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn border-primary border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                            <button type="submit" class="btn ms-3 border-0 text-white" style="background: linear-gradient(to right, #05288a, #1b457b,  #4c89d4); width: 100px; height: 40px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Password-->
    <div class="modal fade" id="EditPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    {{-- <img src="https://cdn-icons-png.flaticon.com/128/11511/11511953.png" style=""> --}}
                    <div class="text-center">
                        <div id="lottie" class="d-flex justify-content-center align-items-center mx-auto pt-3" style="margin-top: -80px; width: 100%; height: 100%; transform: translateY(-10px);"></div>
                        <p class="fs-6 emas d-block" style="margin-top: -80px;">Ubah Password Anda!!! </p>
                    </div>
                </div>
                <div class="modal-body fs-7">
                    <form wire:submit.prevent="updatePassword">
                        <!-- Current Password -->
                        <!-- Current Password -->
                        <div class="mb-3" style="margin-top: -20px;">
                            <label for="current_password" class="form-label">Kata Sandi Lama</label>
                            <input type="password" class="form-control bg-dark text-white" id="current_password" wire:model="current_password" placeholder="Masukkan kata sandi lama" required>
                            <span class="position-absolute end-0 top-0" onclick="togglePassword('current_password', 'current-password-icon')" style="cursor: pointer; margin-top: 33px; margin-right:35px;">
                                <i id="current-password-icon" class="fa fa-eye text-white"></i>
                            </span>
                            @error("current_password")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control bg-dark text-white" id="new_password" wire:model="new_password" placeholder="Masukkan kata sandi baru" required>
                            <span class="position-absolute end-0 top-0" onclick="togglePassword('new_password', 'new-password-icon')" style="cursor: pointer; margin-top: 111px; margin-right:35px;">
                                <i id="new-password-icon" class="fa fa-eye text-white"></i>
                            </span>
                            @error("new_password")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" class="form-control bg-dark text-white" id="new_password_confirmation" wire:model="new_password_confirmation" placeholder="Konfirmasi kata sandi baru" required>
                            <span class="position-absolute end-0 top-0" onclick="togglePassword('new_password_confirmation', 'confirm-password-icon')" style="cursor: pointer; margin-top: 192px; margin-right:35px;">
                                <i id="confirm-password-icon" class="fa fa-eye text-white"></i>
                            </span>
                            @error("new_password_confirmation")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <style>
                            input::placeholder {
                                color: #9c9c9c !important;
                            }
                        </style>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn border-primary border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                            <button type="submit" class="btn ms-3 border-0 text-white" style="background: linear-gradient(to right, #05288a, #1b457b,  #4c89d4); width: 100px; height: 40px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pin-->
    <div class="modal fade" id="EditPin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    {{-- <img src="https://cdn-icons-png.flaticon.com/128/11511/11511953.png" style=""> --}}
                    <div class="text-center">
                        <div id="lottie5" class="d-flex justify-content-center align-items-center mx-auto pt-3" style="margin-top: -80px; width: 100%; height: 100%; transform: translateY(-10px);"></div>
                        <p class="fs-6 emas d-block" style="margin-top: -80px;">Ubah Pin Chat Privat Anda!!! </p>
                    </div>
                </div>
                <div class="modal-body fs-7">
                    <form wire:submit.prevent="updatePin">
                        <!-- Current PIN -->
                        <div class="mb-3">
                            <label for="current_pin" class="form-label">PIN Lama</label>
                            <input type="password" class="form-control bg-dark text-white" id="current_pin" wire:model="current_pin" placeholder="Masukkan PIN lama" required maxlength="5" inputmode="numeric" pattern="[0-9]*">
                            <span class="position-absolute end-0 top-0" onclick="togglePassword('current_pin', 'current_pin-icon')" style="cursor: pointer; margin-top: 53px; margin-right:35px;">
                                <i id="current_pin-icon" class="fa fa-eye text-white"></i>
                            </span>
                            @error("current_pin")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- New PIN -->
                        <div class="mb-3">
                            <label for="new_pin" class="form-label">PIN Baru</label>
                            <input type="password" class="form-control bg-dark text-white" id="new_pin" wire:model="new_pin" placeholder="Masukkan PIN baru" required maxlength="5" inputmode="numeric" pattern="[0-9]*">
                            <span class="position-absolute end-0 top-0" onclick="togglePassword('new_pin', 'new_pin-icon')" style="cursor: pointer; margin-top: 131px; margin-right:35px;">
                                <i id="new_pin-icon" class="fa fa-eye text-white"></i>
                            </span>
                            @error("new_pin")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm PIN -->
                        <div class="mb-3">
                            <label for="new_pin_confirmation" class="form-label">Konfirmasi PIN</label>
                            <input type="password" class="form-control bg-dark text-white" id="new_pin_confirmation" wire:model="new_pin_confirmation" placeholder="Konfirmasi PIN baru" required maxlength="5" inputmode="numeric" pattern="[0-9]*">
                            <span class="position-absolute end-0 top-0" onclick="togglePassword('new_pin_confirmation', 'confirm_pin-icon')" style="cursor: pointer; margin-top: 211px; margin-right:35px;">
                                <i id="confirm_pin-icon" class="fa fa-eye text-white"></i>
                            </span>

                            @error("new_pin_confirmation")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn border-primary border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                            <button type="submit" class="btn ms-3 border-0 text-white" style="background: linear-gradient(to right, #05288a, #1b457b, #4c89d4); width: 100px; height: 40px;">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Buat Pin-->
    <div class="modal fade" id="BuatPin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    {{-- <img src="https://cdn-icons-png.flaticon.com/128/11511/11511953.png" style=""> --}}
                    <div class="text-center">
                        <div id="lottie6" class="d-flex justify-content-center align-items-center mx-auto pt-3" style="margin-top: -80px; width: 100%; height: 100%; transform: translateY(-10px);"></div>
                        <p class="fs-6 emas d-block" style="margin-top: -80px;">Buat Pin Chat Privat Anda!!! </p>
                    </div>
                </div>
                <div class="modal-body fs-7">
                    <form wire:submit.prevent="savePin">
                        <!-- PIN Baru -->
                        <div class="mb-3">
                            <label for="pin" class="form-label">PIN Baru</label>
                            <input type="password" class="form-control bg-dark text-white" id="pin" wire:model="pin" placeholder="Masukkan PIN baru" required maxlength="5" inputmode="numeric" pattern="[0-9]*">
                            <span class="position-absolute end-0 top-0" onclick="togglePassword('pin', 'pin-icon')" style="cursor: pointer; margin-top: 53px; margin-right:35px;">
                                <i id="pin-icon" class="fa fa-eye text-white"></i>
                            </span>
                            @error("pin")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Konfirmasi PIN -->
                        <div class="mb-3">
                            <label for="confirm_pin" class="form-label">Konfirmasi PIN</label>
                            <input type="password" class="form-control bg-dark text-white" id="confirm_pin" wire:model="confirmPin" placeholder="Masukkan ulang PIN" required maxlength="5" inputmode="numeric" pattern="[0-9]*">
                            <span class="position-absolute end-0 top-0" onclick="togglePassword('confirm_pin', 'confirm_pin-icon')" style="cursor: pointer; margin-top: 131px; margin-right:35px;">
                                <i id="confirm_pin-icon" class="fa fa-eye text-white"></i>
                            </span>
                            @error("confirmPin")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn border-primary border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                            <button type="submit" class="btn ms-3 border-0 text-white" style="background: linear-gradient(to right, #05288a, #1b457b, #4c89d4); width: 120px; height: 40px;">Simpan PIN</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, iconId) {
            let field = document.getElementById(fieldId);
            let icon = document.getElementById(iconId);

            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

    <!-- Modal Logout-->
    <div class="modal fade" id="LogoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body py-5">
                    <div class="d-flex justify-content-center">
                        <div id="lottie3" class="d-flex justify-content-center align-items-center pt-3" style="margin-top: -15px; width: 200px; height: 200px; transform: translateY(-10px);"></div>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <p class="fs-6 text-white">Apakah Anda Yakin keluar dari akun ini?</p>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <button wire:click="logout" class="btn btn-danger text-white" style="width: 100px; height: 40px;">Ya, Yakin</button>
                        <button type="button" class="btn border-primary ms-3 border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ganti Foto-->
    <div class="modal fade" id="EditAvatar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header d-block border-0">
                    <div id="lottie4" class="d-flex pt-3" style="margin-left:55px; margin-top: -15px; width: 200px; height: 200px; transform: translateY(-10px);"></div>
                    <h5 class="modal-title text-center" style=" margin-top: -35px;" id="exampleModalCenterTitle">Edit Foto</h5>
                </div>
                <div class="modal-body fs-7">
                    <form wire:submit.prevent="updatePhoto" enctype="multipart/form-data">
                        <!-- Avatar -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control bg-dark text-white" id="avatar" wire:model="avatar" accept="image/*">
                            @error("avatar")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="avatar">Mengunggah...</div>

                            @if ($avatar && !$errors->has("avatar"))
                                <div class="mt-2">
                                    <p class="text-success fs-8">Gambar berhasil dipilih:
                                        <strong>{{ $avatar->getClientOriginalName() }}</strong>
                                    </p>
                                </div>
                            @endif
                        </div>


                        <!-- Background -->
                        <div class="mb-3">
                            <label for="background" class="form-label">Latar Belakang</label>
                            <input type="file" class="form-control bg-dark text-white" id="background" wire:model="background" accept="image/*">
                            @error("background")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="background">Mengunggah...</div>

                            @if ($background && !$errors->has("background"))
                                <div class="mt-2">
                                    <p class="text-success fs-8">Gambar berhasil dipilih:
                                        <strong>{{ $background->getClientOriginalName() }}</strong>
                                    </p>
                                </div>
                            @endif

                        </div>

                        <div class="d-flex justify-content-center mb-2 mt-4">
                            <button type="button" class="btn border-primary border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                            <button type="submit" class="btn ms-3 border-0 text-white" style="background: linear-gradient(to right, #05288a, #1b457b,  #4c89d4); width: 100px; height: 40px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>

    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset("images/animation1.json") }}'
        });
    </script>

    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie5'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset("images/animation1.json") }}'
        });
    </script>

    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie6'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset("images/animation1.json") }}'
        });
    </script>

    {{-- <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie2'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset("images/animation2.json") }}'
        });
    </script> --}}

    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie3'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset("images/animation3.json") }}'
        });
    </script>

    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie4'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset("images/animation4.json") }}'
        });
    </script>

    <script>
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>



</div>
