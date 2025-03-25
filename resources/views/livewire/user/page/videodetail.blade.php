@section("styles")
    <style>
        .video-container {
            position: relative;
            width: 100%;
            height: 350px;
            overflow: hidden;
        }

        .video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        .text-wrapper {
            overflow: hidden;
            transition: max-height 0.4s ease-in-out;
            position: relative;
        }
    </style>
    <style>
        ::placeholder {
            color: white !important;
            opacity: 1;
            /* Firefox requires this to show the desired color */
        }

        /* For older browsers */
        ::-webkit-input-placeholder {
            /* Chrome/Opera/Safari */
            color: white !important;
        }

        ::-moz-placeholder {
            /* Firefox 19+ */
            color: white !important;
        }

        :-ms-input-placeholder {
            /* IE 10+ */
            color: white !important;
        }

        :-moz-placeholder {
            /* Firefox 18- */
            color: white !important;
        }

        .modal.modal-bottom .modal-dialog {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            margin: 0;
            width: 100%;
            max-width: 100%;
            transition: transform 0.3s ease-out;
            transform: translateY(100%);
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
        }
    </style>
    <style>
        .messenger-search[type="text"] {
            margin: 0px 0px;
            width: 100%;
            border: none;
            padding: 8px 10px;
            border-radius: 6px;
            outline: none;
        }
    </style>
@endsection

