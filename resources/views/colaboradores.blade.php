@extends('layouts.master')

@section('title', 'Colaboradores | SIGAT')

@section('content')
<div x-data="{ openModal: false, active: null }"
     class="min-h-screen bg-slate-50 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8">

    <div class="max-w-6xl mx-auto bg-white dark:bg-slate-800 rounded-[40px] p-8 shadow-2xl">

        {{-- Encabezado --}}
        <div class="mb-10 text-center">
            <p class="text-xs font-semibold tracking-[0.2em] uppercase text-emerald-500 dark:text-emerald-400">
                Equipo SIGAT
            </p>
            <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">
                Colaboradores del Sistema
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-sm sm:text-base text-slate-500 dark:text-slate-400">
                Presentación del equipo responsable del desarrollo, soporte y operación del SIGAT.
            </p>
        </div>

        {{-- Grid 2 x 2 --}}
        <div class="grid gap-8 md:grid-cols-2">

            @foreach($colaboradores as $colab)
            <article class="relative overflow-hidden rounded-3xl bg-slate-900 dark:bg-slate-700 border border-emerald-500/40 shadow-xl shadow-emerald-900/40 flex flex-col">
                
                {{-- 🟢 BADGE EN LÍNEA (esquina superior derecha) --}}
                @if($colab['online'])
                    <div class="absolute top-4 right-4 z-10">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500" title="En línea"></span>
                        </span>
                    </div>
                @else
                    <div class="absolute top-4 right-4 z-10">
                        <span class="inline-flex rounded-full h-3 w-3 bg-slate-500" title="Desconectado"></span>
                    </div>
                @endif

                <div class="px-6 pt-8 flex flex-col items-center text-center gap-4">
                    {{-- FOTO: abre modal --}}
                    <button
                        @click="active = {
                            name: '{{ $colab['name'] }}',
                            role: '{{ $colab['role'] }}',
                            img: '{{ asset($colab['img']) }}',
                            desc: '{{ $colab['desc'] }}'
                        }; openModal = true"
                        class="group relative w-28 h-28 rounded-full overflow-hidden ring-4 ring-emerald-500/80 ring-offset-4 ring-offset-slate-900 dark:ring-offset-slate-700 transition-transform duration-300 hover:scale-110 hover:ring-emerald-400">
                        <img src="{{ asset($colab['img']) }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                             alt="{{ $colab['name'] }}">
                    </button>
                    
                    <div>
                        <div class="flex items-center justify-center gap-2 mb-1">
                            <h2 class="text-lg font-semibold text-white">{{ $colab['name'] }}</h2>
                            
                            {{-- 🟢 Badge en línea junto al nombre --}}
                            @if($colab['online'])
                                <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/40">
                                    En línea
                                </span>
                            @endif
                        </div>
                        <p class="text-[12px] font-medium text-emerald-400 dark:text-emerald-300 uppercase tracking-[0.18em]">
                            {{ $colab['role'] }}
                        </p>
                    </div>
                </div>

                <p class="px-7 mt-4 mb-6 text-[13px] text-slate-300 dark:text-slate-200 leading-relaxed text-center">
                    {{ Str::limit($colab['desc'], 180) }}
                </p>

                <div class="px-6 pb-4 mt-auto flex flex-wrap justify-center gap-2">
                    @foreach($colab['skills'] as $skill)
                        <span class="px-3 py-1 rounded-full text-[11px] font-medium 
                            {{ $loop->index < 2 ? 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40' : 'bg-slate-800 dark:bg-slate-600 text-slate-200 border border-slate-700 dark:border-slate-500' }}">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>

                {{-- Contacto --}}
                <div class="px-6 pb-6 flex items-center justify-center gap-4 text-slate-400 dark:text-slate-300 text-lg">
                    <a href="mailto:{{ $colab['email'] }}"
                       class="hover:text-emerald-400 dark:hover:text-emerald-300 transition"
                       title="Contacto">
                        <i class="ri-mail-line"></i>
                    </a>
                    @if($colab['name'] == 'Mariana Lilibeth Antúnez García')
                        <a href="https://github.com/Antz06" target="_blank" class="hover:text-emerald-400 dark:hover:text-emerald-300 transition" title="GitHub">
                            <i class="ri-github-fill"></i>
                        </a>
                    @elseif($colab['name'] == 'José Ángel Alonso León')
                        <a href="https://github.com/JANGELL14" target="_blank" class="hover:text-emerald-400 dark:hover:text-emerald-300 transition" title="GitHub">
                            <i class="ri-github-fill"></i>
                        </a>
                        <a href="https://www.facebook.com/share/1Twc17HvNb/" target="_blank" class="hover:text-emerald-400 dark:hover:text-emerald-300 transition" title="Facebook">
                            <i class="ri-facebook-circle-fill"></i>
                        </a>
                    @elseif($colab['name'] == 'Maico Zaet Pérez Valencia')
                        <a href="https://github.com/V-Zet09" target="_blank" class="hover:text-emerald-400 dark:hover:text-emerald-300 transition" title="GitHub">
                            <i class="ri-github-fill"></i>
                        </a>
                        <a href="https://www.facebook.com/zaet.perez.2025?locale=es_LA" target="_blank" class="hover:text-emerald-400 dark:hover:text-emerald-300 transition" title="Facebook">
                            <i class="ri-facebook-circle-fill"></i>
                        </a>
                    @elseif($colab['name'] == 'Jorge Campos Albarado')
                        <a href="https://github.com/JorgeCA7" target="_blank" class="hover:text-emerald-400 dark:hover:text-emerald-300 transition" title="GitHub">
                            <i class="ri-github-fill"></i>
                        </a>
                        <a href="https://www.instagram.com/jorge_cmps_?igsh=cnB5eWp5aXgxbjB4" target="_blank" class="hover:text-emerald-400 dark:hover:text-emerald-300 transition" title="Instagram">
                            <i class="ri-instagram-line"></i>
                        </a>
                    @endif
                </div>
            </article>
            @endforeach

        </div>
    </div>

    {{-- Modal detalle colaborador --}}
    <div x-cloak x-show="openModal" x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div x-transition.scale
             class="relative w-full max-w-md mx-4 rounded-3xl bg-slate-900 dark:bg-slate-800 border border-emerald-500/50 shadow-2xl shadow-emerald-900/60 p-6">
            <button @click="openModal = false"
                    class="absolute top-3 right-3 text-slate-400 hover:text-white transition">
                <i class="ri-close-line text-xl"></i>
            </button>

            <div class="flex flex-col items-center text-center gap-4 mt-2">
                <div class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-emerald-500/80 ring-offset-4 ring-offset-slate-900 dark:ring-offset-slate-800">
                    <img :src="active?.img" class="w-full h-full object-cover" alt="Colaborador">
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-white" x-text="active?.name"></h2>
                    <p class="text-[12px] font-medium text-emerald-400 dark:text-emerald-300 uppercase tracking-[0.18em]" x-text="active?.role"></p>
                </div>

                <p class="text-sm text-slate-300 dark:text-slate-200 leading-relaxed" x-text="active?.desc"></p>
            </div>
        </div>
    </div>
</div>
@endsection
