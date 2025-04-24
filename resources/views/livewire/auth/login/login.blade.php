<div class="text-white" style="background-image: url('https://i.pinimg.com/736x/4d/5e/28/4d5e2825d57be679f64f1eb80fe54439.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; padding-top: 45px;">

    <div class="d-flex justify-content-center" style="margin-top: 20px; margin-bottom: 20px;">
        <img src="{{ asset("images/logo2.png") }}" style="width: 35px; height: 35px; margin-left: 40px;">
    </div>

    <style>
        @media (min-width: 992px) {
            #responsive-box {
                width: 50% !important;
            }
        }

        @media (max-width: 991.98px) {
            #responsive-box {
                width: 100% !important;
            }
        }
    </style>

    <div id="responsive-box" style="
        margin-left: auto;
        margin-right: auto;
        display: block;
        border-top-left-radius: 30px; 
        border-top-right-radius: 30px; 
        background-color: rgb(21, 21, 33); 
        height: 540px; 
        padding-top: 45px; 
        padding-left: 40px; 
        padding-right: 40px; 
        box-sizing: border-box;
    ">


        <form wire:submit.prevent="login">
            <h1 class="mb-3 text-center text-white">Masuk</h1>
            <div class="mb-2">
                <label for="email" class="form-label fs-10 mb-1">Email</label>
                <input type="email" id="email" wire:model="email" class="form-control bg-dark text-white" required />
                @error("email")
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fs-10 mb-1">Kata Sandi</label>
                <input type="password" id="password" wire:model="password" class="form-control bg-dark text-white" required />
                <span class="position-absolute end-0 top-0" onclick="togglePassword('password', 'password-icon')" style="cursor: pointer; margin-top: 322px; margin-right:55px;">
                    <i id="password-icon" class="fa fa-eye text-white"></i>
                </span>
                @error("password")
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center fs-10">
                <div class="form-check">
                    <input type="checkbox" id="remember" wire:model="remember" class="form-check-input">
                    <label for="remember" class="form-check-label fs-10">Ingat saya</label>
                </div>

                <div class="ms-auto">
                    <a class="text-decoration-none" href="/forgot-password">
                        <p class="text-primary mb-1">Lupa Kata Sandi</p>
                    </a>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Masuk</button>

        </form>

        <div class="d-flex align-items-center mt-3">
            <hr class="flex-grow-1">
            <p class="fs-7 mx-2 mb-0">Social Media</p>
            <hr class="flex-grow-1">
        </div>

        <div class="d-flex align-items-center justify-content-evenly mt-3">
            <img src="https://i.pinimg.com/474x/f9/22/b4/f922b43d9efdb857ea6c1221a0843e41.jpg" alt="" class="gambar">
            <img src="https://i.pinimg.com/474x/55/45/a2/5545a2a9ce938ec70e0941cdd7a82105.jpg" alt="" class="gambar">
            <img src="https://i.pinimg.com/474x/91/df/45/91df4505b989405c1b95045f5045955b.jpg" alt="" class="gambar">
            <img src="https://i.pinimg.com/474x/14/03/90/140390ee346b7376da34720e2de245f3.jpg" alt="" class="gambar">
        </div>

        <div class="d-flex align-items-center justify-content-center" style="margin-top: 30px">
            <p class="text-white" style="font-size: 13px;">Belum mempunyai akun??</p>
            <a href="/signup" class="text-decoration-none">
                <p class="text-primary ms-1" style="font-size: 14px; font-weight:500;">Daftar Sekarang</p>
            </a>
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

        <style>
            .gambar {
                width: 30px;
                height: 30px;
                object-fit: cover;
                border-radius: 4px;
            }
        </style>

    </div>

    <div style="background-color: rgb(21, 21, 33);">

    </div>

</div>
