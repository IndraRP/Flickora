<?php

namespace App\Livewire\User\Page;

use App\Models\Friendship;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use App\Models\Like;
use App\Models\Likes_Highlight;
use App\Models\Report;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class UserDetail extends Component
{
    use LivewireAlert;

    public $user;
    public $users;
    public $userId;
    public $avatar;
    public $posts;
    public $post;
    public $friend;
    public $friendshipStatus;
    public $isPrivate;
    public $isFriend;
    public $tags;
    public $videos;
    public $totalLikes;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $friendshipsCount = [];
    public $postsCount = [];

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::findOrFail($this->userId);
        $this->users = User::get();
        $this->avatar = $this->user->avatar;
        $this->postsCount = Post::where('user_id', $this->userId)->count();
        $this->tags = Tag::where('user_id', $this->userId)->with('post')->get();
        $this->videos = Video::where('user_id', $this->userId)->with('post')->get();

        // dd($this->userId);
        $likesCount = Like::where('user_id', $this->userId)->count();
        $highlightLikesCount = Likes_Highlight::where('user_id', $this->userId)->count();
        $this->totalLikes = $likesCount + $highlightLikesCount;

        // Cek Status Pertemanan
        $this->friendshipStatus = Friendship::where(function ($query) {
            $query->where('user_id', Auth::id())
                ->where('friend_id', $this->userId)
                ->where('status', 'approved');
        })->orWhere(function ($query) {
            $query->where('user_id', $this->userId)
                ->where('friend_id', Auth::id())
                ->where('status', 'approved');
        })->first();


        $this->isPrivate = $this->user->private;

        // // Ambil Postingan Berdasarkan Status Pertemanan & Private
        // if ($this->friendshipStatus || $this->isPrivate == 0) {
        //     // Jika Sudah Berteman atau Akun Tidak Privat, Ambil Semua Postingan
        //     $this->posts = Post::where('user_id', $this->userId)->get();
        // } else {
        //     // Jika Belum Berteman dan Akun Privat, Batasi Maksimal 9 Postingan
        //     $this->posts = Post::where('user_id', $this->userId)->take(9)->get();
        // }

        // Ambil Postingan Berdasarkan Status Pertemanan
        if ($this->friendshipStatus) {
            // Jika Sudah Berteman, Ambil Semua Postingan
            $this->posts = Post::where('user_id', $this->userId)->get();
        } else {
            // Jika Belum Berteman, Batasi Maksimal 12 Postingan
            $this->posts = Post::where('user_id', $this->userId)->take(12)->get();
        }

        // Hitung Jumlah Pertemanan yang Disetujui (Approved)
        $this->friendshipsCount = DB::table('friendships')
            ->select('user_id', DB::raw('COUNT(*) as total'))
            ->where('user_id', $this->userId)
            ->where('status', 'approved')
            ->groupBy('user_id')
            ->pluck('total', 'user_id')
            ->toArray();

        $this->checkFriendship();
    }

    public function saveUserAndTagIdToSession($tagId)
    {
        $tag = Tag::find($tagId);

        if ($tag) {
            session()->put('current_user_id', $tag->user_id);
            session()->put('current_tag_id', $tagId);
            return redirect()->route('tagdetail', ['userid' => $tag->user_id, 'tagId' => $tagId]);
        } else {
            return redirect()->route('home')->with('error', 'Tag tidak ditemukan');
        }
    }

    public function saveUserAndVideoIdToSession($videoId)
    {
        $video = Video::find($videoId);

        if ($video) {
            session()->put('current_user_id', $video->user_id);
            session()->put('current_tag_id', $videoId);
            return redirect()->route('videodetail', ['userid' => $video->user_id, 'videoId' => $videoId]);
        } else {
            return redirect()->route('home')->with('error', 'Tag tidak ditemukan');
        }
    }

    public function checkFriendship()
    {
        $this->isFriend = Friendship::where(function ($query) {
            $query->where('user_id', Auth::id())
                ->where('friend_id', $this->userId)
                ->where('status', 'approved');
        })
            ->orWhere(function ($query) {
                $query->where('user_id', $this->userId)
                    ->where('friend_id', Auth::id())
                    ->where('status', 'approved');
            })
            ->exists();
    }


    public function setUser($id)
    {
        $this->user = User::find($id);
        $this->avatar = $this->user->avatar;
    }

    public function saveUserAndPostIdToSession($postId)
    {
        // Ambil post berdasarkan ID
        $post = Post::find($postId);

        // Cek apakah post ditemukan
        if ($post) {
            // Simpan user_id dan post_id ke session
            session()->put('current_user_id', $post->user_id);
            session()->put('current_post_id', $postId);

            // Redirect ke route dengan parameter user_id dan post_id
            return redirect()->route('postdetail', ['userid' => $post->user_id, 'postId' => $postId]);
        } else {
            // Jika post tidak ditemukan, bisa dialihkan ke halaman lain
            return redirect()->route('home')->with('error', 'Post tidak ditemukan');
        }
    }

    public function isPostReported($postId)
    {
        return Report::where('post_id', $postId)->where('approved', 1)->exists();
    }


    public function invite($friendId)
    {
        // dd("Masuk ke method invite");

        $exists = Friendship::where('user_id', Auth::id())
            ->where('friend_id', $friendId)
            ->whereIn('status', ['approved'])
            ->exists();

        if (!$exists) {
            Friendship::create([
                'user_id' => Auth::id(),
                'friend_id' => $friendId,
                'status' => 'pending',
            ]);

            // Friendship::create([
            //     'user_id' => $friendId,
            //     'friend_id' => Auth::id(),
            //     'status' => 'pending',
            // ]);

            // dd("Berhasil Membuat Friendship");

            $this->alert('success', 'Berhasil Mengirimkan Undangan');
        } else {
            dd("Sudah ada atau status pending/approved"); // Cek jika sudah ada
            $this->alert('error', 'Maaf, Anda Gagal Mengirim Undangan');
        }

        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.user.page.user-detail')
            ->extends('layouts.app')
            ->section('content');
    }
}
