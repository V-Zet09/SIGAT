@extends('layouts.master-public')

@section('title', 'Todos los comunicados')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-[#00713D] mb-8">Todos los comunicados</h1>

    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($noticias as $noticia)
        <x-noticia-card 
            :imagen="$noticia->imagen"
            :fecha="$noticia->fecha"
            :titulo="$noticia->titulo"
            :url="route('noticias.show', $noticia->id)"
        />
        @endforeach
    </div>

    <div class="mt-8">
        {{ $noticias->links() }} <!-- Paginación automática -->
    </div>
</div>
@endsection
