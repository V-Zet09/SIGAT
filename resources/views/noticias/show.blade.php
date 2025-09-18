@extends('layouts.master-public')

@section('title', $noticia->titulo)

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    {{-- Componente de noticia --}}
    <x-noticia-card 
        :imagen="$noticia->imagen"
        :fecha="$noticia->fecha"
        :titulo="$noticia->titulo"
        :url="route('noticias.show', $noticia->id)"
    />

    {{-- Contenido completo de la noticia --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
        <div class="p-6">
            <p class="text-gray-500 text-sm mb-2">
                {{ \Carbon\Carbon::parse($noticia->fecha)->format('d/m/Y') }}
            </p>
            <h1 class="text-2xl font-bold text-[#00713D] mb-4">
                {{ $noticia->titulo }}
            </h1>
            <div class="prose max-w-4xl mx-auto py-6">
                <p class="text-justify">
                    {!! nl2br(e($noticia->contenido)) !!}
                </p>
            </div> {{-- Cierre del div prose --}}
        </div> {{-- Cierre del div p-6 --}}
    </div> {{-- Cierre del div bg-white --}}

    {{-- Botón volver al inicio --}}
    <div class="mt-6">
        <a href="{{ url('/') }}" 
           class="inline-block bg-[#00713D] hover:bg-[#005c30] text-white font-semibold px-5 py-2 rounded-full transition">
            ← Volver al inicio
        </a>
    </div>
</div>
@endsection

