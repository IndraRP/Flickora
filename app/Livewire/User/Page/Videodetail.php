<?php

namespace App\Livewire\User\Page;

use App\Models\Comment_Videos;
use App\Models\Likes_Highlight;
use App\Models\Likes_Video;
use App\Models\Report;
use App\Models\Report_Video;
use App\Models\Banding_Video;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Videodetail extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $userId;
    public $users;
    public $video_id;
    public $videoId;
    public $friends;
    public $videos;
    public $post;
    public $report_reason;
    public $report_id;
    public $bukti;
    public $teks_komentar;
    public $alasan;
    public $komentar_list = [];

    public $parent_id = null;
    public $show_replies = [];

    public $refreshInterval = 10000;

    protected $listeners = [
        'muatKomentar' => 'muatKomentar',
        'refreshKomentar' => '$refresh',
        'getImageUrl' => 'handleGetImageUrl',
    ];

    protected $rules = [
        'teks_komentar' => 'required|min:1',
        'alasan' => 'required|min:5',
    ];

    public function mount($userid, $video_id = null)
    {
        // Simpan userId
        $this->userId = $userid;

        // Ambil data user
        $this->users = User::get();

        // Ambil semua post milik user
        $this->videos = Video::where('user_id', $this->userId)->get();

        $this->video_id = $video_id;
        if ($this->video_id) {
            $this->muatKomentar();
        }
        $this->video_id = $video_id;
    }

    public function setVideoId($videoId)
    {
        $this->video_id = $videoId;
        // $this->muatKomentar(); // Jika ini memang harus dipanggil saat video diubah
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

    public function setPostId2($id)
    {
        $this->video_id = $id;
        logger()->info('Post ID berhasil disimpan: ' . $this->video_id);
        $this->muatKomentar($this->video_id);
    }

    public function hapus()
    {
        $video = Video::find($this->videoId);


        if ($video) {
            // Hapus gambar jika ada
            if ($video->image && Storage::disk('public')->exists($video->image)) {
                Storage::disk('public')->delete($video->image);
            }

            // Hapus video jika ada
            if ($video->video && Storage::disk('public')->exists($video->video)) {
                Storage::disk('public')->delete($video->video);
            }

            // Hapus record dari database
            $video->delete();

            $this->alert('success', 'Berhasil, Postingan berhasil dihapus');
            return redirect()->to(request()->header('Referer'));
        } else {
            $this->alert('error', 'Gagal, Postingan gagal dihapus');
        }
    }

    public function muatKomentar($video_id = null)
    {
        // dd($video_id);
        if ($video_id) {
            $this->video_id = $video_id;
        }

        if ($this->video_id) {
            $this->komentar_list = Comment_Videos::where('video_id', $this->video_id)
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

        Comment_Videos::create([
            'user_id' => Auth::id(),
            'video_id' => $this->video_id,
            'content' => $this->teks_komentar,
            'parent_id' => $this->parent_id, // Simpan jika ini balasan
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->teks_komentar = '';
        $this->parent_id = null; // Reset setelah menambah komentar

        $this->muatKomentar();
        $this->dispatch('komentarDitambahkan', $this->video_id);
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

    public function toggleLike($videoId)
    {
        $user = Auth::user();
        $existingLike = Likes_Video::where('user_id', $user->id)
            ->where('video_id', $videoId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Likes_Video::create([
                'user_id' => $user->id,
                'video_id' => $videoId
            ]);
        }
        // return redirect()->to(request()->header('Referer'));
    }

    public function setReportId($videoId)
    {
        $this->video_id = Report_Video::where('video_id', $videoId)->value('id');
    }

    public function report()
    {

        // dd($this->alasan);
        // $this->validate();
        // dd($this->videoId, $this->alasan);


        // Simpan laporan baru
        Report_Video::create([
            'video_id' => $this->videoId,
            'user_id' => Auth::id(),
            'alasan' => $this->alasan,
        ]);


        // Hitung jumlah laporan untuk post ini
        $totalReports = Report_Video::where('video_id', $this->videoId)->count();

        // Jika laporan lebih dari 3, set approved menjadi 1
        if ($totalReports >= 3) {
            DB::table('reports_video')
                ->where('video_id', $this->videoId)
                ->update(['approved' => 1]);
        }

        $this->reset('alasan');
        $this->alert('success', 'Terima kasih, laporan akan kami cek');

        return redirect()->to(request()->header('Referer'));
    }

    public function isPostInBanding($videoId)
    {
        return Banding_Video::where('video_id', $videoId)->exists();
    }

    public function submitBanding()
    {
        $this->validate([
            'alasan' => 'required|string',
            'bukti' => 'nullable|image|max:5120',
        ]);

        $buktiPath = $this->bukti ? $this->bukti->store('bukti_banding_video', 'public') : null;
        // dd($this->videoId);

        $data = [
            'user_id' => $this->userId, // Gunakan userId dari URL
            'video_id' => $this->videoId, // Gunakan postId dari URL
            // 'reports_video_id' => $this->report_id,
            'report_reason' => $this->report_reason, // Tambahkan alasan dari radio
            'alasan' => $this->alasan,
            'bukti' => $buktiPath,
        ];

        // dd($data); // Debug sebelum create

        Banding_Video::create($data);


        $this->alert('success', 'Terima kasih, laporan banding akan kami cek');
        return redirect()->to(request()->header('Referer'));
    }

    public function isPostReported($videoId)
    {
        return Report_Video::where('video_id', $videoId)->where('approved', 1)->exists();
    }

    public function render()
    {
        return view('livewire.user.page.videodetail', [
            'posts' => Video::latest()->get(),
            $komentar_list = Comment_Videos::where('video_id', $this->video_id)
                ->whereNull('parent_id') // Hanya komentar utama
                ->orderBy('id', 'desc')
                ->get()
        ])
            ->extends('layouts.app')
            ->section('content');
    }
}
