<?php

use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\PrivateChatController;
use App\Livewire\Auth\Login\Login;
use App\Livewire\Auth\Signup\Signup;
use App\Livewire\CompressImage;
use App\Livewire\User\Bio\Bio;
use App\Livewire\User\Group\Group;
use App\Livewire\User\Group\GroupChat;
use App\Livewire\User\Group\GrupDetail;
use App\Livewire\User\Lock\Chatbox;
use App\Livewire\User\Lock\ChatDetail;
use App\Livewire\User\Lock\Createchat;
use App\Livewire\User\Lock\Lock;
use App\Livewire\User\Lock\PrivateChat;
use App\Livewire\User\Page\Alluser;
use App\Livewire\User\Page\Friendships;
use App\Livewire\User\Page\Highlightdetail;
use App\Livewire\User\Page\Notif;
use App\Livewire\User\Page\Page;
use App\Livewire\User\Page\PostinganDetail;
use App\Livewire\User\Page\Tagdetail;
use App\Livewire\User\Page\UploadPost;
use App\Livewire\User\Page\UserDetail;
use App\Livewire\User\Page\Videodetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/cek', function () {
    dd(Hash::make('12345678'));
});


// compress img
Route::get('/compres', CompressImage::class)->name('compres');


Route::get('/login', Login::class)->name('login');
Route::get('/signup', Signup::class)->name('signup');
Route::get('/', Page::class)->name('page');
Route::get('/group', Group::class)->name('group');


Route::get('/bio', Bio::class)->name('bio');

Route::get('/alluser', Alluser::class)->name('alluser');
Route::get('/userdetail/{userId}', UserDetail::class)->name('userdetail');
Route::get('/postdetail/{userid}/{postId}', PostinganDetail::class)->name('postdetail');
// Route::get('/tagdetail/{userid}/{postId}', Tagdetail::class)->name('tagdetail');
Route::get('/tagdetail/{userid}/{tagId}', Tagdetail::class)->name('tagdetail');

Route::get('/highdetail/{userid}/{highlightId}', Highlightdetail::class)->name('highdetail');
Route::get('/videodetail/{userid}/{videoId}', Videodetail::class)->name('videodetail');

Route::get('/upload_post', UploadPost::class)->name('upload_post');

Route::get('/notif', Notif::class)->name('notif');
Route::get('/friendships', Friendships::class)->name('friendships');

Route::get('/lock', Lock::class)->name('lock');
Route::get('/privatechat', PrivateChat::class)->name('privatechat');
Route::get('/chatbox', Chatbox::class)->name('chatbox');
Route::get('/create_chat', Createchat::class)->name('create_chat');
Route::get('/chat_detail', ChatDetail::class)->name('chat_detail');

// Route::get('/postdetail/{userid}', \App\Http\Livewire\PostinganDetail::class)->name('postdetail');


Route::get('/grup', GroupChat::class)->name('grup');
Route::get('/grup_detail', GrupDetail::class)->name('grup_detail');

Route::get('/groups', [GroupChatController::class, 'index'])->name('groups.index');
Route::get('/groups/{group}', [GroupChatController::class, 'show'])->name('groups.show');
Route::post('/groups/{group}/send-message', [GroupChatController::class, 'sendMessage'])->name('groups.sendMessage');

Route::get('/chatify_private', [PrivateChatController::class, 'index'])->name('chatify.private');
