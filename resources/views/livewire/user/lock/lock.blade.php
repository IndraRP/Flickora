<div class="pb-5" style="background-image: url('https://i.pinimg.com/474x/cb/f9/9c/cbf99c5850e47ffcc9cb136183204d45.jpg'); background-size: cover; background-position: center;">
    <!-- Input PIN -->

    <div>
        @if ($hasPin)
            <div class="py-5">
                <div class="mx-3 rounded" style="background-color: rgba(62, 62, 62, 0.563); margin-top: 37px;">
                    <div class="d-flex justify-content-center">
                        <div id="lottie" class="d-flex justify-content-center align-items-center pt-3" style="width: 300px; height: 300px; transform: translateY(-10px);"></div>
                    </div>

                    <div style="margin-top: -60px;">
                        <p class="fs-5 fw-bolder mb-0 text-center text-white">Verifikasi Pin</p>
                        <p class="fs-10 fw-bolder text-center text-white">Masukkan Pin Anda!!!</p>

                        <div class="d-flex justify-content-center">
                            <form>
                                <div class="d-flex gap-2 text-white">
                                    <div class="d-flex justify-content-center gap-3 px-4">
                                        @for ($i = 0; $i < 5; $i++)
                                            <input type="tel" maxlength="1" pattern="[0-9]*" inputmode="numeric" class="form-control pin-input bg-dark text-center text-white" id="pin-{{ $i }}" oninput="moveToNext(this, {{ $i }})" onkeydown="moveToPrev(event, this, {{ $i }})" wire:model.live="pinArray.{{ $i }}" wire:input="checkPinCompletion">
                                        @endfor
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="d-flex p-4">
                            <p class="fs-10 text-primary me-3 ms-auto mt-1 text-center">Lupa Pin?</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (!$hasPin)
            <div style="padding-top: 1px;">
                <div class="mx-3 rounded" style="background-color: rgba(62, 62, 62, 0.563); margin-top: 37px;">
                    <div class="d-flex justify-content-center">
                        <div id="lottie" class="d-flex justify-content-center align-items-center pt-3" style="width: 250px; height: 250px; transform: translateY(-10px); margin-top: -5px;"></div>
                    </div>

                    <div style="margin-top: -60px;">
                        <p class="fs-5 fw-bolder mb-0 text-center text-white">Buat Pin</p>

                        <div class="d-flex justify-content-center">
                            <form wire:submit.prevent="savePin" style="width: 270px;">
                                <!-- PIN Baru -->
                                <div class="mb-3">
                                    <label for="pin" class="form-label fs-8 text-white">PIN Baru</label>
                                    <input type="password" class="form-control bg-dark text-white" id="pin" wire:model="pin" placeholder="Masukkan PIN baru" required maxlength="5" inputmode="numeric" pattern="[0-9]*">
                                    <span class="position-absolute end-0 top-0" onclick="togglePassword('pin', 'pin-icon')" style="cursor: pointer; margin-top: 290px; margin-right:55px;">
                                        <i id="pin-icon" class="fa fa-eye text-white"></i>
                                    </span>
                                    @error("pin")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Konfirmasi PIN -->
                                <div class="mb-3">
                                    <label for="confirm_pin" class="form-label fs-8 text-white">Konfirmasi PIN</label>
                                    <input type="password" class="form-control bg-dark text-white" id="confirm_pin" wire:model="confirmPin" placeholder="Masukkan ulang PIN" required maxlength="5" inputmode="numeric" pattern="[0-9]*">
                                    <span class="position-absolute end-0 top-0" onclick="togglePassword('confirm_pin', 'confirm_pin-icon')" style="cursor: pointer; margin-top: 373px; margin-right:55px;">
                                        <i id="confirm_pin-icon" class="fa fa-eye text-white"></i>
                                    </span>
                                    @error("confirmPin")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn border-0 text-white" style="background: linear-gradient(to right, #05288a, #1b457b, #4c89d4); width: 120px; height: 40px;">Simpan PIN</button>
                                </div>
                            </form>
                        </div>

                        <div class="d-flex justify-content-center p-4">
                            <p class="fs-10 me-3 mt-1 text-center text-white">Apakah Anda Lupa Pin? <a href="#" class="text-decoration-none"><span class="text-primary fs-10 ms-1" style="font-weight: 500">Klik Disini</span></a> </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

    <!-- Script JS -->
    <script>
        function moveToNext(currentInput, index) {
            if (currentInput.value.length === 1 && /^[0-9]$/.test(currentInput.value)) {
                const nextInput = document.querySelector(`#pin-${index + 1}`);
                if (nextInput) nextInput.focus();
            }
        }

        function moveToPrev(event, currentInput, index) {
            if (event.key === "Backspace" && currentInput.value === '') {
                const prevInput = document.querySelector(`#pin-${index - 1}`);
                if (prevInput) prevInput.focus();
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            Livewire.on('pinComplete', () => {
                console.log("PIN lengkap! Login otomatis...");
            });
        });
    </script>


    <!-- Lottie Animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '{{ asset("images/animation1.json") }}'
            });
        });
    </script>
</div>
