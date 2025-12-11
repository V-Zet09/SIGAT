<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe - {{ $informe->municipio_nombre }}</title>
    <style>
    * { margin: 0; padding: 0; }

    html, body {
        margin: 0 !important;
        padding: 0 !important;
        width: 100%;
    }

    body {
        font-family: 'Times New Roman', serif;
        font-size: 12pt;
        color: #000;
        line-height: 1.5;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Portada a toda página */
    @page :first {
        sheet-size: letter;
        margin: 0;
        background-image: @if($informe->portada_imagen_path)
            url('{{ str_replace("\\", "/", storage_path('app/public/' . $informe->portada_imagen_path)) }}')
        @else
            none
        @endif;
        background-image-resize: 6;
    }

    /* Resto de páginas con plantilla y márgenes */
    @page {
        sheet-size: letter;
        margin: 133px 113px 95px 113px;
        background-image: @if($informe->plantilla_imagen_path)
            url('{{ str_replace("\\", "/", storage_path('app/public/' . $informe->plantilla_imagen_path)) }}')
        @else
            none
        @endif;
        background-image-resize: 6;
    }

    .contenido {
        margin: 0 !important;
        padding: 0 !important;
        position: relative;
        z-index: 1;
        font-size: 11pt;
    }

    p {
        margin: 0 0 8pt 0;
        text-align: justify;
        text-indent: 0;
        line-height: 1.4;
        word-break: break-word;
        overflow-wrap: break-word;
        orphans: 3;
        widows: 3;
    }

    h1 {
        font-size: 13pt;
        font-weight: bold;
        margin: 12pt 0 8pt 0;
        text-align: center;
        page-break-after: avoid;
        text-transform: uppercase;
        orphans: 3;
        widows: 3;
    }

    h2 {
        font-size: 11pt;
        font-weight: bold;
        margin: 10pt 0 6pt 0;
        page-break-after: avoid;
        orphans: 3;
        widows: 3;
    }

    h3 {
        font-size: 10pt;
        font-weight: bold;
        font-style: italic;
        margin: 8pt 0 6pt 0;
        page-break-after: avoid;
        orphans: 3;
        widows: 3;
    }

    .page-break {
        page-break-after: always;
        margin: 0 !important;
        padding: 0 !important;
        height: 0 !important;
        line-height: 0 !important;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 8pt 0;
        font-size: 10pt;
        page-break-inside: avoid;
    }

    th {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        padding: 4pt;
        text-align: left;
        font-weight: bold;
        page-break-inside: avoid;
    }

    td {
        padding: 4pt;
        border-bottom: 0.5px solid #ddd;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    tbody tr:last-child td {
        border-bottom: 1px solid #000;
    }

    .autoridad {
        margin: 4pt 0;
        text-indent: 0;
        line-height: 1.3;
        font-size: 10pt;
        word-break: break-word;
        overflow-wrap: break-word;
        page-break-inside: avoid;
    }

    .autoridad-nombre {
        font-weight: bold;
    }

    .foto-comuna {
        width: 265px;
        max-width: 265px;
        height: auto;
        margin: 8pt auto;
        text-align: center;
        page-break-inside: avoid;
    }

    .foto-comuna img {
        width: 265px !important;
        max-width: 265px !important;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        display: block;
    }

    img {
        width: 265px !important;
        max-width: 265px !important;
        height: auto !important;
        margin: 8pt auto !important;
        padding: 0 !important;
        page-break-inside: avoid;
        display: block;
    }

    .indice-item {
        margin: 6pt 0;
        line-height: 1.4;
        orphans: 2;
        widows: 2;
    }

    .page-number {
        text-align: right;
        font-size: 9pt;
        margin-top: 8pt;
        color: #666;
        line-height: 1.0;
    }

    ul, ol {
        margin: 6pt 0 6pt 20px;
        line-height: 1.4;
        page-break-inside: avoid;
    }

    li {
        margin: 4pt 0;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .titulo-indice {
        text-align: center;
        font-size: 13pt;
        font-weight: bold;
        margin: 12pt 0 8pt 0;
        text-transform: uppercase;
    }
    </style>
</head>
<body>

<!-- Portada a fondo completo -->
<div class="page-break"></div>

<!-- ÍNDICE AUTOMÁTICO -->
<tocpagebreak 
    links="on"
    toc-suppress="off"
    toc-bookmarkText="Índice"
    toc-preHTML="&lt;h1 class=&quot;titulo-indice&quot;&gt;ÍNDICE&lt;/h1&gt;"
/>

<!-- SECCIÓN 1: INFORMACIÓN DE LA COMUNA -->
<div class="contenido">
    <h1>Información de la Comuna</h1>

    <div class="foto-comuna">
        @if($informe->comuna_imagen_path)
            @php $comuna = storage_path('app/public/' . $informe->comuna_imagen_path); @endphp
            @if(file_exists($comuna))
                <img src="{{ $comuna }}" alt="Comuna" />
            @endif
        @endif
    </div>

    <h2>Autoridades Municipales</h2>
    <div class="autoridad">
        <span class="autoridad-nombre">Presidente:</span> {{ $informe->presidente_nombre }}, {{ $informe->presidente_cargo }}.
    </div>

    <div class="autoridad">
        <span class="autoridad-nombre">Sindicato:</span> {{ $informe->sindicato_nombre }}, {{ $informe->sindicato_cargo }}.
    </div>

    <div class="autoridad">
        <span class="autoridad-nombre">Secretario General:</span> {{ $informe->secretario_nombre }}, {{ $informe->secretario_cargo }}.
    </div>

    <h2>Regidores</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cargo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $regidores = is_string($informe->regidores) ? json_decode($informe->regidores, true) : $informe->regidores;
            @endphp
            @if($regidores)
                @foreach($regidores as $r)
                    <tr>
                        <td>{{ $r['nombre'] ?? 'N/A' }}</td>
                        <td>{{ $r['cargo'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- SECCIÓN 2: INTRODUCCIÓN -->
<div class="page-break"></div>
<div class="contenido">
    <h1>Introducción</h1>
    <p>{!! strip_tags($informe->introduccion ?? '', '<p><br><strong><b><i><em><u><ul><li><ol>') !!}</p>

    @if($informe->introduccion_imagen_path)
        @php $intro = storage_path('app/public/' . $informe->introduccion_imagen_path); @endphp
        @if(file_exists($intro))
            <img src="{{ $intro }}" alt="Introducción" />
        @endif
    @endif
</div>

<!-- SECCIÓN 3: INFORMACIÓN GENERAL DEL MUNICIPIO -->
<div class="page-break"></div>
<div class="contenido">
    <h1>Información General del Municipio</h1>
    <p>{!! strip_tags($informe->municipio_descripcion ?? '', '<p><br><strong><b><i><em><u><ul><li><ol>') !!}</p>

    @if($informe->municipio_imagen_path)
        @php $mun = storage_path('app/public/' . $informe->municipio_imagen_path); @endphp
        @if(file_exists($mun))
            <img src="{{ $mun }}" alt="Municipio" />
        @endif
    @endif
</div>

<!-- SECCIÓN 4: GOBIERNO Y DESARROLLO MUNICIPAL -->
<div class="page-break"></div>
<div class="contenido">
    <h1>Gobierno y Desarrollo Municipal</h1>
    <p>{!! strip_tags($informe->gobierno_introduccion ?? '', '<p><br><strong><b><i><em><u><ul><li><ol>') !!}</p>

    @if($informe->gobierno_imagen_path)
        @php $gob = storage_path('app/public/' . $informe->gobierno_imagen_path); @endphp
        @if(file_exists($gob))
            <img src="{{ $gob }}" alt="Gobierno" />
        @endif
    @endif
</div>

<!-- SECCIÓN 5: ACTIVIDADES REALIZADAS -->
<div class="page-break"></div>
<div class="contenido">
    <h1>Actividades Realizadas</h1>
    <p>Se presenta un informe de las actividades realizadas en el período comprendido entre el <strong>{{ \Carbon\Carbon::parse($informe->actividades_fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</strong> y el <strong>{{ \Carbon\Carbon::parse($informe->actividades_fecha_fin)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</strong>.</p>

    @if($informe->dependencias_seleccionadas)
        <h2>Dependencias Registradas</h2>
        <p>Se incluyen actividades de las siguientes dependencias:</p>
        <ul>
            @php
                $dependencias = is_array($informe->dependencias_seleccionadas) ? $informe->dependencias_seleccionadas : json_decode($informe->dependencias_seleccionadas, true);
            @endphp
            @if(is_array($dependencias))
                @foreach($dependencias as $dep)
                    <li>{{ $dep }}</li>
                @endforeach
            @endif
        </ul>
    @endif

    <!-- ACTIVIDADES AGRUPADAS POR DEPENDENCIA -->
@if(isset($actividades) && $actividades->count() > 0)
    @php
        // Agrupar actividades por tipo_area
        $actividadesAgrupadas = $actividades->groupBy('tipo_area');
        $contadorGlobal = 1;
    @endphp
    
    @foreach($actividadesAgrupadas as $tipoArea => $actividadesPorArea)
        <!-- Encabezado de la Dependencia -->
        <h2 style="margin: 16pt 0 8pt 0; font-size: 12pt; font-weight: bold; color: #000; text-transform: uppercase;">
            {{ $tipoArea ?? 'Sin Dependencia Asignada' }}
        </h2>
        
        <!-- Actividades de esta Dependencia -->
        @foreach($actividadesPorArea as $actividad)
            <div style="page-break-inside: avoid; margin: 8pt 0;">
                
                <!-- Título con numeración global - COLOR NEGRO -->
                <h3 style="margin: 0 0 6pt 0; font-size: 11pt; font-weight: bold; color: #000;">
                    {{ $contadorGlobal }}. {{ $actividad->titulo ?? 'Actividad sin título' }}
                </h3>
                
                <!-- PRESUPUESTO - Solo para Obras Públicas -->
                @if(strtolower(trim($tipoArea)) === 'obras públicas' || strtolower(trim($tipoArea)) === 'obras publicas')
                    @if(isset($actividad->presupuesto) && $actividad->presupuesto > 0)
                        <p style="margin: 0 0 8pt 0; font-size: 10pt; font-weight: bold; color: #118C4F;">
                            <strong>Presupuesto:</strong> ${{ number_format($actividad->presupuesto, 2, '.', ',') }}
                        </p>
                    @endif
                @endif
                
                <!-- Resumen -->
                @if($actividad->resumen)
                    <p style="margin: 0 0 10pt 0; font-size: 10pt; line-height: 1.4; text-align: justify; color: #000;">
                        {{ strip_tags($actividad->resumen) }}
                    </p>
                @else
                    <p style="margin: 0 0 10pt 0; font-size: 10pt; font-style: italic; color: #999;">
                        Sin resumen disponible.
                    </p>
                @endif
                
                <!-- TODAS las imágenes de la actividad -->
                @php
                    // Decodificar el array de fotos
                    $fotos = is_string($actividad->fotos) ? json_decode($actividad->fotos, true) : $actividad->fotos;
                @endphp
                
                @if(is_array($fotos) && count($fotos) > 0)
                    <div style="text-align: center; margin: 8pt 0 0 0;">
                        @foreach($fotos as $foto)
                            @php 
                                $actividadImg = storage_path('app/public/' . $foto);
                            @endphp
                            @if(file_exists($actividadImg))
                                <img src="{{ str_replace('\\', '/', $actividadImg) }}" 
                                    alt="Imagen de actividad" 
                                    style="max-width: 265px; height: auto; margin: 4pt 0; display: block; margin-left: auto; margin-right: auto;" />
                            @endif
                        @endforeach
                    </div>
                @endif
                
            </div>
            
            @php $contadorGlobal++; @endphp
        @endforeach

    @endforeach
    
    <!-- Total de actividades -->
    <p style="margin-top: 16pt; font-weight: bold; text-align: center; font-size: 11pt; color: #000;">
        Total de actividades registradas: {{ $actividades->count() }}
    </p>
    <p style="margin: 4pt 0 0 0; text-align: center; font-size: 9pt; color: #666;">
        Distribuidas en {{ $actividadesAgrupadas->count() }} {{ $actividadesAgrupadas->count() == 1 ? 'dependencia' : 'dependencias' }}
    </p>
@else
    <p style="font-style: italic; color: #666; margin: 12pt 0;">
        No se encontraron actividades registradas para el período y dependencias seleccionadas.
    </p>
@endif

</div>

</body>
</html>
