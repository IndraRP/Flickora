<?php

namespace App\Livewire\User\Page;

use App\Models\Banding;
use App\Models\Coments;
use App\Models\Like;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Tagdetail extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $users;
    public $userId;
    public $postId;
    public $posts;
    public $additionalInfo;

    public $report_id;
    public $alasan;
    public $bukti;
    public $report_reason;
    public $friends;
    public $alreadyReported = false;
    public $tags;

    public $post_id;
    public $teks_komentar;
    public $komentar_list = [];

    public $refreshInterval = 10000;

    protected $listeners = [
        'muatKomentar' => 'muatKomentar',
        'refreshKomentar' => '$refresh',
        'getImageUrl' => 'handleGetImageUrl'
    ];

    protected $rules = [
        'teks_komentar' => 'required|min:1',
        'additionalInfo' => 'required|min:5',
    ];

    public function mount($userid, $tagId = null)
    {
        // Simpan userId
        $this->userId = $userid;

        // Ambil semua post berdasarkan post_id di tabel tag
        $this->posts = Post::whereIn('id', function ($query) {
            $query->select('post_id')->from('tag')->where('user_id', $this->userId);
        })->get();

        // Ambil data tag berdasarkan ID jika diberikan
        if ($tagId) {
            $tag = \App\Models\Tag::find($tagId);

            if ($tag) {
                $this->post_id = $tag->post_id; // Ambil post_id dari tag
            }
        }

        // Muat komentar jika post_id tersedia
        if ($this->post_id) {
            $this->muatKomentar();
        }
    }



    // public function setPostId($id)
    // {
    //     $this->postId = $id;
    // }

    public function setPostId($id)
    {
        $this->post_id = $id;
        logger()->info('Post ID berhasil disimpan: ' . $this->post_id);
    }

    public function setPostId2($id)
    {
        $this->post_id = $id;
        logger()->info('Post ID berhasil disimpan: ' . $this->post_id);
        $this->muatKomentar($this->post_id);
    }


    public function isPostInBanding($postId)
    {
        return Banding::where('post_id', $postId)->exists();
    }

    public function report()
    {
        $this->validate();

        // Simpan laporan baru
        Report::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'alasan' => $this->additionalInfo,
        ]);


        // Hitung jumlah laporan untuk post ini
        $totalReports = Report::where('post_id', $this->postId)->count();

        // Jika laporan lebih dari 3, set approved menjadi 1
        if ($totalReports >= 3) {
            DB::table('reports')
                ->where('post_id', $this->postId)
                ->update(['approved' => 1]);
        }

        $this->reset('additionalInfo');
        $this->alert('success', 'Terima kasih, laporan akan kami cek');

        return redirect()->to(request()->header('Referer'));
    }

    public function isPostReported($postId)
    {
        return \App\Models\Report::where('post_id', $postId)->where('approved', 1)->exists();
    }

    public function toggleLike($postId)
    {
        $user = Auth::user();
        $existingLike = Like::where('user_id', $user->id)
            ->where('post_id', $postId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $postId
            ]);
        }
        // return redirect()->to(request()->header('Referer'));
    }

    public function salin()
    {
        $this->alert('success', 'Link Berhasil di copy');
    }

    public function setReportId($postId)
    {
        $this->report_id = Report::where('post_id', $postId)->value('id');
    }


    public function submitBanding()
    {
        $this->validate([
            'alasan' => 'required|string',
            'bukti' => 'nullable|image|max:5120',
        ]);

        $buktiPath = $this->bukti ? $this->bukti->store('bukti_banding', 'public') : null;

        Banding::create([
            'user_id' => $this->userId, // Gunakan userId dari URL
            'post_id' => $this->postId, // Gunakan postId dari URL
            'report_id' => $this->report_id,
            'report_reason' => $this->report_reason, // Tambahkan alasan dari radio
            'alasan' => $this->alasan,
            'bukti' => $buktiPath,
        ]);



        $this->alert('success', 'Terima kasih, laporan banding akan kami cek');
        return redirect()->to(request()->header('Referer'));
    }

    public function handleGetImageUrl($postId)
    {
        dd("klfmdc,x");
        try {
            $post = Post::findOrFail($postId);

            if (!$post->image) {
                $this->emit('imageUrlGenerated', [
                    'success' => false,
                    'message' => 'Gambar tidak ditemukan'
                ]);
                return;
            }

            $imageUrl = asset('storage/images/' . $post->image);
            $filename = basename($post->image);

            // Emit URL gambar ke JavaScript
            $this->emit('imageUrlGenerated', [
                'success' => true,
                'imageUrl' => $imageUrl,
                'filename' => $filename
            ]);
        } catch (\Exception $e) {
            $this->emit('imageUrlGenerated', [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public $downloadUrl;
    public function download($postId)
    {
        $post = Post::findOrFail($postId);
        $filePath = 'public/' . $post->image; // Sesuaikan path penyimpanan

        dd($post);

        if (Storage::exists($filePath)) {
            // Generate temporary URL
            $this->downloadUrl = Storage::url($filePath);

            // Emit event ke frontend agar JavaScript bisa menangani download
            $this->dispatchBrowserEvent('downloadFile', ['url' => $this->downloadUrl]);
        } else {
            session()->flash('error', 'Gambar tidak ditemukan!');
        }
    }

    // coment
    public function muatKomentar($post_id = null)
    {
        if ($post_id) {
            $this->post_id = $post_id;
        }

        if ($this->post_id) {
            $this->komentar_list = Coments::where('post_id', $this->post_id)
                ->with('user')
                ->orderBy('id', 'desc') // Urutkan berdasarkan id dari terbesar ke terkecil
                ->get();
        }
    }


    public function getListeners()
    {
        $listeners = [
            'muatKomentar' => 'muatKomentar',
            'refreshKomentar' => '$refresh',
        ];

        // Polling untuk refresh otomatis
        if ($this->refreshInterval) {
            $listeners['polling'] = '$refresh';
        }

        return $listeners;
    }


    public function tambahKomentar()
    {
        $this->validate([
            'teks_komentar' => 'required|min:1'
        ], [
            'teks_komentar.required' => 'Komentar tidak boleh kosong',
            'teks_komentar.min' => 'Komentar minimal 1 karakter'
        ]);

        if (!Auth::check()) {
            session()->flash('pesan_error', 'Anda harus login terlebih dahulu.');
            return;
        }

        // // Pastikan post_id tidak null
        // if (!$this->post_id) {
        //     session()->flash('pesan_error', 'Terjadi kesalahan, post tidak ditemukan.');
        //     return;
        // }

        // dd($this->post_id);

        Coments::create([
            'user_id' => Auth::id(),
            'post_id' => $this->post_id, // Ambil dari property
            'content' => $this->teks_komentar,
        ]);

        $this->teks_komentar = '';

        // Muat ulang komentar
        $this->muatKomentar();

        // Emit event agar komponen lain yang mendengarkan bisa refresh juga
        $this->dispatch('komentarDitambahkan', $this->post_id);
    }



    public function render()
    {
        return view('livewire.user.page.tagdetail', [
            'posts' => Post::latest()->get(),
        ])
            ->extends('layouts.app')
            ->section('content');
    }
}
