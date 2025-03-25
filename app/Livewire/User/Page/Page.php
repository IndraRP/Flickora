<?php

namespace App\Livewire\User\Page;

use App\Models\Friendship;
use App\Models\Highlight;
use App\Models\Like;
use App\Models\Likes_Highlight;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Faker\Factory as Faker;

class Page extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $temporaryImage;

    public $user;
    public $name;
    public $address;
    public $email;
    public $phone_number;
    public $avatar;
    public $description;
    public $job;
    public $background;
    public $page_image;

    public $users;
    public $posts;
    public $isPrivate;

    public $friendshipsCount = [];
    public $postsCount = [];

    public $highlights;

    public $highlight;
    public $highlightId;
    public $post;
    public $video;
    public $title;
    public $content;
    public $fileUploaded = false;
    public $imagePreview = null;
    public $videoUrl;
    public $selectedIndex = 0;
    public $likes;
    public $isLiked;
    public $tags;
    public $totalLikes;
    public $videoId;
    public $videos;

    public $likedHighlights = [];
    public $liked = false;

    // use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

    protected $listeners = ['updateSelectedIndex', 'refreshComponent' => '$refresh'];

    public function mount($highlightId = null)
    {

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // dd(session()->all());
        // Session::forget('selected_discount');

        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->address = $this->user->address;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->no_hp;
        $this->avatar = $this->user->avatar;
        $this->description = $this->user->description;
        $this->job = $this->user->job;
        $this->background = $this->user->background;
        $this->isPrivate = $this->user->private;

        $this->users = User::get();
        $this->posts = Post::where('user_id', $this->user->id)->get();
        $this->videos = Video::where('user_id', $this->user->id)->get();

        $this->postsCount = Post::where('user_id', $this->user->id)->count();
        $this->tags = Tag::where('user_id', $this->user->id)->with('post')->get();
        $likesCount = Like::where('user_id', $this->user->id)->count();
        $highlightLikesCount = Likes_Highlight::where('user_id', $this->user->id)->count();
        $this->totalLikes = $likesCount + $highlightLikesCount;

        $this->friendshipsCount = DB::table('friendships')
            ->select('user_id', DB::raw('COUNT(*) as total'))
            ->where('user_id', $this->user->id)
            ->where('status', 'approved')
            ->groupBy('user_id')
            ->pluck('total', 'user_id')
            ->toArray();

        $this->_getHighLight();

        $this->highlightId = $highlightId;
        $this->checkLikeStatus();

        if (Auth::check()) {
            $likedHighlightIds = Likes_Highlight::where('user_id', Auth::id())
                ->pluck('highlight_id')
                ->toArray();

            foreach ($likedHighlightIds as $id) {
                $this->likedHighlights[$id] = true;
            }
        }

        $faker = Faker::create();
        // $videoIds = [
        //     "dQw4w9WgXcQ", // Video valid dari YouTube
        //     "3JZ_D3ELwOQ",
        //     "tgbNymZ7vqY"
        // ];

        // $this->videoId = $videoIds[array_rand($videoIds)];
        // $this->highlight = $highlight;
        // $this->isLiked = Likes_Highlight::where('user_id', Auth::id())
        //     ->where('highlight_id', $this->highlight->id)
        //     ->exists();
    }

    public function saveUserAndPostIdToSession($postId)
    {

        $post = Post::find($postId);

        if ($post) {
            session()->put('current_user_id', $post->user_id);
            session()->put('current_post_id', $postId);
            return redirect()->route('postdetail', ['userid' => $post->user_id, 'postId' => $postId]);
        } else {
            return redirect()->route('home')->with('error', 'Post tidak ditemukan');
        }
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


    public function isPostReported($postId)
    {
        return \App\Models\Report::where('post_id', $postId)->where('approved', 1)->exists();
    }

    public function updatedTemporaryImage()
    {
        // Debugging awal

        dd("hfjjrfkmdjefkd");

        if ($this->temporaryImage) {
            $path = $this->temporaryImage->store('temp-uploads', 'public');
            Session::put('uploaded_image', $path);

            // Debugging: Cek apakah sudah masuk session
            dd(session()->all());
        }
    }

    public function updatedBackground()
    {
        $this->validate([
            'background' => 'image|max:5120', // Hanya gambar, max 5MB
        ]);

        $user = Auth::user();

        // Hapus gambar lama jika ada
        if ($user->background && Storage::disk('public')->exists($user->background)) {
            Storage::disk('public')->delete($user->background);
        }

        // Simpan gambar baru
        $imageName = time() . '.' . $this->background->getClientOriginalExtension();
        $path = $this->background->storeAs('background', $imageName, 'public');

        // Update database
        $user->update(['background' => 'background/' . $imageName]);

        $this->alert('success', 'Foto Berhasil Diperbarui');
        return redirect()->to(request()->header('Referer'));
    }

    public function updatedPageImage()
    {
        $this->validate([
            'background' => 'image|max:5120', // Hanya gambar, max 5MB
        ]);

        $user = Auth::user();

        // dd($user);

        // Hapus gambar lama jika ada
        if ($user->page_image && Storage::disk('public')->exists('page-image/' . $user->page_image)) {
            Storage::disk('public')->delete('page-image/' . $user->page_image);
        }

        // Simpan gambar baru
        $imageName = time() . '.' . $this->page_image->getClientOriginalExtension();
        $path = $this->page_image->storeAs('page-image', $imageName, 'public');

        // Update database
        $user->update(['page_image' => 'page-image/' . $imageName]);

        $this->alert('success', 'Foto Berhasil Diperbarui');
        return redirect()->to(request()->header('Referer'));
    }

    public function togglePrivate()
    {
        logger('togglePrivate dipanggil');
        $user = Auth::user();
        $user->private = !$user->private;
        $user->save();

        $this->isPrivate = $user->private;

        $this->alert('success', 'Status Private Berhasil Diperbarui');
        return redirect()->to(request()->header('Referer'));
    }

    public function updatedPost()
    {
        $this->validate([
            'post' => 'required|image|max:5120', // Maksimal 5MB
        ]);

        // Simpan gambar sementara ke storage
        $imagePath = $this->post->store('post', 'public');
        $imagePreview = asset("storage/$imagePath");

        // Simpan ke session agar bisa diakses di halaman berikutnya
        session()->put('imagePreview', $imagePreview);

        return redirect()->to('/upload_post');
    }

    public function isLiked($highlightId)
    {
        return isset($this->likedHighlights[$highlightId]) && $this->likedHighlights[$highlightId];
    }

    public function checkLikeStatus()
    {
        if (Auth::check()) {
            $this->liked = Likes_Highlight::where('user_id', Auth::id())
                ->where('highlight_id', $this->highlightId)
                ->exists();
        }
    }

    public function toggleLike($highlightId)
    {
        if (!auth()->check()) {
            return;
        }

        if (!$highlightId) {
            throw new \Exception("Highlight ID tidak boleh null");
        }

        $existingLike = Likes_Highlight::where('user_id', auth()->id())
            ->where('highlight_id', $highlightId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Likes_Highlight::create([
                'user_id' => auth()->id(),
                'highlight_id' => $highlightId
            ]);
        }

        $this->_getHighLight();
    }


    // public function updatedVideo()
    // {
    //     $this->validate([
    //         'video' => 'required|mimes:mp4,mov,avi|max:10240', // Maks 10MB
    //     ]);

    //     // Simpan sementara file Livewire ke storage sementara
    //     $filePath = $this->video->getRealPath();

    //     // Tentukan lokasi output setelah dikompresi
    //     $outputPath = storage_path('app/public/compressed_' . time() . '.mp4');

    //     // Gunakan FFmpeg dari Laragon
    //     FFMpeg::open($filePath)
    //         ->export()
    //         ->inFormat(new \FFMpeg\Format\Video\X264)
    //         ->save($outputPath);

    //     // Upload ke Cloudinary setelah dikompresi
    //     $uploadedFile = Cloudinary::uploadVideo($outputPath, [
    //         'folder' => 'videos',
    //         'resource_type' => 'video',
    //         'transformation' => [
    //             'quality' => 'auto',
    //             'width' => 720,
    //             'crop' => 'limit'
    //         ]
    //     ]);

    //     // Ambil URL video yang sudah dikompresi
    //     $this->videoUrl = $uploadedFile->getSecurePath();

    //     // Flash message sukses
    //     dd($this->videoUrl);
    // }

    public function updatedHighlight()
    {
        $this->validate([
            'highlight' => 'required|image|max:5120', // Maksimal 5MB
        ]);

        // Simpan gambar sementara ke storage
        $imagePath = $this->highlight->store('highlight', 'public');
        $this->imagePreview = asset("storage/$imagePath");

        // Tampilkan modal setelah file diunggah
        $this->fileUploaded = true;
        $this->dispatch('show-modal');
    }

    public function saveHighlight()
    {
        $this->validate([
            'title' => 'required|string|max:10', // Batasi max 10 karakter
        ]);

        Highlight::create([
            'userId' => Auth::id(),
            'image' => str_replace(asset('storage/'), '', $this->imagePreview), // Simpan path saja
            'title' => $this->title,
        ]);

        // Reset state
        $this->reset(['highlight', 'title', 'fileUploaded', 'imagePreview']);
        $this->dispatch('hide-modal');
        $this->alert('success', 'Berhasil Upload Highlight');
        return redirect()->to(request()->header('Referer'));
    }

    public function updateSelectedIndex($index)
    {
        $this->selectedIndex = $index;
    }


    public function showHighlight($index)
    {
        $this->selectedIndex = $index;

        // Ambil highlight berdasarkan index yang dipilih
        if (isset($this->highlights[$index])) {
            $highlight = $this->highlights[$index];
            return redirect()->route('highdetail', [
                'userid' => Auth::id(), // ID user yang login
                'tagId' => $highlight->id // ID dari highlight yang diklik
            ]);
        }

        return redirect()->back(); // Jika index tidak ditemukan, kembali ke halaman sebelumnya
    }


    public function next()
    {
        if ($this->selectedIndex < count($this->highlights) - 1) {
            $this->selectedIndex++;
            $this->dispatch('update-swiper', selectedIndex: $this->selectedIndex);
        }
    }

    public function prev()
    {
        if ($this->selectedIndex > 0) {
            $this->selectedIndex--;
            $this->dispatch('update-swiper', selectedIndex: $this->selectedIndex);
        }
    }

    public function render()
    {
        return view('livewire.user.page.page', [
            'highlight' => ['id' => $this->highlightId],
            'liked' => $this->liked
        ])
            ->extends('layouts.app')
            ->section('content');
    }

    private function _getHighLight()
    {
        $this->highlights = Highlight::with(['likes_highlight', 'liked' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->where('userId', Auth::id())->take(20)->latest()->get();
    }
}
