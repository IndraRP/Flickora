<?php

namespace App\Livewire\Auth\Signup;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Signup extends Component
{
    use LivewireAlert;
    public $name, $username, $email, $password, $confirm_password, $gender, $no_hp, $tanggal_lahir;

    protected $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'no_hp' => 'required|numeric|digits_between:9,13',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'confirm_password' => 'required|same:password',
        'gender' => 'required|in:laki_laki,perempuan',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan, pilih yang lain.',
        'no_hp.required' => 'Nomor HP wajib diisi.',
        'no_hp.digits_between' => 'Nomor HP harus memiliki panjang antara 9 hingga 13 digit.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan, pilih yang lain.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal harus 8 karakter.',
        'confirm_password.required' => 'Konfirmasi password wajib diisi.',
        'confirm_password.same' => 'Konfirmasi password harus sama dengan password.',
        'gender.required' => 'Jenis kelamin wajib dipilih.',
        'gender.in' => 'Jenis kelamin tidak valid.',
    ];


    public function signup()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'gender' => $this->gender,
            'tanggal_lahir' => $this->tanggal_lahir
        ]);
        $this->alert('success', 'Berhasil, Anda berhasil terdaftar.');
        return redirect()->route('login');
    }


    public function render()
    {
        return view('livewire.auth.signup.signup')
            ->extends('layouts.app')
            ->section('content');
    }
}
