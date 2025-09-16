@extends('layouts.master-public')

@section('title', 'Organigrama del Ayuntamiento')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-[#00713D] mb-12 text-center">Organigrama del Ayuntamiento</h1>

    @php
    $equipo = [
        [
            'nombre' => 'Juan Rodríguez',
            'cargo' => 'Presidente Municipal',
            'area' => 'Gobierno',
            'email' => 'juan@ayuntamiento.mx',
            'hijos' => [
                [
                    'nombre' => 'María López',
                    'cargo' => 'Regidora',
                    'area' => 'Educación',
                    'email' => 'maria@ayuntamiento.mx',
                    'hijos' => [
                        [
                            'nombre' => 'Carlos Sánchez',
                            'cargo' => 'Director de Recursos Humanos',
                            'area' => 'Personal',
                            'email' => 'carlos@ayuntamiento.mx',
                            'hijos' => [
                                [
                                    'nombre' => 'Ana Pérez',
                                    'cargo' => 'Jefe de Área',
                                    'area' => 'Infraestructura',
                                    'email' => 'ana@ayuntamiento.mx',
                                ],
                                [
                                    'nombre' => 'Luis Gómez',
                                    'cargo' => 'Ayudante',
                                    'area' => 'Infraestructura',
                                    'email' => 'luis@ayuntamiento.mx',
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'nombre' => 'Roberto Díaz',
                    'cargo' => 'Regidor',
                    'area' => 'Seguridad',
                    'email' => 'roberto@ayuntamiento.mx',
                ]
            ]
        ]
    ];
    @endphp

    <div class="flex justify-center">
        <ul class="relative pl-0">
            @foreach($equipo as $nodo)
                <x-nodo :nodo="$nodo" />
            @endforeach
        </ul>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
