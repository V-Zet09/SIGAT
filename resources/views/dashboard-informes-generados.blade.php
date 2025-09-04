@extends('layouts.master')

@section('title', 'Informes Generados')

@section('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header text-center">
        <div class="container">
            <h1><i class="fas fa-landmark me-2"></i>Informes de Gobierno</h1>
            <p class="lead">Gestión de informes gubernamentales y reportes institucionales</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="filter-buttons">
                <button class="btn btn-outline-primary active">Todos</button>
                <button class="btn btn-outline-primary">Trimestrales</button>
                <button class="btn btn-outline-primary">Anuales</button>
                <button class="btn btn-outline-primary">Especiales</button>
                <button class="btn btn-outline-primary">En revisión</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" placeholder="Buscar informes...">
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>15</h3>
                        <p class="text-muted mb-0">Informes Publicados</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>3</h3>
                        <p class="text-muted mb-0">En Elaboración</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>124</h3>
                        <p class="text-muted mb-0">Descargas</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-download"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>92%</h3>
                        <p class="text-muted mb-0">Completados</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de informes -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Título del Informe</th>
                        <th>Período</th>
                        <th>Área</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Informe de Gestión Gubernamental</td>
                        <td>Enero - Marzo 2023</td>
                        <td>Gobierno</td>
                        <td>15/04/2023</td>
                        <td><span class="badge bg-success">Publicado</span></td>
                        <td>
                            <div class="d-flex actions">
                                <button class="btn btn-sm btn-action btn-info me-1">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <button class="btn btn-sm btn-action btn-primary me-1">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-action btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Balance Anual de Gestión</td>
                        <td>2022</td>
                        <td>Administración</td>
                        <td>31/01/2023</td>
                        <td><span class="badge bg-success">Publicado</span></td>
                        <td>
                            <div class="d-flex actions">
                                <button class="btn btn-sm btn-action btn-info me-1">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <button class="btn btn-sm btn-action btn-primary me-1">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-action btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Informe de Transparencia</td>
                        <td>Julio - Septiembre 2023</td>
                        <td>Transparencia</td>
                        <td>05/10/2023</td>
                        <td><span class="badge bg-warning text-dark">En revisión</span></td>
                        <td>
                            <div class="d-flex actions">
                                <button class="btn btn-sm btn-action btn-info me-1">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <button class="btn btn-sm btn-action btn-primary me-1">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-action btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Reporte de Obras Públicas</td>
                        <td>Abril - Junio 2023</td>
                        <td>Infraestructura</td>
                        <td>10/07/2023</td>
                        <td><span class="badge bg-success">Publicado</span></td>
                        <td>
                            <div class="d-flex actions">
                                <button class="btn btn-sm btn-action btn-info me-1">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <button class="btn btn-sm btn-action btn-primary me-1">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-action btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Anterior</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Siguiente</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Funcionalidad básica para los botones de acción
    document.querySelectorAll('.btn-action').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.querySelector('i').className;
            if (action.includes('eye')) {
                alert('Función: Ver informe');
            } else if (action.includes('edit')) {
                alert('Función: Editar informe');
            } else if (action.includes('trash')) {
                if (confirm('¿Está seguro de que desea eliminar este informe?')) {
                    alert('Informe eliminado (simulación)');
                }
            }
        });
    });

    // Funcionalidad para los filtros
    document.querySelectorAll('.filter-buttons .btn').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.filter-buttons .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            alert('Filtro aplicado: ' + this.textContent);
        });
    });
</script>
@endsection
