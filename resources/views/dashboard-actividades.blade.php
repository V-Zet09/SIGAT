@extends('layouts.master')

@section('title', 'Actividades')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css') }}">
@endsection

@section('content')
@php
    $hoy = date('Y-m-d');
@endphp

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Registrar Nueva Actividad</h4>
        </div>
        <div class="card-body">
            {{-- Alerta visual para fecha inválida --}}
            <div id="alerta-fecha" class="alert alert-warning d-none" role="alert">
                ⚠️ No puedes registrar una actividad con fecha futura.
            </div>

            <form action="{{ route('actividades.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" name="autor" id="autor" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" max="{{ $hoy }}" required>
                </div>

                <div class="mb-3">
                    <label for="tipo_area" class="form-label">Área</label>
                    <select name="tipo_area" id="tipo_area" class="form-select">
                        <option value="Agua potable">Agua potable</option>
                        <option value="Bienestar Social y Desarrollo Rural">Bienestar Social y Desarrollo Rural</option>
                        <option value="Catastro">Catastro</option>
                        <option value="Contraloria Interna">Contraloria Interna</option>
                        <option value="Deportes">Deportes</option>
                        <option value="DIF">DIF</option>
                        <option value="Informática">Informática</option>
                        <option value="Limpia">Limpia</option>
                        <option value="Obras Publicas">Obras Publicas</option>
                        <option value="Oficialia Mayor">Oficialia Mayor</option>
                        <option value="Presidencia">Presidencia</option>
                        <option value="Recursos Humanos">Recursos Humanos</option>
                        <option value="Registro Civil">Registro Civil</option>
                        <option value="Regidores">Regidores</option>
                        <option value="Reglamentos">Reglamentos</option>
                        <option value="Secretaria General">Secretaria General</option>
                        <option value="Seguridad Publica">Seguridad Publica</option>
                        <option value="Sindicatura">Sindicatura</option>
                        <option value="Tesoreria">Tesoreria</option>
                        <option value="Transito">Transito</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="resumen" class="form-label">Resumen</label>
                    <textarea name="resumen" id="resumen" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea name="contenido" id="contenido" class="form-control" rows="5"></textarea>
                </div>

                <div class="mb-3">
                    <label for="presupuesto" class="form-label">Presupuesto</label>
                    <input type="number" name="presupuesto" id="presupuesto" class="form-control" step="0.01">
                </div>

                <div class="mb-3">
                    <label for="tipo_presupuesto" class="form-label">Tipo de Presupuesto</label>
                    <select name="tipo_presupuesto" id="tipo_presupuesto" class="form-select">
                        <option value="Municipal">Municipal</option>
                        <option value="Estatal">Estatal</option>
                        <option value="Federal">Federal</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaInput = document.getElementById('fecha');
        const alerta = document.getElementById('alerta-fecha');

        fechaInput.addEventListener('input', function () {
            const valor = this.value;
            const fechaIngresada = new Date(valor);
            const hoy = new Date();

            fechaIngresada.setHours(0, 0, 0, 0);
            hoy.setHours(0, 0, 0, 0);

            if (fechaIngresada > hoy) {
                alerta.classList.remove('d-none');
                this.value = '';
            } else {
                alerta.classList.add('d-none');
            }
        });
    });
</script>
@endsection