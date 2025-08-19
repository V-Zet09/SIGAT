

<?php $__env->startSection('title', 'Generar Informe'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/informe.css')); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">



<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid informe-container">
    <!-- Notificación Toast -->
    <div id="toast" class="toast">Información guardada correctamente</div>
    
    <!-- Barra de pestañas -->
    <div class="tabs">
        <div class="tab active" data-tab="inicio">Inicio</div>
        <div class="tab" data-tab="informacion">Información Municipio</div>
        <div class="tab" data-tab="introduccion">Introducción</div>
        <div class="tab" data-tab="gobierno">Introducción Gobierno</div>
        <div class="tab" data-tab="actividades">Actividades</div>
    </div>

    <!-- Contenido de las pestañas -->
    <form id="informeForm" method="POST" action="<?php echo e(route('informes.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <!-- Sección Inicio -->
<div class="section active" id="inicio">
    <h2>Portada</h2>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Título del Informe</label>
            <input type="text" name="titulo" class="form-control" placeholder="Ingrese el título" required>
        </div>
        <div class="form-group col-md-6">
            <label>Período</label>
            <input type="text" id="periodo" name="periodo" 
                class="form-control flatpickr-input" 
                placeholder="Selecciona el período" required>
        </div>
    </div>

    <div class="comuna-section">
        <h2>INFORMACIÓN DE LA COMUNA</h2>
        
        <div class="authorities-grid">
            <div class="authority-card">
                <h3>Presidencia</h3>
                <p><strong>C. JOSÉ LUIS ANTÚNEZ GOICOCHEA</strong><br>Presidente Municipal Constitucional</p>
            </div>
            <div class="authority-card">
                <h3>Sindicato</h3>
                <p><strong>Profa. Maricela Cruz Cedillo</strong><br>Síndica Procuradora Municipal</p>
            </div>
            <div class="authority-card">
                <h3>Secretaría</h3>
                <p><strong>C. Profr. Mario Alberto Lagunas Salgado</strong><br>Secretario General del H. Ayuntamiento Municipal Constitucional</p>
            </div>
        </div>

        <h3>Regidores</h3>
        <div class="regidores-grid">
            <div class="regidor-column">
                <ul>
                    <li><strong>C. Zenón Huerta Arellano</strong>Desarrollo Urbano, Medio Ambiente y Obras Públicas</li>
                    <li><strong>C. Ma. del Carmen Barrera Galarza</strong>Educación, Cultura, Recreación, Espectáculos y Juventud</li>
                    <li><strong>C. Arturo León Juan</strong>Salud y Asistencia Social</li>
                </ul>
            </div>
            <div class="regidor-column">
                <ul>
                    <li><strong>C. Ma. Isabel Quintana Gómez</strong>Equidad y Género, Derecho de las Niñas y Adolescentes</li>
                    <li><strong>C. Jesús Javier Cruz</strong>Desarrollo Rural, Participación Social de Migrantes</li>
                    <li><strong>C. Edith Aguirre Flores</strong>Comercio, Abasto Popular, Atención y Fomento al Empleo</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="upload-container">
        <div class="upload-box" id="upload-box">
            <i class="fas fa-cloud-upload-alt upload-icon"></i>
            <div class="upload-text">
                Arrastra tu imagen aquí o 
                <span class="browse-link">selecciona desde tu dispositivo</span>
            </div>
            <input type="file" id="imagen-comuna" name="imagen_comuna" style="display:none" accept="image/*" required>
        </div>
        <div id="upload-preview" class="preview-container"></div>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="nextTab('informacion')">
            Siguiente <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</div>

<!-- Sección Información Municipio -->
<div class="section" id="informacion">
    <h2>Información del Municipio</h2>
    
    <div class="form-group">
        <label>Nombre del Municipio</label>
        <input type="text" name="municipio_nombre" class="form-control" placeholder="Nombre oficial del municipio" required>
    </div>
    
    <div class="form-group">
        <label>Descripción del Municipio</label>
        <textarea name="municipio_descripcion" class="form-control" rows="5" placeholder="Descripción detallada del municipio" required></textarea>
    </div>
    
    <div class="form-group">
        <label>Imagen del Municipio</label>
        <div class="upload-container">
            <div class="upload-box" id="informacion-upload">
                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                <div class="upload-text">
                    Arrastra tu imagen aquí o 
                    <span class="browse-link">selecciona desde tu dispositivo</span>
                </div>
                <input type="file" id="imagen-comuna" name="imagen_comuna" style="display:none" accept="image/*" required>
            </div>
            <div id="informacion-preview" class="preview-container"></div>
        </div>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="prevTab('inicio')"><i class="fas fa-arrow-left mr-2"></i> Anterior</button>
        <button type="button" class="btn btn-primary" onclick="nextTab('introduccion')">Siguiente <i class="fas fa-arrow-right ml-2"></i></button>
    </div>
</div>

<!-- Sección Introducción -->
<div class="section" id="introduccion">
    <h2>Introducción</h2>
    
    <div class="form-group">
        <label>Contenido de la introducción (máximo 800 palabras)</label>
        <div class="editor-toolbar">
            <button type="button" data-command="bold" title="Negrita"><i class="fas fa-bold"></i></button>
            <button type="button" data-command="italic" title="Cursiva"><i class="fas fa-italic"></i></button>
            <button type="button" data-command="underline" title="Subrayado"><i class="fas fa-underline"></i></button>
            <select data-command="formatBlock" title="Estilo de párrafo">
                <option value="" selected>Estilo</option>
                <option value="h1">Título 1</option>
                <option value="h2">Título 2</option>
                <option value="h3">Título 3</option>
                <option value="p">Párrafo</option>
            </select>
        </div>
        <div id="introduccion-editor" class="editor-content" contenteditable="true"></div>
        <input type="hidden" name="introduccion" id="introduccion-content" required>
        <div class="word-count" id="wordCount">0 / 800 palabras</div>
    </div>
    
    <div class="form-group">
        <label>Imagen para Introducción</label>
        <div class="upload-container">
            <div class="upload-box" id="introduccion-upload">
                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                <div class="upload-text">
                    Arrastra tu imagen aquí o 
                    <span class="browse-link">selecciona desde tu dispositivo</span>
                </div>
                <input type="file" id="imagen-comuna" name="imagen_comuna" style="display:none" accept="image/*" required>
            </div>
            <div id="introduccion-preview" class="preview-container"></div>
        </div>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="prevTab('informacion')"><i class="fas fa-arrow-left mr-2"></i> Anterior</button>
        <button type="button" class="btn btn-primary" onclick="nextTab('gobierno')">Siguiente <i class="fas fa-arrow-right ml-2"></i></button>
    </div>
</div>

<!-- Sección Introducción Gobierno -->
<div class="section" id="gobierno">
    <h2>Introducción del Gobierno</h2>
    
    <div class="form-group">
        <label>Contenido de la introducción del gobierno</label>
        <textarea name="gobierno_introduccion" class="form-control" rows="8" placeholder="Describa la introducción al gobierno municipal" required></textarea>
    </div>
    
    <div class="form-group">
        <label>Imagen del Gobierno</label>
        <div class="upload-container">
            <div class="upload-box" id="gobierno-upload">
                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                <div class="upload-text">
                    Arrastra tu imagen aquí o 
                    <span class="browse-link">selecciona desde tu dispositivo</span>
                </div>
                <input type="file" id="imagen-comuna" name="imagen_comuna" style="display:none" accept="image/*" required>
            </div>
            <div id="gobierno-preview" class="preview-container"></div>
        </div>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="prevTab('introduccion')"><i class="fas fa-arrow-left mr-2"></i> Anterior</button>
        <button type="button" class="btn btn-primary" onclick="nextTab('actividades')">Siguiente <i class="fas fa-arrow-right ml-2"></i></button>
    </div>
</div>

<!-- Sección Actividades -->
<div class="section" id="actividades">
    <h2>Actividades</h2>
    
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Seleccione el período:</label>
            <select name="actividades_periodo" class="form-control" required>
                <option value="Enero - Marzo">Enero - Marzo</option>
                <option value="Abril - Junio">Abril - Junio</option>
                <option value="Julio - Septiembre">Julio - Septiembre</option>
                <option value="Octubre - Diciembre">Octubre - Diciembre</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Áreas:</label>
            <div class="checkbox-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="areas[]" value="Cultura" id="area-cultura">
                    <label class="form-check-label" for="area-cultura">Cultura</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="areas[]" value="Educación" id="area-educacion">
                    <label class="form-check-label" for="area-educacion">Educación</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="areas[]" value="Salud" id="area-salud">
                    <label class="form-check-label" for="area-salud">Salud</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="areas[]" value="Deportes" id="area-deportes">
                    <label class="form-check-label" for="area-deportes">Deportes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="areas[]" value="Seguridad" id="area-seguridad">
                    <label class="form-check-label" for="area-seguridad">Seguridad</label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label>Descripción de las actividades</label>
        <textarea name="actividades_descripcion" class="form-control" rows="8" placeholder="Describa las actividades realizadas" required></textarea>
    </div>
    
    <div class="form-group">
        <label>Imágenes de Actividades (Máximo 5)</label>
        <div class="upload-container">
            <div class="upload-box" id="actividades-upload">
                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                <div class="upload-text">
                    Arrastra tus imágenes aquí o 
                    <span class="browse-link">selecciona desde tu dispositivo</span>
                </div>
                <input type="file" id="imagen-comuna" name="imagen_comuna" style="display:none" accept="image/*" required>
            </div>
            <div id="actividades-preview" class="preview-container row-preview"></div>
        </div>
    </div>
    
    <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="prevTab('gobierno')"><i class="fas fa-arrow-left mr-2"></i> Anterior</button>
        <button type="submit" class="btn btn-success"><i class="fas fa-save mr-2"></i> Generar Informe</button>
    </div>
</div>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script>
// Navegación entre pestañas
function showTab(tabId) {
    // Ocultar todas las secciones
    document.querySelectorAll('.section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Desactivar todas las pestañas
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Mostrar la sección seleccionada
    document.getElementById(tabId).classList.add('active');
    
    // Activar la pestaña correspondiente
    document.querySelector(`.tab[data-tab="${tabId}"]`).classList.add('active');
}

function nextTab(nextId) {
    // Validar formulario antes de avanzar
    if (validateCurrentTab()) {
        showTab(nextId);
    }
}

function prevTab(prevId) {
    showTab(prevId);
}

// Validación del formulario
function validateCurrentTab() {
    const currentTab = document.querySelector('.section.active');
    const requiredInputs = currentTab.querySelectorAll('[required]');
    const imageInputs = currentTab.querySelectorAll('input[type="file"][required]');
    
    let isValid = true;
    
    // Validar campos de texto
    requiredInputs.forEach(input => {
        if (input.type !== 'file' && !input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    // Validar campos de imagen
    imageInputs.forEach(input => {
        const uploadBox = input.closest('.upload-container').querySelector('.upload-box');
        
        if (!input.files || input.files.length === 0) {
            // Resaltar el área de carga con borde rojo
            uploadBox.classList.add('error');
            
            // Agregar mensaje de error si no existe
            if (!uploadBox.nextElementSibling || !uploadBox.nextElementSibling.classList.contains('error-message')) {
                const errorMsg = document.createElement('div');
                errorMsg.className = 'error-message text-danger mt-2';
                errorMsg.innerHTML = '<i class="fas fa-exclamation-circle"></i> Debe seleccionar una imagen';
                uploadBox.parentNode.insertBefore(errorMsg, uploadBox.nextElementSibling);
            }
            
            isValid = false;
        } else {
            uploadBox.classList.remove('error');
            // Eliminar mensaje de error si existe
            const errorMsg = uploadBox.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
                errorMsg.remove();
            }
        }
    });
    
    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Campos requeridos',
            text: 'Por favor complete todos los campos obligatorios',
        });
    }
    
    return isValid;
}

// Configuración común para todos los upload boxes
function setupFileUpload(uploadBoxId, fileInputId, previewId, multiple = false) {
    const uploadBox = document.getElementById(uploadBoxId);
    const fileInput = document.getElementById(fileInputId);
    const previewContainer = document.getElementById(previewId);
    
    // Click en el área de upload
    uploadBox.addEventListener('click', () => fileInput.click());
    
    // Cambio en el input file
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFiles(e.target.files, previewContainer, uploadBox, fileInput);
            if (!multiple) {
                uploadBox.style.display = 'none';
            }
        }
    });
    
    // Drag and drop
    uploadBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadBox.classList.add('dragover');
    });
    
    uploadBox.addEventListener('dragleave', () => {
        uploadBox.classList.remove('dragover');
    });
    
    uploadBox.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadBox.classList.remove('dragover');
        
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            handleFiles(e.dataTransfer.files, previewContainer, uploadBox, fileInput);
            if (!multiple) {
                uploadBox.style.display = 'none';
            }
        }
    });
}

