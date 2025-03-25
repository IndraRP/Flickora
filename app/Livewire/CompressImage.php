<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Livewire\Component;

class CompressImage extends Component
{
    public $images = [];
    public $files = [];


    public function mount()
    {
        $this->images = Storage::disk('public')->allFiles('highlight');
        // dd($this->images);
        // dd(Storage::disk('local')->allFiles('public/bukti_banding'));
        // dd(Storage::disk('public')->allFiles('bukti_banding'));
    }


    public function compress($filename)
    {
        $this->processImage($filename);
        session()->flash('message', 'Gambar berhasil dikompres!');
        $this->mount(); // Refresh daftar gambar
    }

    public function compressAll()
    {
        if (empty($this->images)) {
            session()->flash('error', 'Tidak ada gambar untuk dikompres.');
            return;
        }

        foreach ($this->files as $file) {
            $this->processFile($file);
        }

        session()->flash('message', 'Semua gambar berhasil dikompres!');

        $this->mount(); // Refresh daftar gambar
        // dd($this->images); // Lihat apakah gambar masih ada
    }

    private function processImage($filename)
    {
        $path = Storage::disk('public')->path($filename);

        if (file_exists($path)) {
            // Inisialisasi ImageManager dengan driver GD
            $manager = new ImageManager(new Driver());

            // Baca gambar dari path
            $image = $manager->read($path);

            // Gunakan encoder yang sesuai
            $image = $image->encode(new JpegEncoder(quality: 70));

            // Simpan kembali ke path yang sama
            $image->save($path);
        }
    }

    private function processFile($filename)
    {
        $path = Storage::disk('public')->path($filename);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            return $this->compressImage($path);
        } elseif (in_array($ext, ['mp4', 'mkv', 'avi', 'mov'])) {
            return $this->compressVideo($path);
        } elseif ($ext === 'pdf') {
            return $this->compressPDF($path);
        }

        return false; // Format tidak didukung
    }

    private function compressImage($path)
    {
        if (!file_exists($path)) {
            return false;
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($path)->encode(new JpegEncoder(quality: 70));
        $image->save($path);

        return true;
    }

    private function compressVideo($path)
    {
        if (!file_exists($path)) {
            return false;
        }

        $compressedPath = str_replace('.mp4', '_compressed.mp4', $path);
        shell_exec("ffmpeg -i $path -vcodec libx265 -crf 28 $compressedPath");

        return file_exists($compressedPath);
    }

    private function compressPDF($path)
    {
        if (!file_exists($path)) {
            return false;
        }

        $compressedPath = str_replace('.pdf', '_compressed.pdf', $path);
        shell_exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dNOPAUSE -dQUIET -dBATCH -sOutputFile=$compressedPath $path");

        return file_exists($compressedPath);
    }



    public function render()
    {
        return view('livewire.compress-image')
            ->extends('layouts.app')
            ->section('content');
    }
}
