<div>
    @foreach ($archivos as $archivo)
        <p>{{ $archivo->nombre }}</p>
    @endforeach
    {{ $archivos[0]->url }}
    <iframe
        src="{{ asset($archivos[0]->url ?? '') }}"
        width="100%"
        height="600px"
        style="border: none;"
        title="Visor de PDF">
    </iframe>
</div>