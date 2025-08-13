@extends('layouts.master')

@section('title', 'Detalle de Actividad')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle de Actividad</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Título:</strong> {{ $actividad->titulo }}</p>
            <p><strong>Autor:</strong> {{ $actividad->autor ?? 'Anónimo' }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</p>
            <p><strong>Área:</strong> {{ $actividad->area }}</p>
            <p><strong>Tipo de Actividad:</strong> {{ $actividad->tipo_actividad }}</p>
            <p><strong>Resumen:</strong> {{ $actividad->resumen }}</p>
            <p><strong>Contenido:</strong> {!! nl2br(e($actividad->contenido)) !!}</p>
            <p><strong>Presupuesto:</strong> ${{ number_format($actividad->presupuesto, 2) }}</p>
            <p><strong>Tipo de Presupuesto:</strong> {{ $actividad->tipo_presupuesto }}</p>
            <p><strong>Municipio:</strong> {{ $actividad->municipio }}</p>
            <p><strong>Archivo:</strong>
                @if($actividad->archivo)
                    <a href="{{ asset('storage/' . $actividad->archivo) }}" target="_blank">Ver archivo</a>
                @else
                    No adjunto
                @endif
            </p>
            <a href="{{ route('actividades.registradas') }}" class="btn btn-secondary mt-3">← Volver</a>
        </div>
    </div>
</div>
@endsection
