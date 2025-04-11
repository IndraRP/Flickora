<?php

namespace App\Livewire\Auth\Login;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{
    use LivewireAlert;
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    protected $messages = [
        'email.required' => 'Harap bagian email diisi.',
        'email.email' => 'Format email tidak valid.',
        'password.required' => 'Harap bagian kata sandi diisi.',
        'password.min' => 'Kata Sandi minimal 8 karakter.',
    ];

    public function login()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            $this->alert('error', 'Gagal, Email atau Kata Sandi salah!!!.');
            return;
        }

        Auth::login($user, $this->remember);
        // Redirect berdasarkan role
        return $this->redirectBasedOnRole($user);
    }

    private function redirectBasedOnRole($user)
    {
        if ($user->role === Role::Admin) {
            return redirect('/admin');
        } elseif ($user->role === Role::User) {
            return redirect()->route('chatify');
        }

        return redirect('/chatify');
    }

    public function render()
    {
        return view('livewire.auth.login.login')
            ->extends('layouts.app')
            ->section('content');
    }
}
