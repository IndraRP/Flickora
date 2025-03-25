<div class="text-white">
    <h3>Daftar Gambar di Storage</h3>

    @if (session()->has("message"))
        <div class="alert alert-success">{{ session("message") }}</div>
    @endif
    @if (session()->has("error"))
        <div class="alert alert-danger">{{ session("error") }}</div>
    @endif

    <button wire:click="compressAll" class="btn btn-danger mb-3">
        Compress Semua
    </button>

    <ul>
        @foreach ($images as $image)
            <li>
                <img src="{{ Storage::url($image) }}" width="100">
                <button wire:click="compress('{{ $image }}')" class="btn btn-sm btn-primary">
                    Compress
                </button>
            </li>
        @endforeach
    </ul>
</div>