// Manejar archivos subidos
function handleFiles(files, previewContainer, uploadBox, fileInput) {
    const maxFiles = 5;
    const currentCount = previewContainer.children.length;
    const remainingSlots = maxFiles - currentCount;

    if (remainingSlots <= 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Límite alcanzado',
            text: `Solo puedes subir hasta ${maxFiles} imágenes.`,
        });
        return;
    }

    const filesToAdd = Array.from(files).slice(0, remainingSlots);

    filesToAdd.forEach((file, index) => {
        if (file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                createImagePreview(e.target.result, previewContainer, uploadBox, fileInput);
            };
            reader.readAsDataURL(file);
        }
    });

    if (previewContainer.children.length + filesToAdd.length >= maxFiles) {
        uploadBox.style.display = 'none';
    }
}


// Crear vista previa de imagen con botón de eliminar
function createImagePreview(imageSrc, previewContainer, uploadBox, fileInput, index = null) {
    const container = document.createElement('div');
    container.className = 'preview-image-container';
    
    const img = document.createElement('img');
    img.src = imageSrc;
    img.className = previewContainer.classList.contains('grid-preview') ? 'preview-thumbnail' : 'preview-image';
    
    const removeBtn = document.createElement('button');
    removeBtn.className = 'remove-image-btn';
    removeBtn.innerHTML = '×';
    removeBtn.title = 'Eliminar imagen';
    
    removeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        container.remove();
        
        // Si no quedan imágenes, mostrar el upload box nuevamente
        if (previewContainer.children.length === 0) {
            uploadBox.style.display = 'block';
            
            // Resetear el input file si no es múltiple
            if (!fileInput.multiple) {
                fileInput.value = '';
            }
        }
        
        // Si es múltiple, actualizar los archivos seleccionados
        if (fileInput.multiple && index !== null) {
            updateFileInput(fileInput, index);
        }
    });
    
    container.appendChild(img);
    container.appendChild(removeBtn);
    previewContainer.appendChild(container);
}

