@extends('layouts.master')
@section('title', 'Ver Usuario')

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Usuarios @endslot
    @slot('title') Ver usuario @endslot
@endcomponent

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Información del Usuario</h5>
    </div>
    <div class="card-body">
        <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
        <p><strong>Sexo:</strong> {{ $usuario->sexo }}</p>
        <p><strong>Cargo:</strong> {{ $usuario->cargo }}</p>
        <p><strong>Área:</strong> {{ $usuario->area }}</p>
        <p><strong>Email:</strong> {{ $usuario->email }}</p>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
