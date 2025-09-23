@extends('layouts.master-public')

@section('title', 'Organigrama del Ayuntamiento')

@section('content')
<div class="max-w-full mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-[#00713D] mb-12 text-center">
        Organigrama del Ayuntamiento
    </h1>

   @php
$equipo = [
    [
        'nombre' => 'Jose Luis Antunez Goicochea',
        'cargo' => 'Presidente Municipal',
        'area' => 'Presidencia',
        'email' => 'presidente_tlapehuala@hotmail.com',
        'telefono' => '747 47 5 12 34',
        'foto' => asset('images/organigrama/presidente.jpg'),
        'hijos' => [
            // Presidencia
            ['nombre' => 'Jesus Campos Casarrubias', 'cargo' => 'Secretario Particular', 'area' => 'Presidencia'],
            ['nombre' => 'Edgardo Santamaria Rojas', 'cargo' => 'Secretario Técnico', 'area' => 'Presidencia'],
            ['nombre' => 'Benito Mojica Wences', 'cargo' => 'Asesor Jurídico', 'area' => 'Presidencia'],
            ['nombre' => 'Sergio Tapia Salgado', 'cargo' => 'Asesor Presidencia', 'area' => 'Presidencia'],
            ['nombre' => 'Sofia Ines Najera Rivera', 'cargo' => 'Auxiliar Presidencia', 'area' => 'Presidencia'],
            ['nombre' => 'Maria Perez Maya', 'cargo' => 'Auxiliar de Presidencia', 'area' => 'Presidencia'],
            ['nombre' => 'Yoselin Carlos Bernabe', 'cargo' => 'Recepcionista', 'area' => 'Presidencia'],
            ['nombre' => 'Barbarita Rodriguez Flores', 'cargo' => 'Recepcionista', 'area' => 'Presidencia'],

            // Sindicatura
            [
                'nombre' => 'Marisela Cruz Cedillo',
                'cargo' => 'Síndico Procurador',
                'area' => 'Sindicatura',
                'hijos' => [
                    ['nombre' => 'Armando Suarez Valerio', 'cargo' => 'Asesor de Sindicatura', 'area' => 'Sindicatura'],
                    ['nombre' => 'Rosalia Ruiz Avila', 'cargo' => 'Secretaria', 'area' => 'Sindicatura'],
                ]
            ],

            // Regidores
            [
                'nombre' => 'Regidores',
                'cargo' => 'Cuerpo Edilicio',
                'area' => 'Cabildo',
                'hijos' => [
                    ['nombre' => 'Zenon Huerta Arellano', 'cargo' => 'Regidor', 'area' => 'Cabildo'],
                    ['nombre' => 'Ma. Del Carmen Barrera Galarza', 'cargo' => 'Regidora', 'area' => 'Cabildo'],
                    ['nombre' => 'Arturo Leon Juan', 'cargo' => 'Regidor', 'area' => 'Cabildo'],
                    ['nombre' => 'Ma. Isabel Quintana Gomez', 'cargo' => 'Regidora', 'area' => 'Cabildo'],
                    ['nombre' => 'Jesus Javier Gutierrez Cruz', 'cargo' => 'Regidor', 'area' => 'Cabildo'],
                    ['nombre' => 'Ma. Edith Aguirre Flores', 'cargo' => 'Regidora', 'area' => 'Cabildo'],
                ]
            ],

            // Secretaría General
            [
                'nombre' => 'Mario Lagunas Salgado',
                'cargo' => 'Secretario General',
                'area' => 'Secretaría General',
                'hijos' => [
                    ['nombre' => 'Alberto Nova Arzate', 'cargo' => 'Asesor Jurídico', 'area' => 'Secretaría General'],
                    ['nombre' => 'Juan Mora De La Paz', 'cargo' => 'Asesor', 'area' => 'Secretaría General'],
                    ['nombre' => 'Catalino Paredes Rosales', 'cargo' => 'Coordinador de Ayuntamiento', 'area' => 'Secretaría General'],
                    ['nombre' => 'Alina Izamar Luciano Garcia', 'cargo' => 'Secretaria', 'area' => 'Secretaría General'],
                ]
            ],

            // Tesorería
            [
                'nombre' => 'Rodrigo Elexei Rodriguez Romero',
                'cargo' => 'Tesorero',
                'area' => 'Tesorería',
                'hijos' => [
                    ['nombre' => 'Trini Carlos Concha Delgado', 'cargo' => 'Contador', 'area' => 'Tesorería'],
                    ['nombre' => 'Tomaza Duarte Munguia', 'cargo' => 'Auxiliar Contable', 'area' => 'Tesorería'],
                    ['nombre' => 'Arturo Pedro Valencia', 'cargo' => 'Auxiliar Contable', 'area' => 'Tesorería'],
                    ['nombre' => 'Damian Cortes Baltazar', 'cargo' => 'Auxiliar Contable', 'area' => 'Tesorería'],
                    ['nombre' => 'Jesus Dominguez Vergara', 'cargo' => 'Auxiliar Contable', 'area' => 'Tesorería'],
                    ['nombre' => 'Antonia Nayely Salas Carlos', 'cargo' => 'Cajera', 'area' => 'Tesorería'],
                ]
            ],

            // Alumbrado Público
            [
                'nombre' => 'Margarita Salmeron Veledias',
                'cargo' => 'Directora de Alumbrado Público',
                'area' => 'Alumbrado Público',
                'hijos' => [
                    ['nombre' => 'Jose Alberto Ochoa Mireles', 'cargo' => 'Electricista', 'area' => 'Alumbrado Público'],
                    ['nombre' => 'Perfecto Claudio Alonso', 'cargo' => 'Electricista', 'area' => 'Alumbrado Público'],
                ]
            ],

            // Reglamentos
            [
                'nombre' => 'Victor de Jesus Blancas',
                'cargo' => 'Director de Reglamentos',
                'area' => 'Reglamentos',
                'hijos' => [
                    ['nombre' => 'Rafael Orozco Santos', 'cargo' => 'Sub-director', 'area' => 'Reglamentos'],
                    ['nombre' => 'Angel de Jesus Torres Castro', 'cargo' => 'Asistente', 'area' => 'Reglamentos'],
                    ['nombre' => 'Pedro Reano Rosas', 'cargo' => 'Cobrador', 'area' => 'Reglamentos'],
                    ['nombre' => 'Felix Garcia Benitez', 'cargo' => 'Encargado de Marcado', 'area' => 'Reglamentos'],
                    ['nombre' => 'Juan Manuel Blancas Torres', 'cargo' => 'Encargado de Rastro', 'area' => 'Reglamentos'],
                    ['nombre' => 'Jazmin Miranda Avilez', 'cargo' => 'Limpia Rastro', 'area' => 'Reglamentos'],
                    ['nombre' => 'Taide Segura Garcia', 'cargo' => 'Limpia Rastro', 'area' => 'Reglamentos'],
                ]
            ],

            // Tránsito
            [
                'nombre' => 'Arnulfo Aviles Velazquez',
                'cargo' => 'Director de Tránsito',
                'area' => 'Tránsito',
                'hijos' => [
                    ['nombre' => 'J. Refugio Tapia Garcia', 'cargo' => 'Tránsito', 'area' => 'Tránsito'],
                    ['nombre' => 'Bulmaro Rayo Valdez', 'cargo' => 'Tránsito', 'area' => 'Tránsito'],
                    ['nombre' => 'Salome Romero Valencia', 'cargo' => 'Tránsito', 'area' => 'Tránsito'],
                    ['nombre' => 'Juan Carlos Garcia Damian', 'cargo' => 'Tránsito', 'area' => 'Tránsito'],
                    ['nombre' => 'Francisco Ramirez Verona', 'cargo' => 'Tránsito', 'area' => 'Tránsito'],
                    ['nombre' => 'Ma. Concepcion Duarte Aviles', 'cargo' => 'Secretaria', 'area' => 'Tránsito'],
                ]
            ],

            // Casa de la Cultura / Limpieza
            [
                'nombre' => 'Casa de la Cultura',
                'cargo' => 'Área de Cultura y Servicios',
                'area' => 'Casa de la Cultura',
                'hijos' => [
                    ['nombre' => 'Esperanza Rodriguez Espinoza', 'cargo' => 'Limpieza', 'area' => 'Casa de la Cultura'],
                    ['nombre' => 'Ma. Luisa Santiago Baltazar', 'cargo' => 'Limpieza Ayuntamiento', 'area' => 'Servicios'],
                    ['nombre' => 'Bernardo Isidro Luciano', 'cargo' => 'Limpieza Ayuntamiento', 'area' => 'Servicios'],
                    ['nombre' => 'Jose de Jesus Perez Villa', 'cargo' => 'Carro de Basura', 'area' => 'Servicios'],
                    ['nombre' => 'Gerardo Flores Quintana', 'cargo' => 'Carro de Basura', 'area' => 'Servicios'],
                ]
            ],

            // DIF Municipal
            [
                'nombre' => 'Nadia Carolina Brito Gutierrez',
                'cargo' => 'Presidenta del DIF Municipal',
                'area' => 'DIF',
                'hijos' => [
                    ['nombre' => 'Marisol Zamora Carmona', 'cargo' => 'Secretaria', 'area' => 'DIF'],
                    ['nombre' => 'Marina Espinoza Gomez', 'cargo' => 'Recepcionista', 'area' => 'DIF'],
                    [
                        'nombre' => 'Asistentes',
                        'cargo' => 'Equipo de Apoyo',
                        'area' => 'DIF',
                        'hijos' => [
                            ['nombre' => 'Pablo Valencia Salgado', 'cargo' => 'Asistente', 'area' => 'DIF'],
                            ['nombre' => 'Mario Alberto Ramirez', 'cargo' => 'Asistente', 'area' => 'DIF'],
                            ['nombre' => 'Andrea Martinez Torres', 'cargo' => 'Asistente', 'area' => 'DIF'],
                            ['nombre' => 'Julio Cesar Rojas', 'cargo' => 'Asistente', 'area' => 'DIF'],
                            ['nombre' => 'Yolanda Perez Gomez', 'cargo' => 'Asistente', 'area' => 'DIF'],
                            ['nombre' => 'Javier Castro Morales', 'cargo' => 'Asistente', 'area' => 'DIF'],
                        ]
                    ],
                ]
            ],

            // Seguridad Pública
            [
                'nombre' => 'Fernando Guzman Castro',
                'cargo' => 'Director de Seguridad Pública',
                'area' => 'Seguridad Pública',
                'hijos' => array_map(function($i){ return ['nombre'=>"Oficial $i",'cargo'=>'Policía Municipal','area'=>'Seguridad Pública']; }, range(1,10)),
            ],

            // Otros departamentos
            ['nombre' => 'Silvano Corrales Cuicas', 'cargo' => 'Director de Desarrollo Económico', 'area' => 'Desarrollo Económico'],
            ['nombre' => 'Jessica Gutierrez Castillo', 'cargo' => 'Directora de Prevención del Delito', 'area' => 'Prevención del Delito'],
            ['nombre' => 'Ma. Julia Castro Ruiz', 'cargo' => 'Coordinadora de Trabajo Social', 'area' => 'Trabajo Social'],
            ['nombre' => 'Miguel Angel Jaimes Aguilar', 'cargo' => 'Director de Salud', 'area' => 'Salud'],

            // --------- INFORMÁTICA AL FINAL ---------
            [
                'nombre' => 'Miguel Angel Acuna Garcia',
                'cargo' => 'Director de Informática',
                'area' => 'Informática',
                'foto' => asset('images/organigrama/miguel.jpg'),
                'hijos' => [
                    [
                        'nombre' => 'Faustino Lopez Nunez',
                        'cargo' => 'Asistente',
                        'area' => 'Informática',
                        'foto' => asset('images/organigrama/faustino.jpg'),
                    ],
                    [
                        'nombre' => 'Maico Zaet Perez Valencia',
                        'cargo' => 'Pasante Encargado Full Stack',
                        'area' => 'Informática',
                        'email' => 'zaet_maico@hotmail.com',
                        'foto' => asset('images/organigrama/maicozaet.jpeg'),
                    ],
                    [
                        'nombre' => 'Jorge Campos Alvarado',
                        'cargo' => 'Encargado Front End',
                        'area' => 'Informática',
                        'foto' => asset('images/organigrama/jorge.jpg'),
                    ],
                    [
                        'nombre' => 'Jose Angel Alonso Leon',
                        'cargo' => 'SQL',
                        'area' => 'Informática',
                        'foto' => asset('images/organigrama/jose.jpg'),
                    ],
                    [
                        'nombre' => 'Mariana Lilbeth Antunez Garcia',
                        'cargo' => 'Front End',
                        'area' => 'Informática',
                        'foto' => asset('images/organigrama/mariana.jpeg'),
                    ],
                ],
            ],

        ]
    ]
];
@endphp

    <div class="flex justify-center overflow-x-auto">
        <ul class="relative pl-0">
            @foreach($equipo as $nodo)
                <x-nodo :nodo="$nodo" />
            @endforeach
        </ul>
    </div>
</div>
@endsection
