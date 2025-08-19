@extends('layouts.master')
@section('title') Nuevo Usuario @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Usuarios @endslot
@slot('title') Crear usuario @endslot
@endcomponent
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- Aquí ponemos la ruta para guardar y método POST -->
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="card-header">
                    <h5 class="card-title mb-0">Crear usuario</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">

                        <div class="col-lg-8">
                            <label for="nombre" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="nombre" class="form-control" placeholder="Escriba su nombre" required>
                        </div>

                        <div class="col-lg-4">
                            <label for="sexo" class="form-label">Sexo <span class="text-danger">*</span></label>
                            <input type="text" name="sexo" id="sexo" class="form-control" placeholder="Escriba su sexo" required>
                        </div>

                        <div class="col-lg-6">
                            <label for="cargo" class="form-label">Cargo a desempeñar <span class="text-danger">*</span></label>
                            <select name="cargo" id="cargo" class="form-control" required>
                                <option value="">Seleccionar cargo</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Presidente">Presidente municipal</option>
                                <option value="Síndico">Síndico procurador</option>
                                <option value="Regidor">Regidor</option>
                                <option value="Director">Director de área</option>
                                <option value="Auxiliar">Auxiliar de área</option>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="area" class="form-label">Área <span class="text-danger">*</span></label>
                            <select name="area" id="area" class="form-control" required>
                                <option value="">Seleccionar área correspondiente</option>
                                <option value="Presidencia">Presidencia</option>
                                <option value="Agua potable">Agua potable</option>
                                <option value="Informática">Informática</option>
                                <option value="Obras públicas">Obras públicas</option>
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label for="email" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Escriba su correo" required>
                        </div>

                        <div class="col-lg-6">
                            <div class="position-relative">
                                <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                                <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                                   style="cursor:pointer;"
                                   onclick="togglePassword('password', this)">
                                </i>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="position-relative">
                                <label for="password_confirmation" class="form-label">Confirmar contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirma tu contraseña" required>
                                <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                                   style="cursor:pointer;"
                                   onclick="togglePassword('password_confirmation', this)">
                                </i>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="hstack justify-content-end gap-2">
                                <a href="{{ route('usuarios.index') }}" class="btn btn-ghost-danger material-shadow-none">
                                    <i class="ri-close-line align-bottom"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{URL::asset('build/js/app.js')}}"></script>
<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}
</script>
@endsection
