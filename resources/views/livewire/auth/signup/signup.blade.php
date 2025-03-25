<div class="text-white" style="background-image: url('{{ asset("https://i.pinimg.com/736x/4d/5e/28/4d5e2825d57be679f64f1eb80fe54439.jpg") }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    @if (session()->has("message"))
        <div class="alert alert-danger">{{ session("message") }}</div>
    @endif

    <div class="d-flex justify-content-center pb-3 pt-5" style="margin-left: 0px;">
        <div class="d-block">
            <div class="d-flex justify-content-center mb-1">
                <img src="{{ asset("images/logo2.png") }}" style="width: 35px; height: 35px;">
            </div>
            <h1 style="font-size: 20px;">Flickora</h1>
        </div>
    </div>

    <div style="border-top-left-radius: 30px; border-top-right-radius: 30px; background-color:rgb(21, 21, 33); height: screen; padding-left: 40px; padding-right: 40px; padding-top: 30px;">
        <form wire:submit.prevent="signup">
            <h1 class="mb-2 text-center text-white">Daftar</h1>

            <div class="mb-2">
                <label for="name" class="form-label fs-7 mb-1">Nama Lengkap</label>
                <input type="text" id="name" wire:model="name" class="form-control bg-dark text-white" required />
                @error("name")
                    <div class="text-danger fs-8">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="username" class="form-label fs-7 mb-1">Username</label>
                <input type="text" id="username" wire:model="username" class="form-control bg-dark text-white" required />
                @error("username")
                    <div class="text-danger fs-8">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="no_hp" class="form-label fs-7 mb-1">No.Handphone</label>
                <input type="number" id="no_hp" wire:model="no_hp" class="form-control bg-dark text-white" required />
                @error("no_hp")
                    <div class="text-danger fs-8">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tambahkan jQuery sebelum Select2 -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

            <!-- Select2 Custom -->
            <style>
                .select2-container .select2-selection--single {
                    background-color: #343a40 !important;
                    color: white !important;
                    border: 1px solid #495057 !important;
                    height: calc(2.25rem + 2px) !important;
                    padding: 0.375rem 0.75rem !important;
                }

                .select2-dropdown {
                    background-color: #343a40 !important;
                    color: white !important;
                    border: 1px solid #495057 !important;
                }

                .select2-results__option {
                    color: white !important;
                }

                .select2-results__option--highlighted[aria-selected] {
                    background-color: #007bff !important;
                }
            </style>

            <!-- Input Select2 -->
            <div class="mb-2">
                <label for="gender" class="form-label fs-7 mb-1 text-white">Jenis Kelamin</label>
                <select id="gender" wire:model="gender" class="form-select bg-dark select2 text-white" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="laki_laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
                @error("gender")
                    <div class="text-danger fs-8">{{ $message }}</div>
                @enderror
            </div>

            <!-- Inisialisasi Select2 -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    if (window.innerWidth > 768) { // Gunakan Select2 hanya di layar besar (tablet/desktop)
                        $('#gender').select2({
                            dropdownParent: $('body')
                        });
                    }
                });
            </script>


            <div class="position-relative mb-2">
                <label for="tanggal_lahir" class="form-label fs-7 mb-1">Tanggal Lahir</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border border-white text-white">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <input type="date" id="tanggal_lahir" wire:model="tanggal_lahir" class="form-control bg-dark text-white" required />
                </div>
                @error("tanggal_lahir")
                    <div class="text-danger fs-8">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-2">
                <label for="email" class="form-label fs-7 mb-1">Email</label>
                <input type="email" id="email" wire:model="email" class="form-control bg-dark text-white" required />
                @error("email")
                    <div class="text-danger fs-8">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2"5 <label for="password" class="form-label fs-7 mb-1">Kata Sandi</label>
                <input type="password" id="password" wire:model="password" class="form-control bg-dark text-white" required />
                <span class="position-absolute end-0 top-0" onclick="togglePassword('password', 'password-icon')" style="cursor: pointer; margin-top: 672px; margin-right:60px;">
                    <i id="password-icon" class="fa fa-eye text-white"></i>
                </span>
                @error("password")
                    <div class="text-danger fs-8">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label for="confirm_password" class="form-label fs-7 mb-1">Konfirmasi Kata Sandi</label>
                <input type="password" id="confirm_password" wire:model="confirm_password" class="form-control bg-dark text-white" required />
                <span class="position-absolute end-0 top-0" onclick="togglePassword('confirm_password', 'confirm_password-icon')" style="cursor: pointer; margin-top: 745px; margin-right:60px;">
                    <i id="confirm_password-icon" class="fa fa-eye text-white"></i>
                </span>
                @error("confirm_password")
                    <div class="text-danger fs-8">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
        </form>

        <div class="d-flex align-items-center justify-content-center mt-3 pb-4">
            <p class="text-white" style="font-size: 13px;">Sudah mempunyai akun?</p>
            <a href="/login" class="text-decoration-none">
                <p class="text-primary ms-1" style="font-size: 14px; font-weight:500;">Masuk Disini</p>
            </a>
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
</div>