<div>
    <div style="padding-bottom: 40px; background-color: #1C1C1C">

        <div class="d-flex fixed-top px-2 py-2" style="background-color: #0c0b0b;">
            <div class="d-flex me-auto">
                <a href="javascript:void(0)" onclick="handleBack()"><i class="fa-solid fa-chevron-left fs-6 rounded-pill text-white" style="background-color: #2423237c; padding-top:13px; padding-bottom: 13px; padding-right: 17px; padding-left: 17px; margin-top: 3px; margin-bottom: 3px;"></i></a>
            </div>
            <div class="position-relative w-100 d-flex">
                <p class="mb-0 rounded px-3 text-center text-white" style="background-color: #24232300; padding-top: 5px; font-size: 17px; font-weight: 500; height: 35px; margin-top: 5px; margin-left: -5px;">Video</p>
            </div>
        </div>

        <div style="padding-top: 65px; background-color: #1C1C1C">
            @foreach ($videos->reverse() as $video)
                <div id="video-{{ $video->id }}" class="position-relative px-3 pb-1 pt-3">
                    <div style="cursor: pointer;" wire:click="setVideoId({{ $video->id }})">
                        {{-- Video as background similar to image posts --}}
                        <div class="rounded" style="background-size: cover; width: 100%; max-height: 350px; 
                               {{ $this->isPostReported($video->id) ? "filter: blur(10px); background-color: rgba(0, 0, 0, 0.5);" : "" }}">

                            {{-- Video container with proper styling --}}
                            <div class="position-relative video-container">
                                <video loop muted playsinline class="video-bg">
                                    <source src="{{ asset("storage/" . $video->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>

                                <div onclick="showVideoModal('{{ $video->id }}', '{{ asset("storage/" . $video->video) }}')" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
                                    background: rgba(0, 0, 0, 0.5); border-radius: 50%; width: 50px; height: 50px; 
                                    display: flex; align-items: center; justify-content: center; z-index: 2;">
                                    <i class="fa fa-play fs-3 text-white"></i>
                                </div>

                                <!-- Tombol Suka, Bagikan, dan Informasi User -->
                                <div class="position-absolute d-flex bottom-0 end-0 me-2" style="z-index: 3; margin-bottom: 0px;">
                                    <div class="d-block ms-auto" style="margin-right: -10px;">
                                        <div class="dropdown" style="z-index: 3">
                                            <i class="bi bi-three-dots-vertical fs-6 rounded-pill me-3 ms-2 mt-2 p-2 text-white" style="background-color:#1c1c1ce1; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">
                                            </i>
                                            {{-- {{ $post->id }} --}}

                                            <ul class="dropdown-menu bg-dark" wire:ignore.self>
                                                <a class="dropdown-item bg-dark fs-10 text-white" data-bs-toggle="modal" data-bs-target="#laporModal" wire:click.prevent="setVideoId({{ $video->id }})">
                                                    Laporkan
                                                </a>

                                                <li> <a class="dropdown-item bg-dark fs-10 text-white" wire:click="download({{ $video->id }})" style="cursor: pointer;">
                                                        Download Gambar
                                                    </a></li>
                                            </ul>
                                        </div>

                                        <div class="py-4" style="margin-top: 103px; padding-left: 8px; padding-right: 0px; width: 60px; background: linear-gradient(211deg, rgb(28, 28, 28), rgba(58, 58, 58, 0.592), rgba(58, 58, 58, 0)); margin-right: 2px;">
                                            <div style="margin-left: 13px">
                                                @php
                                                    $isLiked = $video->likes_video->where("user_id", auth()->id())->count() > 0;
                                                @endphp
                                                <i class="bi {{ $isLiked ? "bi-heart-fill text-danger" : "bi-heart text-white" }} fs-6 me-2" wire:click="toggleLike({{ $video->id }})" style="cursor: pointer;"></i>

                                                <p class="fs-8 mb-1 text-white" style="margin-left: -2px">Suka</p>
                                            </div>
                                            <div class="d-block my-2 ms-auto pt-1 text-center" data-bs-toggle="modal" data-bs-target="#comentModal" wire:click="setPostId2({{ $video->id }})">
                                                <i class="bi bi-chat-left-text-fill text-white" style="font-size: 15px; margin-left:-10px;"></i>
                                                <p class="fs-8 mb-2 text-white" style="margin-top:-1px; margin-left:-7px;">Komentar</p>
                                            </div>
                                            <div style="margin-left: 5px;">
                                                <i class="fa-solid fa-share fs-6 me-3 ms-2 mt-2 text-white" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#shareModal"></i>
                                                <p class="fs-8 mb-0 text-white">Bagikan</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi User -->
                                <div class="position-absolute d-flex align-items-center bottom-0 end-0 start-0 mb-0 px-3 pt-2" style="margin-right: 60px; background: linear-gradient(135deg, rgb(28, 28, 28), rgba(58, 58, 58, 0.592), rgba(58, 58, 58, 0)); height: 55px; z-index: 2;">
                                    <div class="d-flex" style="margin-bottom: 10px; margin-top: 6px;">
                                        <img src="{{ asset("storage/" . $video->user->avatar) }}" class="rounded-pill" style="width: 35px; height: 35px; object-fit: cover;">
                                        <p class="fs-10 mb-2 ms-2 text-white" style="margin-top: 9px;">{{ $video->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Content text section similar to image posts --}}
                        <div x-data="{ expanded: false, fullText: `{{ $video->caption ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, tempora odio molestias suscipit architecto, quibusdam nulla, beatae nemo in consequatur libero vitae magnam molestiae. Ad iste iusto nam aut ipsum!" }}`, maxLength: 80 }" class="content-box position-relative pt-1" style="{{ $this->isPostReported($video->id) ? "filter: blur(10px); background-color: rgba(0, 0, 0, 0.5);" : "" }} background: rgba(255, 255, 255, 0); border-radius: 8px; max-width: 600px; margin: auto; color: #ffffff;">
                            <div class="text-wrapper">
                                <p class="text mb-0" style="font-size: 14px; line-height: 1.6; overflow: hidden;">
                                    <span x-text="expanded ? fullText : fullText.substring(0, maxLength) + '...'"></span>
                                </p>
                            </div>
                            <button x-show="fullText.length > maxLength" @click="expanded = !expanded" class="btn-toggle" style="position: absolute; right: 0; bottom: 0; background: none; border: none; color: #007bff; font-size: 14px; cursor: pointer; white-space: nowrap;">
                                <span x-text="expanded ? 'Lebih Sedikit' : 'Baca Selengkapnya'"></span>
                            </button>
                        </div>

                        {{-- Reported content messaging (if applicable) --}}
                        @if ($this->isPostReported($video->id) && auth()->id() === $video->user_id)
                            @if ($this->isPostInBanding($video->id))
                                {{-- Jika sudah mengajukan banding --}}
                                <div class="position-absolute top-50 start-50 translate-middle rounded p-3 text-center text-white shadow-lg" style="background: rgba(0, 0, 0, 0.85); width: 90%; z-index: 1000; pointer-events: auto; backdrop-filter: none; filter: none;">
                                    <p class="fs-10 mb-2 text-center">⚠️ Sabar broo, banding sedang dipertimbangkan...</p>
                                </div>
                            @else
                                {{-- Jika belum mengajukan banding --}}
                                <div class="position-absolute top-50 start-50 translate-middle rounded p-3 text-center text-white shadow-lg" style="background: rgba(0, 0, 0, 0.85); width: 90%; z-index: 1000; pointer-events: auto; backdrop-filter: none; filter: none;">
                                    <p class="fs-10 mb-2 text-center">⚠️ Postingan Anda telah di-report dan sedang dalam peninjauan.</p>
                                    <button wire:click="setReportId({{ $video->id }})" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bandingModal">
                                        Ajukan Banding
                                    </button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal Coment-->
        <div wire:poll.{{ $refreshInterval }}ms>
            <div class="modal fade modal-bottom" id="comentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content text-white" style="height: 450px; background-color:#1C1C1C">
                        <div class="modal-body py-2">
                            <div class="d-flex justify-content-center">
                                <hr class="my-1" style="border: 1px solid white; width: 50px;">
                            </div>
                            <p class="fs-6 mb-2 text-center">Komentar</p>
                            <hr class="my-1" style="border-color: white;">
                            <div class="mt-3" style="height: 315px; overflow-y: auto;" id="komentar-container">
                                @if (count($komentar_list) > 0)
                                    @foreach ($komentar_list->where("parent_id", null) as $komentar)
                                        <div class="d-flex align-items-start mt-3">
                                            <div class="rounded-pill overflow-hidden" style="width: 45px; height: 45px;">
                                                <img src="{{ $komentar->user->profile_photo ?? "https://i.pinimg.com/474x/d4/87/74/d48774278b794703e974bedaa1162ac3.jpg" }}" class="w-100 h-100 object-fit-cover">
                                            </div>
                                            <div class="ms-2">
                                                <div class="d-flex align-items-center">
                                                    <p class="fs-7 mb-0">{{ $komentar->user->username ?? "pengguna" }}</p>
                                                    <p class="text-secondary mb-1 ms-2" style="font-size: 10px;">{{ $this->waktuSingkat($komentar->created_at) }}</p>
                                                </div>
                                                <p class="mb-0 mt-1" style="font-size: 13px;">{{ $komentar->content }}</p>

                                                <div class="w-100 d-block">
                                                    {{-- Bungkus tombol dalam div sendiri --}}
                                                    <div class="w-100 mt-1">
                                                        <button class="btn btn-sm btn-link text-secondary text-decoration-none fs-7 d-block pb-0 ps-0" wire:click="setReply({{ $komentar->id }})" onclick="setTimeout(() => document.getElementById('input-komentar').focus(), 100)">
                                                            Balas
                                                        </button>

                                                        @if ($komentar->replies->count() > 0)
                                                            <button class="btn btn-sm btn-link text-primary text-decoration-none fs-7 d-block ms-1 ps-4 pt-1" wire:click="toggleReplies({{ $komentar->id }})">
                                                                {{ isset($show_replies[$komentar->id]) ? "Sembunyikan Balasan" : "Lihat Balasan (" . $komentar->replies->count() . ")" }}
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Tampilkan Balasan Jika Dibuka --}}
                                                @if (isset($show_replies[$komentar->id]))
                                                    <div class="ms-4 pb-3">
                                                        @foreach ($komentar->replies as $reply)
                                                            <div class="d-flex align-items-start mt-2">
                                                                <div class="rounded-pill overflow-hidden" style="width: 35px; height: 35px;">
                                                                    <img src="{{ $reply->user->profile_photo ?? "https://i.pinimg.com/474x/d4/87/74/d48774278b794703e974bedaa1162ac3.jpg" }}" class="w-100 h-100 object-fit-cover">
                                                                </div>
                                                                <div class="ms-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <p class="fs-7 mb-0">{{ $reply->user->username ?? "pengguna" }}</p>
                                                                        <p class="text-secondary mb-1 ms-2" style="font-size: 10px;">{{ $this->waktuSingkat($reply->created_at) }}</p>
                                                                    </div>
                                                                    <p class="mb-0 mt-1" style="font-size: 13px;">{{ $reply->content }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center" style="margin-top: 115px;">
                                        <p class="text-secondary">Belum ada komentar</p>
                                    </div>
                                @endif
                            </div>

                            <div class="d-block pt-2">
                                @if ($parent_id)
                                    <div style="margin-top: -25px;" class="d-flex align-items-center mb-2">
                                        <p class="text-secondary fs-7 mb-0">Membalas komentar...</p>
                                        <p class="fs-7 text-danger mb-0 ms-auto" wire:click="batal()" style="font-weight: 600;">batalkan membalas</p>
                                    </div>
                                @endif


                                <div class="d-flex align align-items-center">
                                    @if (session()->has("pesan_error"))
                                        <div class="alert alert-danger w-100 p-1">
                                            {{ session("pesan_error") }}
                                        </div>
                                    @endif
                                    <input type="text" class="form-control me-2 bg-transparent text-white" id="input-komentar" wire:model.defer="teks_komentar" placeholder="Tulis komentar..." style="flex: 1;" wire:keydown.enter="tambahKomentar" />
                                    <button class="btn border-0" wire:click="tambahKomentar()" style="background: linear-gradient(to right, #1547CE, #3d6eaf, #4c89d4);">
                                        <i class="fa-solid fa-paper-plane fs-5 text-white" style="margin:3px;"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Modal -->
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-body">
                        <p class="fs-6 mb-2">Detail Video</p>
                        <video id="modalVideo" controls autoplay playsinline width="100%">
                            <source id="videoSource" src="" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Report/Lapor -->
        <div class="modal fade" id="laporModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-dark">
                    <div class="modal-body py-5">
                        <div class="d-flex justify-content-center">
                            <div id="lottie-container" class="d-flex justify-content-center align-items-center pt-3" style="margin-top: -15px; width: 200px; height: 200px; transform: translateY(-10px);" wire:ignore.self>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2 text-center">
                            <p class="fs-6 text-white">Apakah anda yakin ingin melaporkan postingan ini?</p>
                        </div>

                        <!-- Form untuk melaporkan -->
                        <form wire:submit.prevent="report">
                            <input type="hidden" wire:model="postId">
                            <div class="mb-3">
                                <label for="additional-info" class="form-label fs-10 text-white">Alasan</label>
                                <textarea id="additional-info" class="form-control bg-dark border-primary text-white" rows="3" wire:model="alasan" required></textarea>
                                @error("alasan")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-danger text-white" style="width: 100px; height: 40px;">
                                    Ya, Yakin
                                </button>
                                <button type="button" class="btn border-primary ms-3 border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">
                                    Tidak
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal banding-->
        <div class="modal fade" id="bandingModal" tabindex="-1" aria-labelledby="bandingModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bandingModalLabel">Ajukan Banding</h5>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="submitBanding">
                            <input type="hidden" wire:model="reports_video_id">

                            <p class="fs-10">Menurut Anda, mengapa postingan Anda direport?</p>
                            <div class="radio-container" style="margin-top: -10px;">
                                <input type="radio" id="spam" name="report_reason" value="Spam" wire:model="report_reason">
                                <label for="spam">Spam</label>
                            </div>

                            <div class="radio-container">
                                <input type="radio" id="konten" name="report_reason" value="Konten tidak pantas" wire:model="report_reason">
                                <label for="konten">Konten tidak pantas</label>
                            </div>

                            <div class="radio-container">
                                <input type="radio" id="hakcipta" name="report_reason" value="Pelanggaran hak cipta" wire:model="report_reason">
                                <label for="hakcipta">Pelanggaran hak cipta</label>
                            </div>

                            <div class="radio-container">
                                <input type="radio" id="informasi" name="report_reason" value="Informasi salah" wire:model="report_reason">
                                <label for="informasi">Informasi salah</label>
                            </div>

                            <div class="radio-container">
                                <input type="radio" id="lainnya" name="report_reason" value="Lainnya" wire:model="report_reason">
                                <label for="lainnya">Tidak ada</label>
                            </div>

                            <div class="my-3">
                                <label for="alasan" class="form-label">Alasan Banding</label>
                                <textarea class="form-control bg-dark text-white" id="alasan" wire:model="alasan" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="bukti" class="form-label bg-dark text-white">Bukti (Opsional)</label>
                                <input type="file" class="form-control bg-dark fs-10 text-white" wire:model="bukti">

                                <!-- Indikator loading -->
                                <div wire:loading wire:target="bukti" class="text-warning fs-8 mt-2">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Mengunggah file...
                                </div>

                                <!-- Notifikasi sukses setelah upload selesai -->
                                <div wire:loading.remove wire:target="bukti">
                                    @if ($bukti)
                                        <p class="text-success fs-8 mt-2">
                                            <i class="bi bi-check-circle"></i> File berhasil diunggah!
                                        </p>
                                    @endif
                                </div>
                            </div>


                            <div class="d-flex justify-content-center mb-2">
                                <button type="submit" class="btn border-danger fs-10 me-2 border text-white" style="width: 130px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Batalkan</button>
                                <button type="submit" class="btn btn-primary fs-10" style="width: 130px; fs-10">Kirim Banding</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-bottom" role="document">
                <div class="modal-content bg-dark" style="height:420px;">
                    <div class="modal-body py-2">
    
                        <p class="fs-5 pt-2 text-white" style="font-weight: 300">Bagikan</p>
    
                        <div class="position-relative w-100">
                            <input type="text" class="messenger-search bg-dark border-primary border text-white" placeholder="Ketik Di sini" wire:model="search" wire:keydown.enter="searchUsers" /> <!-- Menambahkan event Enter -->
                            <i class="bi bi-search position-absolute top-50 translate-middle-y end-0 me-4 text-white"></i>
                        </div>
    
                        <div class="container" style="margin-top: 20px;">
                            @if ($friends->isNotEmpty())
                                <div class="scrollable-friends" style="max-height: 180px; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none;">
                                    <style>
                                        .scrollable-friends::-webkit-scrollbar {
                                            display: none;
                                        }
                                    </style>
                                    <div class="row row-cols-4 justify-content-center mb-2">
                                        @foreach ($friends as $friend)
                                            <div class="col mb-3 text-center">
                                                <img src="{{ asset("storage/" . $friend->avatar) }}" class="d-block rounded-pill mx-auto" style="height: 55px; width: 55px; object-fit: cover;">
                                                <p class="fs-7 mb-0 mt-1 text-center text-white">
                                                    {{ Str::limit($friend->username, 7, "...") }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-center text-white">Tidak ada teman yang ditemukan.</p>
                            @endif
                        </div>
    
                    </div>
    
                    <div class="d-flex justify-content-evenly border-0" style="margin-bottom: 100px;">
                        <div class="d-block text-center" style="width: 60px;" onclick="shareToWhatsApp()">
                            <div class="rounded-pill border border-white p-2" style="width: 56px;">
                                <i class="bi bi-whatsapp fs-2 text-white"></i>
                            </div>
                            <p class="fs-8 mb-0 me-2 mt-1 text-white">WhatsApp</p>
                        </div>
    
                        <div class="d-block text-center" style="width: 60px;" onclick="copyToClipboard('{{ url()->current() }}')" wire:click="salin">
                            <div class="rounded-pill border border-white p-2" style="width: 56px;">
                                <i class="bi bi-copy fs-2 text-white"></i>
                            </div>
                            <p class="fs-8 mb-0 mt-1 text-white">Salin Link</p>
                        </div>
    
                        <div>
                            <div class="d-block text-center" style="width: 60px;" wire:key="download-{{ $post->id }}" onclick="downloadImage({{ $post->id }})">
                                <div class="rounded-pill border border-white p-2" style="width: 56px; cursor: pointer;">
                                    <i class="bi bi-download fs-2 text-white"></i>
                                </div>
                                <p class="fs-8 mb-0 mt-1 text-white">Unduh</p>
                            </div>
                        </div>
    
                    </div>
    
    
                    {{-- <div class="modal-footer d-flex justify-content-evenly border-0 pt-0" style="padding-bottom: -30px; margin-top: -100px;">
                    </div> 
                </div>
            </div>
        </div> --}}

    </div>
</div>


@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const videoId = "{{ request()->route("videoId") }}";
                if (videoId) {
                    const target = document.getElementById('post-' + videoId);
                    if (target) {
                        // Dapatkan posisi elemen secara absolut (offsetTop)
                        const targetPosition = target.offsetTop;

                        // Offset agar elemen tidak terlalu ke tengah atau ke bawah
                        const offset = 150; // Sesuaikan angka ini jika perlu

                        // Smooth scroll ke posisi target dengan offset
                        window.requestAnimationFrame(() => {
                            window.scrollTo({
                                top: targetPosition - offset,
                                behavior: 'smooth'
                            });
                        });

                        console.log("Scrolling to:", targetPosition - offset);
                    }
                }
            }, 300); // Delay 300ms untuk memastikan elemen sudah ada sebelum scroll
        });
    </script>

    <script>
        function showVideoModal(videoId, videoUrl) {
            // Set source video berdasarkan ID yang diklik
            document.getElementById("videoSource").src = videoUrl;
            document.getElementById("modalVideo").load();

            // Tampilkan modal
            var videoModal = new bootstrap.Modal(document.getElementById("videoModal"));
            videoModal.show();
        }
    </script>

    <script>
        function copyToClipboard(url) {
            const tempInput = document.createElement('input');
            document.body.appendChild(tempInput);
            tempInput.value = url;
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }
    </script>

    <script>
        console.log(typeof bootstrap);
    </script>

    <script>
        function handleBack() {
            if (document.referrer) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let header = document.querySelector(".fixed-top");

            window.addEventListener("scroll", function() {
                if (window.scrollY > 50) {
                    header.style.backgroundColor = "#0c0b0b"; // Warna abu-abu transparan
                } else {
                    header.style.backgroundColor = "#0c0b0b"; // Kembali transparan
                }
            });
        });
    </script>

    <script>
        function downloadImage(videoId) {
            if (!postId) {
                console.error('ID Post tidak ditemukan');
                alert('Error: ID Post tidak ditemukan');
                return;
            }

            // Emit event ke Livewire
            Livewire.emit('getImageUrl', postId);
        }

        document.addEventListener('livewire:initialized', () => {

            // Tangani event dari Livewire untuk mendapatkan URL gambar
            Livewire.on('imageUrlGenerated', (data) => {
                if (data.success && data.imageUrl) {
                    const downloadLink = document.createElement('a');
                    downloadLink.href = data.imageUrl;
                    downloadLink.download = data.filename || `gambar_post.jpg`;

                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                } else {
                    alert('Gambar tidak ditemukan atau tidak dapat diunduh');
                }
            });

        });
    </script>

    <script>
        function shareToWhatsApp() {
            // The URL you want to share
            const shareUrl = window.location.href; // Gets current page URL

            // You can also set a custom message
            const shareMessage = "Check this out!";

            // Encode the URL and message for WhatsApp
            const encodedMessage = encodeURIComponent(shareMessage);
            const encodedUrl = encodeURIComponent(shareUrl);

            // Create the WhatsApp share link
            const whatsappLink = `https://api.whatsapp.com/send?text=${encodedMessage}%20${encodedUrl}`;

            // Open WhatsApp in a new window/tab
            window.open(whatsappLink, '_blank');
        }
    </script>
@endpush
