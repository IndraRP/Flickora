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
                    @foreach ($highlights as $index => $highlight)
                        <div class="swiper-slide" data-id="{{ $highlight->id }}" data-index="{{ $index }}">
                            <div class="slide-background" style="background-image: url('{{ asset("storage/" . $highlight->image) }}');">

                                <div class="d-flex px-2 py-2" style="background-color: #0c0b0bcf;">
                                    <div class="d-flex me-auto">
                                        <a href="/"><i class="fa-solid fa-chevron-left fs-6 rounded-pill text-white" style="background-color: #2423237c; padding-top:13px; padding-bottom: 13px; padding-right: 17px; padding-left: 17px; margin-top: 3px; margin-bottom: 3px;"></i></a>
                                    </div>
                                    <div class="position-relative w-100 d-flex align-items-center ms-3">
                                        <img style="width: 40px; height: 40px;" class="rounded-pill" src="{{ asset("storage/" . $user->avatar) }}">
                                        <div class="d-block ms-2">
                                            <p class="fs-10 mb-0">{{ $user->name }}</p>
                                            <p class="fs-8 mb-0">{{ $highlight->created_at->format("d M Y") }}</p>
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
                // Ambil ID highlight langsung dari URL path
                const currentUrl = window.location.pathname;
                const urlParts = currentUrl.split('/');
                const targetHighlightId = parseInt(urlParts[urlParts.length - 1]);

                const highlights = document.querySelectorAll(".swiper-slide").length;
                let progressBars = [];
                let currentIndex = 0;
                let autoplayDuration = 5000;
                let autoplayTimer = null;
                let swiperInitialized = false;

                // Cari indeks slide berdasarkan ID highlight dari URL
                const slides = document.querySelectorAll(".swiper-slide");
                slides.forEach((slide, index) => {
                    if (parseInt(slide.getAttribute("data-id")) === targetHighlightId) {
                        currentIndex = index;
                    }
                });

                // Initialize progress bars
                for (let i = 0; i < highlights; i++) {
                    progressBars.push(document.getElementById(`progress-${i}`));
                }

                // Function to start progress for current slide
                function startProgress(index) {
                    // Reset timer if exists
                    if (autoplayTimer) {
                        clearTimeout(autoplayTimer);
                    }

                    // Reset all progress bars
                    progressBars.forEach((bar, i) => {
                        if (i < index) {
                            // Set previous slides to completed
                            bar.style.width = '100%';
                            bar.classList.add('progress-complete');
                            bar.classList.remove('progress-active');
                        } else if (i === index) {
                            // Start current slide animation
                            bar.style.width = '0';
                            bar.classList.remove('progress-complete');

                            // Force reflow before adding the active class
                            void bar.offsetWidth;

                            // Start animation
                            bar.classList.add('progress-active');
                        } else {
                            // Reset future slides
                            bar.style.width = '0';
                            bar.classList.remove('progress-active');
                            bar.classList.remove('progress-complete');
                        }
                    });

                    // Set timer for next slide
                    autoplayTimer = setTimeout(() => {
                        if (currentIndex < highlights - 1) {
                            currentIndex++;
                        } else {
                            currentIndex = 0;
                        }

                        // Move swiper to next slide
                        if (swiper && swiperInitialized) {
                            swiper.slideTo(currentIndex);
                        }
                    }, autoplayDuration);
                }

                // Initialize Swiper
                var swiper = new Swiper(".swiper-container", {
                    loop: false,
                    slidesPerView: 1,
                    observer: true,
                    observeParents: true,
                    initialSlide: currentIndex,
                    speed: 300,
                    allowTouchMove: true,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    on: {
                        init: function() {
                            // Setelah swiper selesai inisialisasi
                            swiperInitialized = true;
                            // Pastikan sudah di slide yang tepat
                            this.slideTo(currentIndex, 0, false);
                        },
                        afterInit: function() {
                            // Delay sedikit untuk memastikan slide benar-benar aktif
                            setTimeout(() => {
                                startProgress(currentIndex);
                            }, 300);
                        },
                        slideChangeTransitionEnd: function() {
                            // Update current index setelah transisi slide selesai
                            currentIndex = this.activeIndex;
                            // Restart progress animation
                            startProgress(currentIndex);
                        }
                    }
                });

                // Backup untuk memastikan progress bar mulai berjalan
                // Kadang event afterInit tidak terpicu dengan benar
                setTimeout(() => {
                    if (!autoplayTimer) {
                        startProgress(currentIndex);
                    }
                }, 500);

                // Handle touch events
                const swiperContainer = document.querySelector('.swiper-container');
                if (swiperContainer) {
                    swiperContainer.addEventListener('touchstart', function() {
                        // Pause autoplay & animation when touched
                        if (autoplayTimer) {
                            clearTimeout(autoplayTimer);
                        }
                        if (progressBars[currentIndex]) {
                            progressBars[currentIndex].style.transition = 'none';
                        }
                    });

                    swiperContainer.addEventListener('touchend', function() {
                        // Resume progress
                        if (progressBars[currentIndex]) {
                            progressBars[currentIndex].style.transition = 'width 5s linear';
                            startProgress(currentIndex);
                        }
                    });
                }

                // Click on progress bar to navigate
                progressBars.forEach((bar, index) => {
                    bar.parentElement.addEventListener('click', () => {
                        swiper.slideTo(index);
                        currentIndex = index;
                        startProgress(currentIndex);
                    });
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
