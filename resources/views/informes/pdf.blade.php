<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $informe->titulo }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 2cm;
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #333;
            position: relative;
        }


        /* ========== MARCA DE AGUA - PLANTILLA ========== */
        /* La plantilla se verá en TODAS las páginas */
        body.has-watermark::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background-size: 100% 100%; /* Ocupa todo el espacio del papel */
            background-position: center center;
            background-repeat: no-repeat;
            opacity: 1; /* Se ve igual que el ejemplo */
            z-index: -1;
            pointer-events: none;
        }


        /* PORTADA */
        .portada {
            text-align: center;
            page-break-after: always;
            padding-top: 150px;
        }
        .portada img {
            max-width: 250px;
            margin: 0 auto 40px;
        }
        .portada h1 {
            font-size: 32pt;
            color: #00713D;
            font-weight: bold;
            margin: 30px 0;
            text-transform: uppercase;
        }
        .portada .periodo {
            font-size: 18pt;
            color: #666;
            margin: 20px 0;
        }
        .portada .municipio {
            font-size: 14pt;
            color: #00713D;
            margin-top: 60px;
            font-weight: bold;
        }

        /* ENCABEZADOS */
        h2 {
            color: #00713D;
            font-size: 20pt;
            font-weight: bold;
            margin: 40px 0 20px 0;
            padding-bottom: 8px;
            border-bottom: 3px solid #00713D;
            text-transform: uppercase;
        }
        h3 {
            color: #05924a;
            font-size: 14pt;
            font-weight: bold;
            margin: 25px 0 15px 0;
        }
        h4 {
            color: #00713D;
            font-size: 12pt;
            font-weight: bold;
            margin: 15px 0 10px 0;
        }

        /* COMUNA */
        .comuna-grid {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .comuna-row {
            display: table-row;
        }
        .comuna-cell {
            display: table-cell;
            width: 33.33%;
            padding: 15px 10px;
            vertical-align: top;
        }
        .autoridad-card {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #00713D;
            border-radius: 5px;
            min-height: 100px;
        }
        .autoridad-card .titulo {
            color: #00713D;
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .autoridad-card .nombre {
            font-weight: bold;
            font-size: 10pt;
            margin: 5px 0;
        }
        .autoridad-card .cargo {
            font-size: 9pt;
            color: #666;
            font-style: italic;
        }

        /* REGIDORES */
        .regidores-grid {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .regidor-row {
            display: table-row;
        }
        .regidor-cell {
            display: table-cell;
            width: 50%;
            padding: 10px 5px;
            vertical-align: top;
        }

        /* SECCIONES */
        .seccion {
            margin: 30px 0;
            page-break-inside: avoid;
        }
        .seccion img {
            max-width: 100%;
            height: auto;
            margin: 20px auto;
            display: block;
            border-radius: 8px;
        }
        .seccion p {
            text-align: justify;
            margin: 10px 0;
        }

        /* ACTIVIDADES */
        .actividad-dependencia {
            margin: 25px 0;
            page-break-inside: avoid;
        }
        .actividad-dependencia h3 {
            background: #00713D;
            color: white;
            padding: 10px 15px;
            margin: 0 0 15px 0;
            border-radius: 5px;
        }
        .actividad-item {
            background: #f0f9f4;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #00713D;
            border-radius: 5px;
            page-break-inside: avoid;
        }
        .actividad-item h4 {
            color: #00713D;
            margin: 0 0 10px 0;
            font-size: 11pt;
        }
        .actividad-fecha {
            color: #666;
            font-size: 9pt;
            font-style: italic;
            margin-bottom: 8px;
        }
        .actividad-descripcion {
            font-size: 10pt;
            line-height: 1.4;
        }
        .actividad-imagenes {
            margin-top: 10px;
        }
        .actividad-imagenes img {
            max-width: 48%;
            height: auto;
            display: inline-block;
            margin: 5px 1%;
            border-radius: 5px;
        }

        /* PIE DE PÁGINA */
        .footer {
            position: fixed;
            bottom: 1cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }

        /* ÍNDICE */
        .indice {
            page-break-after: always;
        }
        .indice-item {
            margin: 8px 0;
            padding-left: 20px;
        }
        .indice-item::before {
            content: "• ";
            color: #00713D;
            font-weight: bold;
        }
    </style>
    
    @php
        // Generar estilo inline para marca de agua
        $watermarkStyle = '';
        if ($informe->plantilla_imagen_path && file_exists(storage_path('app/public/' . $informe->plantilla_imagen_path))) {
            $imagePath = storage_path('app/public/' . $informe->plantilla_imagen_path);
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
            $watermarkStyle = 'background-image: url(data:image/' . $imageType . ';base64,' . $imageData . ');';
        }
    @endphp
    
    @if($watermarkStyle)
    <style>
        body.has-watermark::before {
            {{ $watermarkStyle }}
        }
    </style>
    @endif
</head>
<body class="{{ $watermarkStyle ? 'has-watermark' : '' }}">
    <!-- PORTADA -->
    <div class="portada">
        @if($informe->portada_path && file_exists(storage_path('app/public/' . $informe->portada_path)))
            @php
                $imagePath = storage_path('app/public/' . $informe->portada_path);
                $imageData = base64_encode(file_get_contents($imagePath));
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
            @endphp
            <img src="{{ $imageSrc }}" alt="Portada">
        @endif
        
        <h1>{{ $informe->titulo }}</h1>
        <p class="periodo">{{ $informe->periodo }}</p>
        <p class="municipio">{{ $informe->municipio_nombre }}</p>
    </div>

    <!-- ÍNDICE -->
    <div class="indice">
        <h2>Índice</h2>
        <div class="indice-item">Información de la Comuna</div>
        <div class="indice-item">Información del Municipio</div>
        <div class="indice-item">Introducción</div>
        <div class="indice-item">Gobierno y Desarrollo Municipal</div>
        <div class="indice-item">Actividades Realizadas</div>
    </div>

    <!-- INFORMACIÓN DE LA COMUNA -->
    <div class="seccion">
        <h2>Información de la Comuna</h2>
        
        <div class="comuna-grid">
            <div class="comuna-row">
                <div class="comuna-cell">
                    <div class="autoridad-card">
                        <div class="titulo">Presidencia</div>
                        <div class="nombre">{{ $informe->presidente_nombre }}</div>
                        <div class="cargo">{{ $informe->presidente_cargo }}</div>
                    </div>
                </div>
                
                <div class="comuna-cell">
                    <div class="autoridad-card">
                        <div class="titulo">Sindicato</div>
                        <div class="nombre">{{ $informe->sindicato_nombre }}</div>
                        <div class="cargo">{{ $informe->sindicato_cargo }}</div>
                    </div>
                </div>
                
                <div class="comuna-cell">
                    <div class="autoridad-card">
                        <div class="titulo">Secretaría</div>
                        <div class="nombre">{{ $informe->secretario_nombre }}</div>
                        <div class="cargo">{{ $informe->secretario_cargo }}</div>
                    </div>
                </div>
            </div>
        </div>

        <h3>Regidores</h3>
        <div class="regidores-grid">
            @php
                $regidores = is_string($informe->regidores) 
                    ? json_decode($informe->regidores, true) ?? []
                    : ($informe->regidores ?? []);
                $chunks = array_chunk($regidores, 2);
            @endphp
            
            @foreach($chunks as $chunk)
            <div class="regidor-row">
                @foreach($chunk as $regidor)
                <div class="regidor-cell">
                    <div class="autoridad-card">
                        <div class="nombre">{{ $regidor['nombre'] ?? '' }}</div>
                        <div class="cargo">{{ $regidor['cargo'] ?? '' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>

    <!-- INFORMACIÓN DEL MUNICIPIO -->
    <div class="seccion">
        <h2>{{ $informe->municipio_nombre }}</h2>
        
        @if($informe->municipio_imagen_path && file_exists(storage_path('app/public/' . $informe->municipio_imagen_path)))
            @php
                $imagePath = storage_path('app/public/' . $informe->municipio_imagen_path);
                $imageData = base64_encode(file_get_contents($imagePath));
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
            @endphp
            <img src="{{ $imageSrc }}" style="max-height: 300px;" alt="Municipio">
        @endif
        
        <div>{!! $informe->municipio_descripcion ?? '' !!}</div>
    </div>

    <!-- INTRODUCCIÓN -->
    <div class="seccion">
        <h2>Introducción</h2>
        
        @if($informe->introduccion_imagen_path && file_exists(storage_path('app/public/' . $informe->introduccion_imagen_path)))
            @php
                $imagePath = storage_path('app/public/' . $informe->introduccion_imagen_path);
                $imageData = base64_encode(file_get_contents($imagePath));
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
            @endphp
            <img src="{{ $imageSrc }}" style="max-height: 300px;" alt="Introducción">
        @endif
        
        <div>{!! $informe->introduccion ?? '' !!}</div>
    </div>

    <!-- GOBIERNO -->
    <div class="seccion">
        <h2>Gobierno y Desarrollo Municipal</h2>
        
        @if($informe->gobierno_imagen_path && file_exists(storage_path('app/public/' . $informe->gobierno_imagen_path)))
            @php
                $imagePath = storage_path('app/public/' . $informe->gobierno_imagen_path);
                $imageData = base64_encode(file_get_contents($imagePath));
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
            @endphp
            <img src="{{ $imageSrc }}" style="max-height: 300px;" alt="Gobierno">
        @endif
        
        <div>{!! $informe->gobierno_introduccion ?? '' !!}</div>
    </div>

    <!-- ACTIVIDADES -->
    <div class="seccion">
        <h2>Actividades Realizadas</h2>
        <p style="color: #666; font-size: 10pt; margin-bottom: 30px;">
            <strong>Período:</strong> 
            {{ \Carbon\Carbon::parse($informe->actividades_fecha_inicio)->format('d/m/Y') }} 
            al 
            {{ \Carbon\Carbon::parse($informe->actividades_fecha_fin)->format('d/m/Y') }}
        </p>
        
        @php
            try {
                $actividades = $informe->getActividadesFiltradas();
                $actividadesPorDependencia = $actividades->groupBy('dependencia');
            } catch (\Exception $e) {
                \Log::error('Error al obtener actividades: ' . $e->getMessage());
                $actividades = collect([]);
                $actividadesPorDependencia = collect([]);
            }
        @endphp
        
        @forelse($actividadesPorDependencia as $dependencia => $acts)
        <div class="actividad-dependencia">
            <h3>{{ ucwords(str_replace('_', ' ', $dependencia)) }}</h3>
            
            @foreach($acts as $actividad)
            <div class="actividad-item">
                <h4>{{ $actividad->titulo }}</h4>
                <div class="actividad-fecha">
                    {{ \Carbon\Carbon::parse($actividad->fecha)->format('d \d\e F \d\e Y') }}
                </div>
                <div class="actividad-descripcion">
                    {{ $actividad->descripcion }}
                </div>
                
                @if(!empty($actividad->imagenes) && is_array($actividad->imagenes))
                <div class="actividad-imagenes">
                    @foreach(array_slice($actividad->imagenes, 0, 4) as $imagen)
                        @if(file_exists(storage_path('app/public/' . $imagen)))
                            @php
                                $imgPath = storage_path('app/public/' . $imagen);
                                $imgData = base64_encode(file_get_contents($imgPath));
                                $imgType = pathinfo($imgPath, PATHINFO_EXTENSION);
                                $imgSrc = 'data:image/' . $imgType . ';base64,' . $imgData;
                            @endphp
                            <img src="{{ $imgSrc }}" alt="Actividad">
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @empty
        <p style="text-align: center; color: #666; padding: 40px 0;">
            No se encontraron actividades para el período y dependencias seleccionadas.
        </p>
        @endforelse
    </div>

    <!-- PIE DE PÁGINA -->
    <div class="footer">
        <p>{{ $informe->municipio_nombre }} - {{ $informe->periodo }}</p>
    </div>
</body>
</html>