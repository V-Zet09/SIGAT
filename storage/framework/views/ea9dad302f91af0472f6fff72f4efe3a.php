
<?php $__env->startSection('title', 'Generar Informe'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/glightbox/css/glightbox.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div id="toast" class="toast">Información guardada correctamente</div>
        
        <div class="tabs">
            <div class="tab active" data-tab="inicio">Inicio</div>
            <div class="tab" data-tab="Información Municipio">Información Municipio</div>
            <div class="tab" data-tab="Introduccion">Introducción</div>
            <div class="tab" data-tab="Introduccion Gobierno">Introducción Gobierno</div>
            <div class="tab" data-tab="Actividades">Actividades</div>
        </div>

        <!-- Sección Inicio -->
        <div class="section active" id="inicio">
            <h2>Portada</h2>

            <div class="portada-grid">
                <input type="text" placeholder="Título" class="titulo-comuna" />
                <textarea placeholder="Periodo" class="Periodo-comuna"></textarea>
            </div>

            <h2>INFORMACIÓN DE LA COMUNA</h2>
            <div class="comuna-grid">
                <div class="comuna-column">
                    <h3>Presidencia</h3>
                    <p><strong>C. JOSÉ LUIS ANTÚNEZ GOICOCHEA</strong><br>Presidente Municipal Constitucional</p>
                </div>
                <div class="comuna-column">
                    <h3>Sindicato</h3>
                    <p><strong>Profa. Maricela Cruz Cedillo</strong><br>Síndica Procuradora Municipal</p>
                </div>
                <div class="comuna-column">
                    <h3>Secretaría</h3>
                    <p><strong>C. Profr. Mario Alberto Lagunas Salgado</strong><br>Secretario General del H. Ayuntamiento Municipal Constitucional</p>
                </div>
            </div>

            <h3>Regidores</h3>
            <div class="comuna-grid">
                <div class="comuna-column">
                    <ul>
                        <li><strong>C. Zenón Huerta Arellano</strong><br>Desarrollo Urbano, Medio Ambiente y Obras Públicas</li>
                        <li><strong>C. Ma. del Carmen Barrera Galarza</strong><br>Educación, Cultura, Recreación, Espectáculos y Juventud</li>
                        <li><strong>C. Arturo León Juan</strong><br>Salud y Asistencia Social</li>
                    </ul>
                </div>
                <div class="comuna-column">
                    <ul>
                        <li><strong>C. Ma. Isabel Quintana Gómez</strong><br>Equidad y Género, Derecho de las Niñas y Adolescentes</li>
                        <li><strong>C. Jesús Javier Cruz</strong><br>Desarrollo Rural, Participación Social de Migrantes</li>
                        <li><strong>C. Edith Aguirre Flores</strong><br>Comercio, Abasto Popular, Atención y Fomento al Empleo</li>
                    </ul>
                </div>
                <div class="comuna-column">
                    <ul>
                        <li><strong>C. Margarita Ruiz González</strong><br>Bienestar Social y Salud</li>
                        <li><strong>C. Luis Alberto Gutiérrez</strong><br>Fomento a la Infraestructura y Desarrollo Urbano</li>
                        <li><strong>C. Adriana López Méndez</strong><br>Educación, Cultura, y Recreación</li>
                    </ul>
                </div>
            </div>

            <div class="upload-box" id="upload-box" 
                onclick="document.getElementById('imagen-comuna').click()" 
                ondragover="handleDragOver(event)" 
                ondragleave="handleDragLeave(event)" 
                ondrop="handleDrop(event, 'comuna')">
                <img src="https://cdn-icons-png.flaticon.com/512/833/833268.png" 
                    alt="Upload Icon" class="icon" id="upload-icon">
                <div id="upload-text">
                    Arrastra tu imagen aquí o 
                    <a class="browse-link" onclick="document.getElementById('imagen-comuna').click()">Selecciona desde tu dispositivo</a>
                </div>
                <input type="file" id="imagen-comuna" style="display:none" accept="image/*" onchange="mostrarImagen('comuna')">
            </div>

            <div id="preview-comuna" class="preview-container"></div>

            <div class="button-row">
                <button id="eliminar-comuna" class="eliminar-imagen-btn" onclick="eliminarImagen('comuna')">Eliminar Imagen</button>
                <button class="guardar-btn" onclick="guardarInformacion('inicio')">Guardar Información</button>
            </div>
        </div>

        <!-- Sección Información Municipio -->
        <div class="section" id="Información Municipio">
            <h2>Información Municipio</h2>
            <input type="text" placeholder="Nombre del Municipio" />
            <textarea placeholder="Descripción del Municipio"></textarea>
            
            <div class="upload-box" id="upload-box-municipio" 
                onclick="document.getElementById('imagen-municipio').click()" 
                ondragover="handleDragOver(event)" 
                ondragleave="handleDragLeave(event)" 
                ondrop="handleDrop(event, 'municipio')">
                <img src="https://cdn-icons-png.flaticon.com/512/833/833268.png" 
                    alt="Upload Icon" class="icon">
                <div class="upload-text">
                    Arrastra tu imagen aquí o 
                    <a class="browse-link" onclick="document.getElementById('imagen-municipio').click()">Selecciona desde tu dispositivo</a>
                </div>
                <input type="file" id="imagen-municipio" style="display:none" accept="image/*" onchange="mostrarImagen('municipio')">
            </div>

            <div id="preview-municipio" class="preview-container"></div>

            <div class="button-row">
                <button id="eliminar-municipio" class="eliminar-imagen-btn" onclick="eliminarImagen('municipio')">Eliminar Imagen</button>
                <button class="guardar-btn" onclick="guardarInformacion('Información Municipio')">Guardar Información</button>
            </div>
        </div>
        
        <!-- Sección Introducción -->
        <div class="section" id="Introduccion">
            <h2>Introducción</h2>
            <label>Ingrese la introducción (máximo 800 palabras):</label>
            <div class="editor-toolbar">
                <button type="button" onclick="document.execCommand('bold', false, '');" title="Negrita"><b>B</b></button>
                <button type="button" onclick="document.execCommand('italic', false, '');" title="Cursiva"><i>I</i></button>
                <button type="button" onclick="document.execCommand('underline', false, '');" title="Subrayado"><u>U</u></button>
                <select onchange="document.execCommand('formatBlock', false, this.value); this.selectedIndex=0;" title="Estilo de párrafo">
                    <option value="" selected>Estilo de párrafo</option>
                    <option value="p">Párrafo</option>
                    <option value="h1">Título 1</option>
                    <option value="h2">Título 2</option>
                    <option value="h3">Título 3</option>
                </select>
            </div>
            <div id="editor" class="editor-content" contenteditable="true" oninput="updateWordCount()"></div>
            <div class="word-count" id="wordCount">0 / 800 palabras</div>

            <div class="upload-box" id="upload-box-introduccion" 
                    onclick="document.getElementById('imagen-introduccion').click()" 
                    ondragover="handleDragOver(event)" 
                    ondragleave="handleDragLeave(event)" 
                    ondrop="handleDrop(event, 'introduccion')">
                <img src="https://cdn-icons-png.flaticon.com/512/833/833268.png" 
                    alt="Upload Icon" class="icon">
                <div class="upload-text">
                    Arrastra tu imagen aquí o 
                    <a class="browse-link" onclick="document.getElementById('imagen-introduccion').click()">Selecciona desde tu dispositivo</a>
                </div>
                <input type="file" id="imagen-introduccion" style="display:none" accept="image/*" onchange="mostrarImagen('introduccion')">
            </div>

            <div id="preview-introduccion" class="preview-container"></div>

            <div class="button-row">
                <button id="eliminar-introduccion" class="eliminar-imagen-btn" onclick="eliminarImagen('introduccion')">Eliminar Imagen</button>
                <button class="guardar-btn" onclick="guardarInformacion('Introduccion')">Guardar Información</button>
            </div>
        </div>
        
        <!-- Sección Introducción Gobierno -->
        <div class="section" id="Introduccion Gobierno">
            <h2>Introducción Gobierno</h2>
            <textarea placeholder="Introducción al gobierno"></textarea>
            
            <div class="upload-box" id="upload-box-gobierno" 
                    onclick="document.getElementById('imagen-gobierno').click()" 
                    ondragover="handleDragOver(event)" 
                    ondragleave="handleDragLeave(event)" 
                    ondrop="handleDrop(event, 'gobierno')">
                <img src="https://cdn-icons-png.flaticon.com/512/833/833268.png" 
                    alt="Upload Icon" class="icon">
                <div class="upload-text">
                    Arrastra tu imagen aquí o 
                    <a class="browse-link" onclick="document.getElementById('imagen-gobierno').click()">Selecciona desde tu dispositivo</a>
                </div>
                <input type="file" id="imagen-gobierno" style="display:none" accept="image/*" onchange="mostrarImagen('gobierno')">
            </div>

            <div id="preview-gobierno" class="preview-container"></div>

            <div class="button-row">
                <button id="eliminar-gobierno" class="eliminar-imagen-btn" onclick="eliminarImagen('gobierno')">Eliminar Imagen</button>
                <button class="guardar-btn" onclick="guardarInformacion('Introduccion Gobierno')">Guardar Información</button>
            </div>
        </div>

        <!-- Sección Actividades -->
        <div class="section" id="Actividades">
            <h2>Actividades</h2>

            <label class="subtitulo">Filtros</label>

            <div class="filter-periodo">
                <label>Seleccione el período:</label>
                <select>
                    <option>Enero - Marzo</option>
                    <option>Abril - Junio</option>
                    <option>Julio - Septiembre</option>
                    <option>Octubre - Diciembre</option>
                </select>
            </div>

            <div class="checkbox-inline-group">
                <label><input type="checkbox" /> Cultura</label>
                <label><input type="checkbox" /> Educación</label>
                <label><input type="checkbox" /> Salud</label>
                <label><input type="checkbox" /> Deportes</label>
                <label><input type="checkbox" /> Seguridad</label>
            </div>

            <label>Ingrese actividades:</label>
            <textarea id="intro-actividades" rows="6"></textarea>
            
            <label class="subtitulo">Imagen de Actividades</label>
            <div class="upload-box" id="upload-box-actividades" 
                onclick="document.getElementById('imagen-actividades').click()" 
                ondragover="handleDragOver(event)" 
                ondragleave="handleDragLeave(event)" 
                ondrop="handleDrop(event, 'actividades')">
                <img src="https://cdn-icons-png.flaticon.com/512/833/833268.png" 
                    alt="Upload Icon" class="icon">
                <div class="upload-text">
                    Arrastra tu imagen aquí o 
                    <a class="browse-link" onclick="document.getElementById('imagen-actividades').click()">Selecciona desde tu dispositivo</a>
                </div>
                <input type="file" id="imagen-actividades" style="display:none" accept="image/*" onchange="mostrarImagen('actividades')">
            </div>

            <div id="preview-actividades" class="preview-container"></div>
            
            <div class="button-row">
                <button id="eliminar-actividades" class="eliminar-imagen-btn" onclick="eliminarImagen('actividades')">Eliminar Imagen</button>
                <button class="guardar-btn" onclick="guardarInformacion('Actividades')">Guardar Información</button>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/glightbox/js/glightbox.min.js')); ?>"></script>
    <script>
        const tabs = document.querySelectorAll('.tab');
        const sections = document.querySelectorAll('.section');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Activar tab
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Mostrar sección correspondiente
                const target = tab.getAttribute('data-tab');
                sections.forEach(section => {
                    section.classList.remove('active');
                    if (section.id === target) {
                        section.classList.add('active');
                    }
                });
            });
        });

        // Contador de palabras para el editor enriquecido
        function updateWordCount() {
            const editor = document.getElementById('editor');
            const wordCountElem = document.getElementById('wordCount');

            const text = editor.innerText || '';
            const words = text.trim().split(/\s+/).filter(word => word.length > 0);
            const count = words.length;

            wordCountElem.textContent = `${count} / 800 palabras`;

            // Cambiar color si excede
            if (count > 800) {
                wordCountElem.style.color = 'red';
            } else {
                wordCountElem.style.color = '#666';
            }
        }

        // Función para guardar información
        function guardarInformacion(seccion) {
            let data = {};
            
            // Caso especial para la sección de introducción (editor)
            if (seccion === 'Introduccion') {
                const contenido = document.getElementById('editor').innerHTML;
                data.contenido = contenido;
                localStorage.setItem(seccion, JSON.stringify(data));
                mostrarToast();
                return;
            }
            
            // Para todas las demás secciones
            const container = document.getElementById(seccion);
            if (!container) {
                alert('Sección no encontrada.');
                return;
            }
            
            const inputs = container.querySelectorAll('input[type="text"], textarea');
            inputs.forEach(input => {
                data[input.placeholder || input.name || input.id] = input.value;
            });
            
            localStorage.setItem(seccion, JSON.stringify(data));
            mostrarToast();
        }

        // Función para mostrar el toast
        function mostrarToast() {
            const toast = document.getElementById("toast");
            toast.classList.add("show");
            setTimeout(() => toast.classList.remove("show"), 3000);
        }

        function cargarInformacion(seccion) {
            const dataJSON = localStorage.getItem(seccion);
            if (!dataJSON) return; // No hay datos guardados

            const data = JSON.parse(dataJSON);

            const container = document.getElementById(seccion);
            if (!container) return;

            // Buscar inputs y textarea dentro del contenedor
            const inputs = container.querySelectorAll('input[type="text"], textarea');

            inputs.forEach(input => {
                const key = input.placeholder || input.name || input.id;
                if (data[key] !== undefined) {
                    input.value = data[key];
                }
            });
        }

        function mostrarImagen(id) {
            const input = document.getElementById(`imagen-${id}`);
            const preview = document.getElementById(`preview-${id}`);
            const eliminarBtn = document.getElementById(`eliminar-${id}`);
            const uploadBox = document.getElementById(`upload-box-${id}`) || document.getElementById('upload-box');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="imagen-preview">`;
                    if (eliminarBtn) eliminarBtn.style.display = "inline-block";
                    if (uploadBox) uploadBox.style.display = "none";
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function eliminarImagen(id) {
            const input = document.getElementById(`imagen-${id}`);
            const preview = document.getElementById(`preview-${id}`);
            const eliminarBtn = document.getElementById(`eliminar-${id}`);
            const uploadBox = document.getElementById(`upload-box-${id}`) || document.getElementById('upload-box');

            input.value = "";
            preview.innerHTML = "";
            if (eliminarBtn) eliminarBtn.style.display = "none";
            if (uploadBox) uploadBox.style.display = "flex";
        }

        function handleDragOver(e) {
            e.preventDefault();
            e.currentTarget.classList.add('dragover');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.currentTarget.classList.remove('dragover');
        }

        function handleDrop(e, seccion) {
            e.preventDefault();
            e.currentTarget.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const input = document.getElementById(`imagen-${seccion}`);
                input.files = files;
                mostrarImagen(seccion);
            }
        }

        // Cargar datos al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar datos para cada sección
            const secciones = ['inicio', 'Información Municipio', 'Introduccion', 'Introduccion Gobierno', 'Actividades'];
            secciones.forEach(seccion => {
                cargarInformacion(seccion);
            });
            
            // Cargar contenido del editor si existe
            const dataJSON = localStorage.getItem('Introduccion');
            if (dataJSON) {
                const data = JSON.parse(dataJSON);
                if (data.contenido) {
                    document.getElementById('editor').innerHTML = data.contenido;
                    updateWordCount();
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Documents\GitHub\SIGAT\resources\views/dashboard-generar-informe.blade.php ENDPATH**/ ?>