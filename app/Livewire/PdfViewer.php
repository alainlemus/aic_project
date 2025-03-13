<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PdfViewer extends Component
{
    public $archivos = [];
    public $selectedUrl = '';

    protected $listeners = ['archivoSeleccionado' => 'selectArchivo'];

    public function mount($archivos = [])
    {
        $this->archivos = $archivos ?? [];
        $this->selectedUrl = count($this->archivos) > 0 ? $this->archivos[0]['url'] : '';
    }

    public function selectArchivo($url)
    {
        $this->selectedUrl = $url;
    }

    public function render()
    {
        return view('livewire.pdf-viewer', [
            'selectedUrl' => $this->selectedUrl
        ]);
    }
}
