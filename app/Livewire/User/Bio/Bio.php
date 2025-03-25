<?php

namespace App\Livewire\User\Bio;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads as LivewireWithFileUploads;

class Bio extends Component
{
    use LivewireAlert;
    use LivewireWithFileUploads;

    public $users;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public $avatar;
    public $background;
    public $isAvatarValid = false;
    public $isUsernameAvailable = null;

    public $current_pin;
    public $new_pin;
    public $new_pin_confirmation;
    public $hasPin;

    public $friendshipsCount = [];
    public $postsCount = [];

    public $pin;
    public $confirmPin;

    protected $rules = [
        'pin' => 'required|digits:5',
        'confirmPin' => 'required|same:pin',
    ];

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $this->users = $user->toArray();
        $this->users['id'] = $user->id;

        $this->postsCount = Post::where('user_id', $user->id)->count();

        $this->friendshipsCount = DB::table('friendships')
            ->select('user_id', DB::raw('COUNT(*) as total'))
            ->where('user_id', $user->id)
            ->where('status', 'approved')  // Hanya ambil yang approved
            ->groupBy('user_id')
            ->pluck('total', 'user_id')
            ->toArray();

        $this->updatedUsersUsername($this->users['username']);

        $this->hasPin = !empty($user->pin);
    }

    public function getIsLikedProperty()
    {
        return $this->highlight->likes()->where('user_id', auth()->id())->exists();
    }


    public function updatedUsersUsername($value)
    {
        session()->flash('message', 'Memeriksa username: ' . $value);

        if (empty($value)) {
            $this->isUsernameAvailable = null;
            return;
        }

        $user = User::find($this->users['id']);

        // Cek apakah sudah mengganti username lebih dari 3x
        if ($user->username_changes >= 3) {
            $this->isUsernameAvailable = false; // Pakai false agar tampilannya merah
            session()->flash('error', 'Username hanya bisa diganti 3x.');
            return;
        }

        // Jika username sama dengan yang sekarang, otomatis tersedia
        if ($value === $user->username) {
            $this->isUsernameAvailable = true;
            return;
        }

        // Cek apakah username sudah ada di database
        $this->isUsernameAvailable = !User::where('username', $value)
            ->where('id', '!=', $user->id)
            ->exists();
    }

    public function checkUsername()
    {
        $this->updatedUsersUsername($this->users['username']);
    }

    public function updatePhoto()
    {
        $this->isAvatarValid = false;

        $this->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'background' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);
        $this->isAvatarValid = true;
        $user = auth()->user();

        if ($this->avatar) {
            // Hapus avatar lama jika ada
            if ($user->avatar && $user->avatar !== 'avatar.png') {
                Storage::delete('public/' . $user->avatar); // Pastikan hapus berdasarkan path relatif
            }
            // Simpan avatar baru
            $avatarName = $this->avatar->store('users-avatar', 'public');
            $user->avatar = $avatarName;
        }

        if ($this->background) {
            // Hapus background lama jika ada
            if ($user->background) {
                Storage::delete('public/' . $user->background); // Pastikan hapus berdasarkan path relatif
            }
            // Simpan background baru
            $backgroundName = $this->background->store('backgrounds', 'public');
            $user->background = $backgroundName;
        }

        $user->save();

        $this->alert('success', 'Foto Profil Berhasil Diperbarui');
        return redirect()->to(request()->header('Referer'));
    }

    public function updateProfile()
    {
        $this->validate([
            'users.name' => 'required|string|max:255',
            'users.email' => 'required|email|max:255|unique:users,email,' . $this->users['id'],
            'users.username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->users['id']),
            ],
            'users.address' => 'nullable|string|max:255',
            'users.no_hp' => 'nullable|string|max:15',
            'users.gender' => 'required|in:laki_laki,perempuan',
        ]);

        $user = User::find($this->users['id']);

        // Cek apakah username berubah
        if ($user->username !== $this->users['username']) {
            if ($user->username_changes >= 3) {
                $this->alert('error', 'Username hanya bisa diganti 3x');
                return;
            }

            // Increment jumlah perubahan username
            $user->increment('username_changes');
        }

        // Update profil tanpa mengubah username_changes secara manual
        $user->update([
            'name' => $this->users['name'],
            'email' => $this->users['email'],
            'username' => $this->users['username'],
            'address' => $this->users['address'],
            'no_hp' => $this->users['no_hp'],
            'gender' => $this->users['gender'],
        ]);

        $this->alert('success', 'Berhasil Mengubah Profil');
        return redirect()->to(request()->header('Referer'));
    }

    public function updatePin()
    {
        $this->validate([
            'current_pin' => 'required|digits:5',
            'new_pin' => 'required|digits:5|confirmed',
        ], [
            'current_pin.required' => 'PIN lama wajib diisi.',
            'current_pin.digits' => 'PIN lama harus terdiri dari 5 angka.',
            'new_pin.required' => 'PIN baru wajib diisi.',
            'new_pin.digits' => 'PIN baru harus terdiri dari 5 angka.',
            'new_pin.confirmed' => 'Konfirmasi PIN tidak sesuai dengan PIN baru.',
        ]);

        $user = Auth::user();

        // Cek apakah PIN lama benar
        if (!Hash::check($this->current_pin, $user->pin)) {
            $this->addError('current_pin', 'PIN lama tidak sesuai.');
            return;
        }

        // Update PIN baru
        $user->pin = Hash::make($this->new_pin);
        $user->save();

        // Reset input
        $this->reset(['current_pin', 'new_pin', 'new_pin_confirmation']);

        $this->alert('success', 'PIN berhasil diubah.');
        return redirect()->to(request()->header('Referer'));
    }

    public function savePin()
    {
        $this->validate();

        // Ambil user yang sedang login
        $user = Auth::user();

        // dd($user);
        // Simpan PIN dalam bentuk hash
        $user->update([
            'pin' => Hash::make($this->pin)
        ]);
        $this->reset(['pin', 'confirmPin']);
        $this->alert('success', 'PIN berhasil dibuat.');
        return redirect()->to(request()->header('Referer'));
    }


    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah password lama benar
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password lama tidak sesuai.');
            return;
        }

        // Update password baru
        $user->password = Hash::make($this->new_password);
        $user->save();

        // Reset input field
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->alert('success', 'Berhasil Mengubah Password');
        return redirect()->to(request()->header('Referer'));
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // Atau bisa mengarahkannya ke halaman lain setelah logout
    }


    public function render()
    {
        return view('livewire.user.bio.bio')
            ->extends('layouts.app')
            ->section('content');
    }
}
