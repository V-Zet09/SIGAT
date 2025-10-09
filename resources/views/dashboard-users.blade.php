@extends('layouts.master')
@section('title')
    @lang('translation.leads')
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

@endsection
@section('css')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            CRM
        @endslot
        @slot('title')
            Usuarios
        @endslot
    @endcomponent


<div class="row">
<div class="col-lg-12">
        {{-- Header Usuarios --}}
     <div class="px-6 mt-3 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 tracking-tight">👤 Registro General de Usuarios</h1>
            <p class="text-gray-500">Usuarios registrados en el sistema</p>
        </div>
    </div>
        {{-- Fin Header --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="leadsList">
                <div class="card-header border-0">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm-3">
                            <div class="search-box">
                                <input type="text" class="form-control search"
                                    placeholder="Buscar por...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                <button type="button" class="btn btn-info" i
                                        class="ri-filter-3-line align-bottom me-1"></i> Flitro</button>

                                    <a href="{{ route('dashboard-crear-usuario') }}" class="btn btn-success">
                                        <i class="ri-add-line align-bottom me-1"></i> Agregar Usuario
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-400 dark:text-gray-600" id="customerTable">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-green-800 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 w-12">
                                            <input id="checkAll" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                    focus:ring-blue-500 dark:focus:ring-blue-600 
                                                    dark:ring-offset-gray-800 focus:ring-2 
                                                    dark:bg-gray-700 dark:border-gray-600">
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Nombre
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Sexo
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Cargo
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Área
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Correo electrónico
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
@php
    if (!isset($usuarios)) {
        $usuarios = \App\Models\User::all();
    }
@endphp

                                <tbody 
                                    @forelse ($usuarios as $usuario)
                                        <tr class="bg-white border-b dark:bg-gray-600 dark:border-gray-400 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4">
                                                <input type="checkbox" name="chk_child" value="{{ $usuario->id }}"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                        focus:ring-blue-500 dark:focus:ring-blue-600 
                                                        dark:ring-offset-gray-800 focus:ring-2 
                                                        dark:bg-gray-700 dark:border-gray-600">
                                            </td>
                                            <td class="px-1 py-2">
                                                {{ $usuario->name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $usuario->sexo }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $usuario->cargo }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $usuario->area }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $usuario->email }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="relative inline-block text-left">
                                                    <!-- Botón del menú -->
                                                    <button type="button" 
                                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1 bg-blue text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-green-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600"
                                                        data-dropdown-button>
                                                        Opciones
                                                        <!-- Icono de flechita -->
                                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" 
                                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>

                                                    <!-- Menú desplegable -->
                                                    <div class="hidden origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 dark:bg-gray-700 z-10"
                                                        data-dropdown-menu>
                                                        <div class="py-1">
                                                            <!-- Ver -->
                                                            <a href="{{ route('vista-ver-usuarios', $usuario->id) }}" 
                                                            class="block px-4 py-2 text-sm text-green-800 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-green-800">
                                                            👁 Ver
                                                            </a>
                                                            <!-- Editar -->
                                                            <a href="{{ route('vista-editar-usuario', ['id' => $usuario->id]) }}" 
                                                            class="block px-4 py-2 text-sm text-yellow-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-yellow-700">
                                                            ✏️ Editar
                                                            </a>
                                                            <!-- Eliminar -->
                                                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-700">
                                                                    🗑 Eliminar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>



                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No hay usuarios registrados</td>
                                        </tr>
                                    @endforelse
                                    <script>
                                        document.addEventListener('DOMContentLoaded', () => {
                                            document.querySelectorAll('[data-dropdown-button]').forEach(button => {
                                                button.addEventListener('click', () => {
                                                    const menu = button.nextElementSibling;
                                                    menu.classList.toggle('hidden');
                                                });
                                            });

                                            // Cierra el menú si haces click fuera
                                            window.addEventListener('click', (e) => {
                                                document.querySelectorAll('[data-dropdown-menu]').forEach(menu => {
                                                    if (!menu.previousElementSibling.contains(e.target) && !menu.contains(e.target)) {
                                                        menu.classList.add('hidden');
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                </tbody>

                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                        trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ leads We
                                        did not find any
                                        leads for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Anterior
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Siguiente
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="showModal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close" id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field" />
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <div class="position-relative d-inline-block">
                                                        <div class="position-absolute bottom-0 end-0">
                                                            <label for="lead-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                                                <div class="avatar-xs cursor-pointer">
                                                                    <div class="avatar-title bg-light border rounded-circle text-muted">
                                                                        <i class="ri-image-fill"></i>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <input class="form-control d-none" value="" id="lead-image-input" type="file"
                                                                accept="image/png, image/gif, image/jpeg">
                                                        </div>
                                                        <div class="avatar-lg p-1">
                                                            <div class="avatar-title bg-light rounded-circle">
                                                                <img src="{{ URL::asset('build/images/users/user-dummy-img.jpg') }}"
                                                        alt="" id="lead-img" class="avatar-md rounded-circle object-fit-cover" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-13 mt-3">Cargar imagen</h5>
                                                </div>
                                                <div>
                                                    <label for="leadname-field"
                                                        class="form-label">Nombre completo</label>
                                                    <input type="text" id="leadname-field"
                                                        class="form-control" placeholder="Enter Name"
                                                        required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="company_name-field"
                                                        class="form-label">Cargo</label>
                                                    <input type="text" id="company_name-field"
                                                        class="form-control"
                                                        placeholder="Enter company name" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="leads_score-field" class="form-label">Área</label>
                                                    <input type="text" id="leads_score-field"
                                                        class="form-control"
                                                        placeholder="Enter company name" required />
                                                </div>
                                            </div>
                                            <!--end col-->                                           
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="phone-field"
                                                        class="form-label">Teléfono</label>
                                                    <input type="text" id="phone-field"
                                                        class="form-control"
                                                        placeholder="Enter phone no" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="gender-field"
                                                        class="form-label">Sexo</label>
                                                    <input type="text" id="gender-field"
                                                        class="form-control"
                                                        placeholder="Escriba su sexo" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="email_id-field"
                                                        class="form-label">Correo electrónico</label>
                                                    <input type="text" id="email_id-field"
                                                        class="form-control"
                                                        placeholder="Escriba su correo" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="password-field"
                                                        class="form-label">Contraseña</label>
                                                    <input type="text" id="password-field"
                                                        class="form-control"
                                                        placeholder="Escriba su contraseña" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="password-field"
                                                        class="form-label">Confirmar contraseña</label>
                                                    <input type="text" id="password-field"
                                                        class="form-control"
                                                        placeholder="Escriba su contraseña nuevamente" required />
                                                </div>
                                            </div>
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success"
                                                id="add-btn">Agregar usuario</button>
                                            {{-- <button type="button" class="btn btn-success"
                                                id="edit-btn">Update</button> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->

                    <!-- Modal -->
                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                        aria-labelledby="deleteRecordLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close" id="btn-close"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                        trigger="loop" colors="primary:#405189,secondary:#f06548"
                                        style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4 class="fs-semibold">¿Desea eliminar el usuario seleccionado?</h4>
                                        <p class="text-muted fs-14 mb-4 pt-1">Al eliminar el usuario, se borrará su información registrada en la base de datos.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button
                                                class="btn btn-link link-success fw-medium text-decoration-none material-shadow-none"
                                                data-bs-dismiss="modal" id="deleteRecord-close"><i
                                                    class="ri-close-line me-1 align-middle"></i>
                                                Cancelar</button>
                                            <button class="btn btn-danger" id="delete-record">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/crm-leads.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
