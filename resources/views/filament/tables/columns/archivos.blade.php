<div>
    @if (empty($state))
        Sin archivos
    @else
        @foreach ($state as $archivo)
            <a
                href="#"
                wire:click.prevent="$dispatch('openModal', { component: 'view_pdf', arguments: { ruta: '{{ $archivo->ruta }}' } })"
                class="text-blue-500 hover:underline">
                {{ $archivo->nombre_archivo }}
            </a><br>
        @endforeach
    @endif
</div>