// Actualizar input file cuando se elimina una imagen en modo múltiple
function updateFileInput(fileInput, indexToRemove) {
    const files = Array.from(fileInput.files);
    files.splice(indexToRemove, 1);
    
    const newFileList = new DataTransfer();
    files.forEach(file => newFileList.items.add(file));
    
    fileInput.files = newFileList.files;
}

// Editor de texto enriquecido
function setupEditor() {
    const editor = document.getElementById('introduccion-editor');
    const wordCount = document.getElementById('wordCount');
    const hiddenInput = document.getElementById('introduccion-content');
    
    // Botones de la barra de herramientas
    document.querySelectorAll('.editor-toolbar [data-command]').forEach(button => {
        button.addEventListener('click', () => {
            const command = button.getAttribute('data-command');
            document.execCommand(command, false, null);
            editor.focus();
        });
    });
    
    // Selector de formato
    document.querySelector('.editor-toolbar select').addEventListener('change', function() {
        if (this.value) {
            document.execCommand('formatBlock', false, this.value);
            this.selectedIndex = 0;
            editor.focus();
        }
    });
    
    // Contador de palabras
    editor.addEventListener('input', () => {
        const text = editor.innerText || '';
        const words = text.trim() ? text.trim().split(/\s+/) : [];
        const count = words.length;
        
        wordCount.textContent = `${count} / 800 palabras`;
        wordCount.style.color = count > 800 ? 'red' : '#666';
        
        // Actualizar el input hidden con el HTML del editor
        hiddenInput.value = editor.innerHTML;
    });
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Configurar navegación por pestañas
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', () => {
            showTab(tab.getAttribute('data-tab'));
        });
    });
    
    // Configurar subida de archivos para cada sección
    setupFileUpload('upload-box', 'imagen-comuna', 'upload-preview');
    setupFileUpload('informacion-upload', 'informacion-file', 'informacion-preview');
    setupFileUpload('introduccion-upload', 'introduccion-file', 'introduccion-preview');
    setupFileUpload('gobierno-upload', 'gobierno-file', 'gobierno-preview');
    setupFileUpload('actividades-upload', 'actividades-file', 'actividades-preview', true);
    
    // Configurar editor de texto enriquecido
    setupEditor();
    
    // Configurar flatpickr
    flatpickr("#periodo", {
        dateFormat: "d-m-Y",
        altFormat: "d F Y",
        locale: {
            months: {
                shorthand: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
                longhand: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
            },
            weekdays: {
                shorthand: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
                longhand: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado']
            }
        },
        maxDate: "today",
        defaultDate: "today",
        static: true
    });

    // Validación del formulario al enviar
    document.getElementById('informeForm').addEventListener('submit', function(e) {
        // Asegurarse de que el contenido del editor se guarde
        document.getElementById('introduccion-content').value = 
            document.getElementById('introduccion-editor').innerHTML;
        
        if (!validateCurrentTab()) {
            e.preventDefault();
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\zaet_\OneDrive\Escritorio\AYUNTAMIENTO\resources\views/generar-informe.blade.php ENDPATH**/ ?>