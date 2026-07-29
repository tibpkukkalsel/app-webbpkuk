<?php

namespace App\Livewire\Admin\Video;

use App\Models\Kategori;
use App\Services\VideoService;
use Livewire\Component;

class Create extends Component
{
    protected VideoService $videoService;

    public $videoId = null;
    public $judul = '';
    public $url_youtube = '';
    public $youtube_id = '';
    public $ringkasan = '';
    public $status = '0';
    public $id_kategori = '';

    public $lastSavedAt = '';
    public $isDirty = false;

    protected $listeners = [
        'auto-save' => 'autoSave'
    ];

    public function boot(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    protected function rules()
    {
        return [
            'judul' => 'required|min:3|max:255',
            'url_youtube' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'status' => 'required',
            'ringkasan' => 'nullable|max:1000',
        ];
    }

    protected function messages()
    {
        return [
            'judul.required' => 'Judul video wajib diisi.',
            'url_youtube.required' => 'URL YouTube wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }

    public function updated($propertyName)
    {
        $this->isDirty = true;

        if ($propertyName === 'url_youtube') {
            $this->youtube_id = $this->videoService->buatYoutubeId($this->url_youtube);
        }
    }

    protected function saveDraft()
    {
        if (blank($this->judul) || blank($this->id_kategori) || blank($this->url_youtube)) {
            return false;
        }

        $this->youtube_id = $this->videoService->buatYoutubeId($this->url_youtube);
        if (!$this->youtube_id) {
            return false;
        }

        $video = $this->videoService->saveDraft(
            $this->videoId,
            [
                'judul' => $this->judul,
                'url_youtube' => $this->url_youtube,
                'ringkasan' => $this->ringkasan,
                'id_kategori' => $this->id_kategori,
                'status' => $this->status
            ]
        );

        $this->videoId = $video->id_video;
        $this->youtube_id = $video->youtube_id;

        return true;
    }

    public function autoSave()
    {
        if (!$this->isDirty) {
            return;
        }

        if (!$this->saveDraft()) {
            return;
        }

        $this->isDirty = false;
        $this->lastSavedAt = now()->format('H:i:s');
    }

    public function simpanDraftManual()
    {
        if (!$this->saveDraft()) {
            $this->dispatch('swal',
                icon: 'warning',
                title: 'Perhatian',
                text: 'Lengkapi Judul, Kategori, dan URL YouTube yang valid.'
            );
            return;
        }

        $this->isDirty = false;
        $this->lastSavedAt = now()->format('H:i:s');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Draft video berhasil disimpan.'
        );
    }

    public function simpan()
    {
        $this->validate();

        $youtubeId = $this->videoService->buatYoutubeId($this->url_youtube);
        if (!$youtubeId) {
            $this->addError('url_youtube', 'URL YouTube tidak valid.');
            return;
        }

        if (!$this->saveDraft()) {
            $this->dispatch('swal',
                icon: 'warning',
                title: 'Perhatian',
                text: 'Lengkapi data video dengan benar.'
            );
            return;
        }

        $this->videoService->publish($this->videoId, $this->status);

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Video berhasil disimpan.'
        );

        $this->dispatch('simpan-berhasil');
    }

    public function render()
    {
        return view('livewire.admin.video.create', [
            'kategori' => Kategori::orderBy('kategori')->get()
        ]);
    }
}
