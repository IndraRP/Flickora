<div style="background: #1C1C1C;">

    <div class="d-flex fixed-top px-2 py-2" style="background-color: #0c0b0b89;">
        <div class="d-flex me-auto">
            <a href="javascript:void(0)" onclick="handleBack()"><i class="fa-solid fa-chevron-left fs-6 rounded-pill text-white" style="background-color: #2423237c; padding-top:13px; padding-bottom: 13px; padding-right: 17px; padding-left: 17px; margin-top: 3px; margin-bottom: 3px;"></i></a>
        </div>
        <div class="position-relative w-100 d-flex">
            <p class="mb-0 rounded px-3 text-center text-white" style="background-color: #24232300; padding-top: 5px; font-size: 17px; font-weight: 500; height: 35px; margin-top: 5px; margin-left: -5px;">Permintaan Pertemanan</p>

            <p class="text-danger mb-0 rounded px-1 text-center" style="padding-top: 5px; font-size: 19px; font-weight: 700; height: 35px; margin-top: 3px;">{{ $Friendships_Count }}</p>
        </div>
    </div>

    <script>
        function handleBack() {
            if (document.referrer) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }
    </script>

    <div style="margin-top: 80px;">
        @if ($pendingFriendships->isNotEmpty())
            @foreach ($pendingFriendships as $friendship)
                <div class="d-flex align-items-center rounded" style="padding-left:12px; padding-right:12px; margin-bottom: 25px;">
                    <div>
                        <a class="text-decoration-none" href="{{ route("userdetail", ["userId" => $friendship->sender->id]) }}">
                            <img src="{{ "storage/" . $friendship->sender->avatar }}" class="rounded-pill" style="width: 80px; height: 80px; object-fit: cover;">
                        </a>
                    </div>

                    <div class="d-block" style="margin-left: 12px;">
                        <div class="d-flex" style=" margin-bottom: -10px;">
                            <p class="mb-0 rounded text-white" style="background-color: #24232300; font-size: 15px; font-weight: 500; height: 35px;">
                                {{ $friendship->sender->name }}
                            </p>
                            <p class="mb-0 ms-auto mt-1 rounded" style="color:rgb(195, 195, 195); font-size: 12px; font-weight: 200;">
                                2h
                            </p>
                        </div>

                        @if ($friendshipsCount > 0)
                            <div class="d-flex align-items-center" style="margin-top: 0px; margin-bottom:-15px;">
                                <p class="mb-0 rounded" style="color:rgb(195, 195, 195); background-color: #24232300; padding-top: 0px; font-size: 12px; font-weight: 500; height: 35px;">
                                    Berteman dengan
                                </p>

                                <p class="mb-0 rounded ps-1" style="color:rgb(195, 195, 195); background-color: #24232300; padding-top: 0px; font-size: 12px; font-weight: 500; height: 35px;">
                                    {{ $friendshipsCount }} orang
                                </p>
                            </div>
                        @endif


                        <div class="d-flex mt-1">
                            <button class="btn fs-7 text-danger border border-white" style="width: 118px;" wire:click="rejectFriendship({{ $friendship->user_id }})">Tolak</button>
                            <button class="btn btn-primary fs-7 ms-2" style="width: 118px;" wire:click="acceptFriendship({{ $friendship->user_id }})">Terima</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        @endif

    </div>

</div>
