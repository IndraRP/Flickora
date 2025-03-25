<?php

namespace App\Livewire\User\Lock;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Lock extends Component
{
    use LivewireAlert;
    public $hasPin;
    public $pin;
    public $confirmPin;

    public $pinArray = ['', '', '', '', ''];

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
        $this->hasPin = !empty($user->pin);
    }

    public function updatedPinArray($value, $key)
    {
        // Pindah fokus ke input berikutnya
        $nextIndex = (int)$key + 1;
        if ($nextIndex < 5) {
            $this->dispatch('focus-next', ['index' => $nextIndex]);
        }
    }

    public function checkPinCompletion()
    {
        $pin = implode('', $this->pinArray);

        if (strlen($pin) === 5) {
            // dd($this->pinArray); // Cek isi pinArray saat sudah lengkap
            $this->login($pin);
        }
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


    public function login($pin)
    {
        $this->validate([
            'pinArray.*' => 'required|digits:1',
        ]);

        if (strlen($pin) !== 5 || !ctype_digit($pin)) {
            session()->flash('error', 'PIN harus terdiri dari 5 angka!');
            $this->reset('pinArray');
            return;
        }

        // Cari user berdasarkan ID atau field unik lain, lalu cek PIN-nya
        $user = User::where('id', Auth::id())->first(); // Sesuaikan dengan cara mendapatkan user

        if ($user && Hash::check($pin, $user->pin)) {
            Auth::login($user);
            session()->regenerate();
            $this->alert('success', 'Berhasil Login');
            return redirect('/create_chat'); // Sesuaikan dengan route yang diinginkan
        }

        $this->alert('error', 'PIN yang Anda masukkan salah!');
        $this->reset('pinArray');
    }

    public function render()
    {
        return view('livewire.user.lock.lock')
            ->extends('layouts.app')
            ->section('content');
    }
}
