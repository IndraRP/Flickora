<div style="padding-bottom: 40px; background-color: #1C1C1C">

    <div class="d-flex fixed-top px-2 py-2" style="background-color: #0c0b0b;">
        <div class="d-flex me-auto">
            <a href="javascript:void(0)" onclick="handleBack()"><i class="fa-solid fa-chevron-left fs-6 rounded-pill text-white" style="background-color: #2423237c; padding-top:13px; padding-bottom: 13px; padding-right: 17px; padding-left: 17px; margin-top: 3px; margin-bottom: 3px;"></i></a>
        </div>
        <div class="position-relative w-100 d-flex">
            <p class="mb-0 rounded px-3 text-center text-white" style="background-color: #24232300; padding-top: 5px; font-size: 17px; font-weight: 500; height: 35px; margin-top: 5px; margin-left: -5px;">Postingan</p>
        </div>
    </div>

    <div style="padding-top: 65px; background-color: #1C1C1C">
        @foreach ($posts->reverse() as $post)
            @foreach ($post->userTags(auth()->id())->get() as $tag)
                <div id="post-{{ $post->id }}" class="position-relative px-3 pt-3">

                    <div style="">
                        <div class="rounded" style='background: linear-gradient(to top, rgba(1, 4, 30, 0), rgba(44, 50, 58, 0), rgba(0, 0, 0, 0.029)), 
                           linear-gradient(to left, rgba(1, 4, 30, 0), rgba(41, 46, 52, 0), rgba(0, 0, 0, 0.022)), 
                           url("{{ asset("storage/" . $post->image) }}"); 
                           background-size: cover; width: 100%; height: 350px; 
                           {{ $this->isPostReported($post->id) ? "filter: blur(10px); background-color: rgba(0, 0, 0, 0.5);" : "" }}'>


                            <!-- Tombol Suka dan Bagikan -->
                            <div class="d-flex">
                                <div class="d-block ms-auto" style="margin-right: -10px; margin-top: 18px;">
                                    <div class="dropdown">
                                        <i class="bi bi-three-dots-vertical fs-6 rounded-pill me-3 ms-2 mt-2 p-2 text-white" style="background-color:#1c1c1c4f; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">
                                        </i>
                                        {{-- {{ $post->id }} --}}

                                        <ul class="dropdown-menu bg-dark">

                                            <a class="dropdown-item bg-dark fs-10 text-white" wire:click="download({{ $post->id }})" style="cursor: pointer;">
                                                Download Gambar
                                            </a>

                                            {{-- <p class="text-white">userId: {{ $userId }} | auth: {{ auth()->id() }}</p> --}}

                                            @auth
                                                @if ($userId === auth()->id())
                                                    <a class="dropdown-item bg-dark fs-10 text-white" style="cursor: pointer;">
                                                        Edit
                                                    </a>

                                                    <a class="dropdown-item bg-dark fs-10 text-white" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#hapusModal" wire:click="setTagId({{ $tag->id }})">
                                                        Hapus
                                                    </a>
                                                @endif
                                            @endauth

                                            <a class="dropdown-item bg-dark fs-10 text-white" data-bs-toggle="modal" data-bs-target="#laporModal" wire:click="setPostId({{ $post->id }})">
                                                Laporkan
                                            </a>
                                        </ul>
                                    </div>


                                    <script>
                                        window.addEventListener('downloadFile', event => {
                                            const url = event.detail.url;
                                            const link = document.createElement('a');
                                            link.href = url;
                                            link.download = url.substring(url.lastIndexOf('/') + 1);
                                            document.body.appendChild(link);
                                            link.click();
                                            document.body.removeChild(link);
                                        });
                                    </script>

                                    <div class="ms-2" style="margin-top: 205px;">
                                        {{-- <i class="bi bi-heart-fill fs-5 me-3 text-white" style="cursor: pointer;"></i> --}}

                                        @php
                                            $isLiked = $post->likes->where("user_id", auth()->id())->count() > 0;
                                        @endphp

                                        <i class="bi {{ $isLiked ? "bi-heart-fill text-danger" : "bi-heart text-white" }} fs-6 me-3" wire:click="toggleLike({{ $post->id }})" style="cursor: pointer;"></i>
                                        <p class="fs-8 mb-1 text-white">Suka</p>
                                    </div>

                                    {{-- wire:click="share" onclick="copyToClipboard('{{ route("postdetail", ["userid" => $post->user->id, "postId" => $post->id]) }}')" --}}

                                    <div class="">
                                        <i class="fa-solid fa-share fs-6 me-3 ms-2 mt-2 text-white" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#shareModal">
                                        </i>
                                        <p class="fs-8 text-white">Bagikan</p>
                                    </div>

                                </div>
                            </div>

                            <!-- Informasi User -->
                            <div class="d-flex align-items-center px-3" style="margin-top: -53px;">
                                <div class="d-flex mb-3">
                                    <img src="{{ asset("storage/" . $user->avatar) }}" class="rounded-pill" style="width: 35px; height: 35px; object-fit: cover;">
                                    <p class="fs-10 mb-0 ms-2 text-white" style="margin-top: 9px;">{{ $user->name }}</p>
                                </div>
                                <div class="d-block ms-auto text-center" style="margin-right: 52px;" data-bs-toggle="modal" data-bs-target="#comentModal" wire:click="setPostId2({{ $post->id }})">
                                    <i class="bi bi-chat-left-text-fill text-white" style="font-size: 15px;"></i>
                                    <p class="fs-8 text-white" style="margin-top:-1px;">Komentar</p>
                                </div>
                            </div>
                        </div>

                        <!-- Konten Post -->
                        <div x-data="{ expanded: false }" class="content-box pt-1" style="{{ $this->isPostReported($post->id) ? "filter: blur(10px); background-color: rgba(0, 0, 0, 0.5);" : "" }} background: rgba(255, 255, 255, 0); border-radius: 8px; max-width: 600px; margin: auto; color: #ffffff;">

                            <p x-bind:class="expanded ? 'expanded' : 'collapsed'" class="text mb-0" style="transition: max-height 0.4s ease-in-out; font-size: 14px; line-height: 1.6;">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, tempora odio molestias suscipit architecto, quibusdam nulla, beatae nemo in consequatur libero vitae magnam molestiae. Ad iste iusto nam aut ipsum!
                            </p>
                            <div style="display: flex; justify-content: flex-end;">
                                <button @click="expanded = !expanded" class="btn-toggle" style="background: none; border: none; color: #007bff; font-size: 14px; cursor: pointer;">
                                    <span x-text="expanded ? 'Tampilkan Lebih Sedikit' : 'Baca Selengkapnya'"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    @if ($this->isPostReported($post->id) && auth()->id() === $post->user_id)
                        @if ($this->isPostInBanding($post->id))
                            {{-- Jika sudah mengajukan banding --}}
                            <div class="position-absolute top-50 start-50 translate-middle rounded p-3 text-center text-white shadow-lg" style="background: rgba(0, 0, 0, 0.85); width: 90%; z-index: 1000; pointer-events: auto; backdrop-filter: none; filter: none;">
                                <p class="fs-10 mb-2 text-center">⚠️ Sabar broo, banding sedang dipertimbangkan...</p>
                            </div>
                        @else
                            {{-- Jika belum mengajukan banding --}}
                            <div class="position-absolute top-50 start-50 translate-middle rounded p-3 text-center text-white shadow-lg" style="background: rgba(0, 0, 0, 0.85); width: 90%; z-index: 1000; pointer-events: auto; backdrop-filter: none; filter: none;">
                                <p class="fs-10 mb-2 text-center">⚠️ Postingan Anda telah di-report dan sedang dalam peninjauan.</p>
                                <button wire:click="setReportId({{ $post->id }})" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bandingModal">
                                    Ajukan Banding
                                </button>
                            </div>
                        @endif
                    @endif


                </div>
            @endforeach
        @endforeach
    </div>
    {{-- -{{ $postId }} --}}

    <!-- Modal Lapor-->
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
                            <textarea id="additional-info" class="form-control bg-dark border-primary text-white" rows="3" wire:model="additionalInfo"></textarea>
                            @error("additionalInfo")
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
                                @foreach ($komentar_list->sortByDesc("id") as $komentar)
                                    <div class="d-flex align-items-start" style="min-height: 80px;">
                                        <div class="rounded-pill overflow-hidden" style="width: 45px; height: 45px;">
                                            <img src="{{ $komentar->user->profile_photo ?? "https://i.pinimg.com/474x/d4/87/74/d48774278b794703e974bedaa1162ac3.jpg" }}" class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <div class="ms-2">
                                            <div class="d-flex align-items-center">
                                                <p class="fs-7 mb-0">{{ $komentar->user->username ?? "pengguna" }}</p>
                                                <p class="text-secondary mb-1 ms-2" style="font-size: 10px;">{{ \Carbon\Carbon::parse($komentar->created_at)->format("d/m/Y H:i") }}</p>
                                            </div>
                                            <p class="mb-0 mt-1" style="font-size: 13px;">{{ $komentar->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mt-5 text-center">
                                    <p class="text-secondary">Belum ada komentar</p>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center pt-2">
                            @if (session()->has("pesan_error"))
                                <div class="alert alert-danger w-100 p-1">
                                    {{ session("pesan_error") }}
                                </div>
                            @endif
                            <input type="text" class="form-control me-2 bg-transparent text-white" wire:model.defer="teks_komentar" placeholder="Tulis komentar..." style="flex: 1;" wire:keydown.enter="tambahKomentar" />
                            <button class="btn border-0" wire:click="tambahKomentar()" style="background: linear-gradient(to right, #1547CE, #3d6eaf, #4c89d4);">
                                <i class="fa-solid fa-paper-plane fs-5 text-white" style="margin:3px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Modal banding-->
    <div class="modal fade" id="bandingModal" tabindex="-1" aria-labelledby="bandingModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="bandingModalLabel">Ajukan Banding</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submitBanding">
                        <input type="hidden" wire:model="report_id">

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

    {{-- Modal Hapus --}}
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body py-5">
                    <div class="d-flex justify-content-center">
                        <div id="lottie-container" class="d-flex justify-content-center align-items-center pt-3" style="margin-top: -15px; width: 200px; height: 200px; transform: translateY(-10px);" wire:ignore.self>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-2 text-center">
                        <p class="fs-6 text-white">Apakah anda yakin ingin menghapus postingan ini?</p>
                    </div>


                    <div class="d-flex justify-content-center mt-3">
                        <button wire:click="hapusTag({{ $post->id }})" class="btn btn-danger text-white" style="width: 100px; height: 40px;">
                            Ya, Yakin
                        </button>


                        <button type="button" class="btn border-primary ms-3 border text-white" style="width: 100px; height: 40px;" data-bs-dismiss="modal" aria-label="Close">
                            Tidak
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

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

    <!-- Modal share-->
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-bottom" role="document">
            <div class="modal-content bg-dark" style="height:420px;">
                <div class="modal-body py-2">

                    <p class="fs-5 pt-2 text-white" style="font-weight: 300">Bagikan</p>

                    <div class="position-relative w-100">
                        <input type="text" class="messenger-search bg-dark border-primary border text-white" placeholder="Ketik Di sini" wire:model="search" wire:keydown.enter="searchUsers" /> <!-- Menambahkan event Enter -->
                        <i class="bi bi-search position-absolute top-50 translate-middle-y end-0 me-4 text-white"></i>
                    </div>

                    {{-- <div class="container" style="margin-top: 20px;">
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
                    </div> --}}

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
                </div> --}}
            </div>
        </div>
    </div>

    <script>
        function downloadImage(postId) {
            if (!postId) {
                console.error('ID Post tidak ditemukan');
                alert('Error: ID Post tidak ditemukan');
                return;
            }

            // Emit event ke Livewire
            Livewire.emit('getImageUrl', postId);
        }

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

    <!-- Modal komentar-->
    {{-- <div class="modal fade" id="comentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-bottom" role="document">
            <div class="modal-content bg-dark" style="height:400px;">
                <div class="modal-body py-2">

                    <p class="fs-5 fw-bolder pt-2 text-white">Bagikan</p>

                    <div class="container">
                        @if ($friends->isNotEmpty())
                            <div class="row row-cols-4 justify-content-center mb-2">
                                @foreach ($friends as $friend)
                                    <div class="col mb-3 text-center">
                                        <img src="{{ asset("storage/" . $friend->avatar) }}" class="d-block rounded-pill" style="height: 60px; width: 60px; object-fit: cover;">
                                        <p class="fs-7 mb-0 ms-1 mt-1 text-center text-white">
                                            {{ Str::limit($friend->username, 7, "...") }}
                                        </p>

                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-white">Tidak ada teman yang ditemukan.</p>
                        @endif
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-evenly border-0" style="padding-bottom: -30px;">

                    <div class="d-block text-center" style="width: 60px;">
                        <div class="rounded-pill border border-white p-2" style="width: 56px;">
                            <i class="bi bi-whatsapp fs-2 text-white"></i>
                        </div>
                        <p class="fs-8 mb-0 me-2 mt-1 text-white">WhatsApp</p>
                    </div>

                    <div class="d-block text-center" style="width: 60px;">
                        <div class="rounded-pill border border-white p-2" style="width: 56px;">
                            <i class="bi bi-copy fs-2 text-white"></i>
                        </div>
                        <p class="fs-8 mb-0 mt-1 text-white">Salin Link</p>
                    </div>

                    <div class="d-block text-center" style="width: 60px;">
                        <div class="rounded-pill border border-white p-2" style="width: 56px;">
                            <i class="bi bi-download fs-2 text-white"></i>
                        </div>
                        <p class="fs-8 mb-0 mt-1 text-white">Unduh</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}



    <style>
        .modal-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            margin: 0;
        }


        .radio-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            width: 22px;
            height: 22px;
            accent-color: #007bff;
            /* Warna biru ala Bootstrap */
        }

        label {
            font-size: 13px;
        }
    </style>


    <style>
        .collapsed {
            max-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .expanded {
            max-height: 1000px;
            overflow: visible;
        }
    </style>

</div>


@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('laporModal').addEventListener('shown.bs.modal', function() {
                setTimeout(() => {
                    const container = document.getElementById('lottie-container');

                    // Bersihkan dulu animasi lama biar nggak bentrok
                    container.innerHTML = "";

                    // Muat ulang animasi Lottie
                    lottie.loadAnimation({
                        container: container,
                        renderer: 'svg',
                        loop: true,
                        autoplay: true,
                        path: '{{ asset("images/animation5.json") }}'
                    });
                }, 100); // Delay agar modal sudah muncul sebelum animasi dimuat
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const postId = "{{ request()->route("postId") }}";
                if (postId) {
                    const target = document.getElementById('post-' + postId);
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
@endpush


{{-- 
<div class="rounded" style="margin-top:90px;
background: linear-gradient(to left,  rgba(1, 4, 30, 0.961),  rgba(1, 13, 30, 0.276), rgba(0, 0, 0, 0.087)), 
        url('https://i.pinimg.com/474x/03/47/b3/0347b3676e6f6b8757ff2315c5710d44.jpg'); background-size: cover; width: 100%; height: 350px;">
    <div class="d-flex">
        <div class="d-block ms-auto text-center" style="width: 65px;">
            <div class="ms-3 text-start" style="margin-top: 152px;">
                <i class="bi bi-heart-fill fs-5 me-3 text-white" style="cursor: pointer;"></i>
                <p class="fs-8 text-white">Suka</p>
            </div>
            <div class="ms-1 mt-3 text-start">
                <i class="fa-solid fa-share fs-5 ms-2 text-white" style="cursor: pointer;"></i>
                <p class="fs-8 text-white">Bagikan</p>
            </div>
            <div class="me-4 mt-3">
                <i class="bi bi-exclamation-square-fill fs-5 ms-auto text-white"></i>
                <p class="fs-8 text-white">Laporkan</p>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center px-3" style="margin-top: -39px;">
        <img src="https://i.pinimg.com/474x/03/47/b3/0347b3676e6f6b8757ff2315c5710d44.jpg" class="rounded-pill" style="width: 40px; height: 40px;">
        <p class="fs-10 ms-2 mt-3 text-white">Indra Pratama</p>
    </div>

    <p class="fs-7 mt-3 text-white">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fuga nostrum vero asperiores nisi excepturi iste totam id ullam quibusdam velit?</p>
</div> --}}
