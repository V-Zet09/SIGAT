
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.leads'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            CRM
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Usuarios
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

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
                                <button type="button" class="btn btn-info" data-bs-toggle="offcanvas"
                                    href="#offcanvasExample"><i
                                        class="ri-filter-3-line align-bottom me-1"></i> Flitro</button>
                                <button type="button" class="btn btn-success add-btn"
                                    data-bs-toggle="modal" id="create-btn"
                                    data-bs-target="#showModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Agregar Usuario</button>
                                <span class="dropdown">
                                    <button class="btn btn-soft-info btn-icon fs-14" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ri-settings-4-line"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="checkAll" value="option">
                                            </div>
                                        </th>

                                        <th class="sort" data-sort="name">Nombre</th>
                                        <th class="sort" data-sort="sexo">Sexo</th>
                                        <th class="sort" data-sort="cargo">Cargo</th>
                                        <th class="sort" data-sort="area">Área</th>
                                        <th class="sort" data-sort="email">Correo electrónico</th>
                                        <th class="sort" data-sort="action">Acciones</th>
                                    </tr>
                                </thead>
<?php
    if (!isset($usuarios)) {
        $usuarios = \App\Models\User::all();
    }
?>

                                <tbody class="list form-check-all">
                                    <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child" value="<?php echo e($usuario->id); ?>">
                                                </div>
                                            </th>

                                            <td class="name"><?php echo e($usuario->name); ?></td>
                                            <td class="sexo"><?php echo e($usuario->sexo); ?></td>
                                            <td class="cargo"><?php echo e($usuario->cargo); ?></td>
                                            <td class="area"><?php echo e($usuario->area); ?></td>
                                            <td class="email"><?php echo e($usuario->email); ?></td>
                                            
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <!-- Ver -->
                                                    <li class="list-inline-item" title="Ver">
                                                        <a href="<?php echo e(route('vista-ver-usuarios', $usuario->id)); ?>" class="btn btn-sm btn-info">
                                                            <i class="ri-eye-fill"></i>
                                                        </a>
                                                    </li>
                                                    <!-- Editar -->
                                                    <li class="list-inline-item" title="Editar">
                                                        <a href="<?php echo e(route('vista-editar-usuario', $usuario->id)); ?>" class="btn btn-sm btn-warning">
                                                            <i class="ri-pencil-fill"></i>
                                                        </a>
                                                    </li>

                                                    <!-- Eliminar -->
                                                    <li class="list-inline-item" title="Eliminar">
                                                        <form action="<?php echo e(route('usuarios.destroy', $usuario->id)); ?>" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="ri-delete-bin-fill"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>

                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No hay usuarios registrados</td>
                                        </tr>
                                    <?php endif; ?>
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
                                                                <img src="<?php echo e(URL::asset('build/images/users/user-dummy-img.jpg')); ?>"
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


                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                        aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header bg-light">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Leads Fliters</h5>
                            <button type="button" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <!--end offcanvas-header-->
                        <form action="" class="d-flex flex-column justify-content-end h-100">
                            <div class="offcanvas-body">
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Date</label>
                                    <input type="date" class="form-control" id="datepicker-range"
                                        data-provider="flatpickr" data-range="true"
                                        placeholder="Select date">
                                </div>
                                <div class="mb-4">
                                    <label for="country-select"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Country</label>
                                    <select class="form-control" data-choices
                                        data-choices-multiple-remove="true" name="country-select"
                                        id="country-select" multiple>
                                        <option value="">Select country</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Brazil" selected>Brazil</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="France">France</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Syria">Syria</option>
                                        <option value="United Kingdom" selected>United Kingdom</option>
                                        <option value="United States of America">United States of
                                            America</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="status-select"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Status</label>
                                    <div class="row g-2">
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="inlineCheckbox1" value="option1">
                                                <label class="form-check-label"
                                                    for="inlineCheckbox1">New Leads</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="inlineCheckbox2" value="option2">
                                                <label class="form-check-label"
                                                    for="inlineCheckbox2">Old Leads</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="inlineCheckbox3" value="option3">
                                                <label class="form-check-label"
                                                    for="inlineCheckbox3">Loss Leads</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="inlineCheckbox4" value="option4">
                                                <label class="form-check-label"
                                                    for="inlineCheckbox4">Follow Up</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="leadscore"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Lead
                                        Score</label>
                                    <div class="row g-2 align-items-center">
                                        <div class="col-lg">
                                            <input type="number" class="form-control" id="leadscore"
                                                placeholder="0">
                                        </div>
                                        <div class="col-lg-auto">
                                            To
                                        </div>
                                        <div class="col-lg">
                                            <input type="number" class="form-control" id="leadscore"
                                                placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="leads-tags"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Tags</label>
                                    <div class="row g-3">
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="marketing" value="marketing">
                                                <label class="form-check-label"
                                                    for="marketing">Marketing</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="management" value="management">
                                                <label class="form-check-label"
                                                    for="management">Management</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="business" value="business">
                                                <label class="form-check-label"
                                                    for="business">Business</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="investing" value="investing">
                                                <label class="form-check-label"
                                                    for="investing">Investing</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="partner" value="partner">
                                                <label class="form-check-label"
                                                    for="partner">Partner</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="lead" value="lead">
                                                <label class="form-check-label" for="lead">Leads</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="sale" value="sale">
                                                <label class="form-check-label" for="sale">Sale</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="owner" value="owner">
                                                <label class="form-check-label"
                                                    for="owner">Owner</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="banking" value="banking">
                                                <label class="form-check-label"
                                                    for="banking">Banking</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="banking" value="banking">
                                                <label class="form-check-label"
                                                    for="banking">Exiting</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="banking" value="banking">
                                                <label class="form-check-label"
                                                    for="banking">Finance</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="banking" value="banking">
                                                <label class="form-check-label"
                                                    for="banking">Fashion</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end offcanvas-body-->
                            <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                                <button class="btn btn-light w-100">Clear Filter</button>
                                <button type="submit" class="btn btn-success w-100">Filters</button>
                            </div>
                            <!--end offcanvas-footer-->
                        </form>
                    </div>
                    <!--end offcanvas-->

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/list.js/list.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/crm-leads.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Maria\Documents\GitHub\SIGAT\resources\views/dashboard-users.blade.php ENDPATH**/ ?>