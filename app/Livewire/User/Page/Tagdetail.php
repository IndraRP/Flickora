<?php

namespace App\Livewire\User\Page;

use App\Models\Banding;
use App\Models\Coments;
use App\Models\Like;
use App\Models\Post;
use App\Models\Report;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
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
    public $tag;
    public $tag_id;
    public $user;
    public $parent_id = null;
    public $show_replies = [];

    public $post_id;
    public $teks_komentar;
    public $komentar_list = [];
    public $selectedImage;


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
        // $this->userId = $userid;

        $this->userId = (int) $userid; // pastikan integer

        $this->user = User::find($userid);
        // dd([
        //     'this->userId' => $this->userId,
        //     'auth()->id()' => auth()->id(),
        // ]);

        $this->friends = DB::table('friendships')
            ->join('users', 'friendships.friend_id', '=', 'users.id')
            ->where('friendships.user_id', Auth::id())
            ->where('friendships.status', 'approved')
            ->select('users.id', 'users.username', 'users.avatar')
            ->get();


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
        // dd($tagId);

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
        dd($this->post_id);
        logger()->info('Post ID berhasil disimpan: ' . $this->post_id);
    }

    public function setTagId($id)
    {
        $this->tag_id = $id;
        // dd($this->tag_id);
        logger()->info('Post ID berhasil disimpan: ' . $this->tag_id);
    }

    public function setPostId2($id)
    {
        $this->post_id = $id;
        logger()->info('Post ID berhasil disimpan: ' . $this->post_id);
        $this->muatKomentar($this->post_id);
    }

    public function waktuSingkat($timestamp)
    {
        $waktu = Carbon::parse($timestamp);
        $selisih = $waktu->diffInSeconds(now());

        if ($selisih < 60) {
            return "$selisih detik";
        } elseif ($selisih < 3600) {
            return floor($selisih / 60) . " menit";
        } elseif ($selisih < 86400) {
            return floor($selisih / 3600) . " jam";
        } elseif ($selisih < 604800) {
            return floor($selisih / 86400) . " hari";
        } elseif ($selisih < 2419200) {
            return floor($selisih / 604800) . " minggu";
        } elseif ($selisih < 29030400) {
            return floor($selisih / 2419200) . " bulan";
        } else {
            return floor($selisih / 29030400) . " tahun";
        }
    }


    public function isPostInBanding($postId)
    {
        return Banding::where('post_id', $postId)->exists();
    }

    public function setImageModal($image)
    {
        $this->selectedImage = $image;
        $this->dispatch('openImageModal');
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
        if (!$this->teks_komentar) {
            session()->flash('pesan_error', 'Komentar tidak boleh kosong!');
            return;
        }

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

        // dd($this->parent_id);

        Coments::create([
            'user_id' => Auth::id(),
            'post_id' => $this->post_id,
            'content' => $this->teks_komentar,
            'parent_id' => $this->parent_id, // Simpan jika ini balasan
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->teks_komentar = '';
        $this->parent_id = null; // Reset setelah menambah komentar

        $this->muatKomentar();
        $this->dispatch('komentarDitambahkan', $this->post_id);
    }

    public function batal()
    {
        $this->parent_id = null;
    }

    public function setReply($id)
    {
        $this->parent_id = $id;
        // dd($this->parent_id);
    }

    public function toggleReplies($id)
    {
        if (isset($this->show_replies[$id])) {
            unset($this->show_replies[$id]); // Sembunyikan balasan jika sudah terbuka
        } else {
            $this->show_replies[$id] = true; // Tampilkan balasan jika belum terbuka
        }
    }

    public function hapusTag($id)
    {
        $tag = Tag::find($id);

        if ($tag) {
            $tag->delete();

            $this->alert('success', 'Berhasil, Tag berhasil dihapus');
        } else {
            $this->alert('error', 'Gagal, Tag tidak ditemukan');
        }
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
