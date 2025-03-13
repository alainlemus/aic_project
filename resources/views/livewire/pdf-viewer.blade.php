<div>
    <div class="mb-4">
        @forelse ($archivos as $archivo)
            <button wire:click="selectArchivo('{{ $archivo['url'] }}')"
                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mb-1 block">
                {{ $archivo['nombre'] }}
            </button>
        @empty
            <p>No hay archivos disponibles.</p>
        @endforelse
    </div>

    {{-- Depuración para ver si selectedUrl está llegando --}}
    <pre>{{ print_r($selectedUrl, true) }}</pre>

    @if (!empty($selectedUrl))
        <iframe
            src="{{ asset($selectedUrl) }}"
            width="100%"
            height="600px"
            style="border: none;"
            title="Visor de PDF">
        </iframe>
    @else
        <p>No hay archivo seleccionado.</p>
    @endif
</div>
