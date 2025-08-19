@extends('layouts.master')
@section('title', 'Editar Usuario')

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Usuarios @endslot
    @slot('title') Editar usuario @endslot
@endcomponent

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Editar Usuario</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" required>
            </div>

            <div class="mb-3">
                <label for="sexo">Sexo</label>
                <input type="text" name="sexo" class="form-control" value="{{ $usuario->sexo }}" required>
            </div>

            <div class="mb-3">
                <label for="cargo">Cargo</label>
                <input type="text" name="cargo" class="form-control" value="{{ $usuario->cargo }}" required>
            </div>

            <div class="mb-3">
                <label for="area">Área</label>
                <input type="text" name="area" class="form-control" value="{{ $usuario->area }}" required>
            </div>

            <div class="mb-3">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
