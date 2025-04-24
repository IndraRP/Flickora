@section("title", "Auth ResetPassword")

@section("styles")
    <style>
        .cont {
            padding-top: 80px;
            padding-bottom: 120px;
        }

        .btn-link {
            color: #007bff;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .abu {
            background-color: #292a2dc0;
            border-radius: 10px;
        }

        .atas {
            background-color: #1f2022;
            border-radius: 10px;
        }

        @media (min-width: 1024px) {
            .custom-margin-lg {
                margin-left: 30rem;
                margin-right: 30rem;
            }
        }
    </style>
@endsection

<div class="cont" style="background-image: url('https://i.pinimg.com/474x/4c/d5/a8/4cd5a8e1c4274bd8bef8d81a0a4fde55.jpg'); background-size: cover; background-position: center; padding-top:120px; padding-bottom:130px;">
    <div class="custom-margin-lg">
        <div class="row justify-content-center abu mx-4">
            <div class="col-md-6 col-lg-10 my-5">
                <h4 class="text-center text-white">Masukkan Password Baru Anda</h4>
                <p class="fs-7 text-center text-white">
                    Masukkan password baru Anda di bawah ini dan konfirmasikan password tersebut.
                </p>
                <form wire:submit.prevent="resetPassword">
                    <div class="position-relative mb-3">
                        <label for="new_password" class="form-label fs-7 text-white">Kata Sandi</label>
                        <input type="password" id="password" class="form-control bg-secondary text-light border-primary pe-5" wire:model.defer="password" placeholder="Ketik di sini" required>
                        <span class="position-absolute end-0 top-0 me-3" onclick="togglePassword('password', 'password-icon')" style="cursor: pointer; margin-top: 37px;">
                            <i id="password-icon" class="fa fa-eye text-white"></i>
                        </span>
                    </div>

                    <div class="position-relative mb-3">
                        <label for="confirm_password" class="form-label fs-7 text-white">Konfirmasi Kata Sandi</label>
                        <input type="password" id="confirm_password" class="form-control bg-secondary text-light border-primary pe-5" wire:model.defer="password_confirmation" placeholder="Ketik di sini" required>
                        <span class="position-absolute end-0 top-0 me-3" onclick="togglePassword('confirm_password', 'confirm-password-icon')" style="cursor: pointer; margin-top: 37px;">
                            <i id="confirm-password-icon" class="fa fa-eye text-white"></i>
                        </span>
                    </div>

                    <div class="form-group mt-3 text-end">
                        <button type="submit" class="btn bg-primary fs-7 btn-sm booking-btn p-2 text-white">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push("scripts")
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
@endpush
