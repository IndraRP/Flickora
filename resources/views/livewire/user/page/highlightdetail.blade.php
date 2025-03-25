<div>
    <style>
        .modal-content {
            height: 100vh;
            overflow: hidden;
        }

        .modal-body {
            height: 100%;
            overflow: hidden;
        }

        .swiper-container {
            height: 100vh;
            overflow: hidden;
        }

        .modal-content {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Story Progress Bar Styles */
        .story-progress-container {
            display: flex;
            position: absolute;
            top: 50px;
            left: 0;
            right: 0;
            padding: 0 8px;
            z-index: 10;
        }

        .story-progress-bar {
            height: 3px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            margin: 0 2px;
            flex-grow: 1;
        }

        .story-progress-bar .progress {
            height: 100%;
            width: 0;
            background-color: #fff;
            border-radius: 3px;
            transition: width 5s linear;
        }

        .progress-active {
            width: 100% !important;
        }

        .progress-complete {
            width: 100%;
            transition: none;
        }
    </style>
    <div class="modal-content text-white">
        <div class="modal-body p-0">
            <!-- Swiper Container -->
            <div class="swiper-container" wire:ignore>
                <!-- Story Progress Bar -->
                <div class="story-progress-container" id="storyProgressContainer" style="margin-top: 10px; padding-bottom:5px; background-color: rgba(15, 14, 14, 0.855);">
                    @foreach ($highlights as $index => $highlight)
                        <div class="story-progress-bar">
                            <div class="progress" id="progress-{{ $index }}"></div>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-wrapper">
                    @foreach ($highlights as $highlight)
                        <div class="swiper-slide" data-id="{{ $highlight->id }}">
                            <div class="slide-background" style="background-image: url('{{ asset("storage/" . $highlight->image) }}');">

                                <div class="d-flex px-2 py-2" style="background-color: #0c0b0bcf;">
                                    <div class="d-flex me-auto">
                                        <a href="/"><i class="fa-solid fa-chevron-left fs-6 rounded-pill text-white" style="background-color: #2423237c; padding-top:13px; padding-bottom: 13px; padding-right: 17px; padding-left: 17px; margin-top: 3px; margin-bottom: 3px;"></i></a>
                                    </div>
                                    <div class="position-relative w-100 d-flex align-items-center ms-3">
                                        <img style="width: 40px; height: 40px;" class="rounded-pill" src="{{ asset("storage/" . $user->avatar) }}">
                                        <div class="d-block ms-2">
                                            <p class="fs-10 mb-0">{{ $user->name }}</p>
                                            <p class="fs-8 mb-0">{{ $highlight->created_at->format("d m Y") }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4" style="width: 100%;padding-top: 5px; height: 70px; background-color: rgba(15, 14, 14, 0.855); margin-top: 525px;">
                                    <div class="d-flex justify-content-center">
                                        <p class="text-white" style="padding-top: 9px; ">{{ $highlight->title }}</p>
                                        <!-- Alpine.js Integration -->
                                        <div class="ms-auto" x-data="{
                                            liked: {{ $highlight->liked ? "true" : "false" }},
                                            highlightId: {{ $highlight->id }},
                                            isLoading: false,
                                            toggleLike() {
                                                this.isLoading = true;
                                                // Call Livewire method
                                                @this.toggleLike(this.highlightId).then(() => {
                                                    this.liked = !this.liked;
                                                    this.isLoading = false;
                                                });
                                            }
                                        }" style="margin-top: 0px;" wire:key="liked-{{ $highlight->liked?->id . "-yes" ?? $highlight->id . "-not" }}">
                                            <!-- Ikon Heart Normal -->
                                            <template x-if="!isLoading">
                                                <i :class="liked ? 'bi bi-heart-fill text-danger' : 'bi bi-heart text-white'" class="bi fs-3 mt-2" @click="toggleLike()" style="cursor: pointer;"></i>
                                            </template>

                                            <!-- Ikon Loading -->
                                            <template x-if="isLoading">
                                                <i class="bi bi-hourglass-split fs-3"></i>
                                            </template>

                                            <p class="fs-7 text-center" style="margin-top: -5px;">{{ $highlight->likes_count }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                const highlights = document.querySelectorAll(".swiper-slide").length;
                let progressBars = [];
                let currentIndex = 0;
                let autoplayDuration = 5000; // 5 seconds per slide

                // Initialize progress bars
                for (let i = 0; i < highlights; i++) {
                    progressBars.push(document.getElementById(`progress-${i}`));
                }

                // Function to reset all progress bars
                function resetProgressBars() {
                    progressBars.forEach((bar, index) => {
                        if (index < currentIndex) {
                            bar.classList.add('progress-complete');
                            bar.classList.remove('progress-active');
                        } else if (index === currentIndex) {
                            bar.classList.remove('progress-complete');
                            bar.style.width = '0';
                            setTimeout(() => {
                                bar.classList.add('progress-active');
                            }, 50);
                        } else {
                            bar.classList.remove('progress-complete');
                            bar.classList.remove('progress-active');
                            bar.style.width = '0';
                        }
                    });
                }



                var swiper = new Swiper(".swiper-container", {
                    loop: true,
                    slidesPerView: 1,
                    autoplay: {
                        delay: autoplayDuration,
                        disableOnInteraction: false,
                    },
                    observer: true, // Memastikan swiper tetap bisa mendeteksi perubahan
                    observeParents: true,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    on: {
                        slideChangeTransitionEnd: function() {
                            currentIndex = swiper.realIndex;
                            resetProgressBars();
                            swiper.autoplay.start(); // Pastikan autoplay tetap berjalan

                            // Emit ke Livewire jika ada
                            if (typeof Livewire !== "undefined" && Livewire.emit) {
                                Livewire.emit("updateSelectedIndex", currentIndex);
                            }
                        },
                        init: function() {
                            currentIndex = 0;
                            resetProgressBars();
                        }
                    }
                });

                // Restart autoplay setelah setiap swipe manual
                swiper.on('touchEnd', function() {
                    swiper.autoplay.start();
                });

                // Klik pada progress bar untuk pindah slide
                progressBars.forEach((bar, index) => {
                    bar.parentElement.addEventListener('click', () => {
                        swiper.slideTo(index);
                    });
                });

                // Pastikan modal terbuka dengan Swiper yang sinkron
                window.addEventListener("open-modal", (event) => {
                    var modal = new bootstrap.Modal(document.getElementById("highlightModal"));
                    modal.show();

                    setTimeout(() => {
                        if (swiper) {
                            swiper.update();

                            let selectedIndex = 0;
                            let slides = document.querySelectorAll(".swiper-slide");
                            slides.forEach((slide, index) => {
                                if (slide.getAttribute("data-id") == event.detail.highlightId) {
                                    selectedIndex = index;
                                }
                            });

                            swiper.slideTo(selectedIndex, 0);
                            currentIndex = swiper.realIndex;
                            resetProgressBars();
                        }
                    }, 300);
                });

                // Update swiper jika ada perubahan dari Livewire
                window.addEventListener("update-swiper", (event) => {
                    if (swiper) {
                        swiper.slideTo(event.detail.selectedIndex, 300);
                        currentIndex = swiper.realIndex;
                        resetProgressBars();
                    }
                });

                // Sinkronisasi Swiper saat modal ditampilkan
                document.getElementById("highlightModal").addEventListener("shown.bs.modal", function() {
                    if (swiper) {
                        swiper.update();
                        currentIndex = swiper.realIndex;
                        resetProgressBars();
                    }
                });

                // Pause autoplay saat disentuh agar tidak terganggu
                document.querySelector('.swiper-container').addEventListener('touchstart', function() {
                    swiper.autoplay.stop();
                    progressBars[currentIndex].style.transition = 'none';
                });

                document.querySelector('.swiper-container').addEventListener('touchend', function() {
                    swiper.autoplay.start();
                    progressBars[currentIndex].style.transition = 'width 5s linear';
                });

            }, 300);
        });
    </script>

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
</div>
