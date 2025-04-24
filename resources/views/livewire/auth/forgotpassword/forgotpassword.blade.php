@section("title", "Auth ForgotPassword")

@section("styles")
    <style>
        .cont {
            padding-top: 170px;
            padding-bottom: 190px;
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

<div class="cont" style="background-image: url('https://i.pinimg.com/474x/93/f5/70/93f5702b543a87c5eefee4629a8932af.jpg'); background-size: cover; background-position: center; ">
    <div class="custom-margin-lg">
        <div class="row justify-content-center abu mx-4">
            <div class="col-md-6 col-lg-10 my-5">
                <h4 class="text-center text-white">Reset Password</h4>
                <p class="fs-7 text-center text-white">
                    Masukkan alamat email Anda yang telah terdaftar, dan kami akan mengirimkan link untuk mengatur ulang
                    kata sandi Anda.
                </p>
                <form wire:submit.prevent="sendResetLink">
                    @csrf
                    <div class="form-group emas">
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" class="form-control bg-secondary text-light border-primary" wire:model.defer="email" placeholder="Ketik di sini" required>

                        @error("email")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group d-flex justify-content-center mt-3">
                        <button type="submit" class="btn bg-primary fs-7 btn-sm booking-btn px-3 py-2 text-white" wire:loading.attr="disabled">
                            <span wire:loading.remove>Atur Ulang Kata Sandi</span>
                            <span wire:loading>Kirim...</span>
                        </button>
                    </div>

                </form>
            </div>


            <!-- Header dengan Tombol Kembali -->
            <div id="header" class="position-fixed w-100 atas start-0 top-0 transition-all">
                <div class="d-flex justify-content-between align-items-center p-1">
                    <!-- Tombol Kembali -->
                    <div class="d-flex align-items-center">
                        <a href="/login" id="backButton" class="rounded-circle my-1 p-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                        </a>
                        <!-- Text Detail Layanan -->
                        <p id="detailText" class="fs-6 fw-bolder ms-2 mt-3 text-white">Kembali ke Login</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
