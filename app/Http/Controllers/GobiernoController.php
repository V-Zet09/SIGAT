<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Gobierno;

class GobiernoController extends Controller
{
    /**
     * Mostrar la vista del gobierno municipal
     */
    public function index()
    {
        // Obtener la información del gobierno
        // Asumiendo que solo hay un registro activo
        $gobierno = Gobierno::first();
        
        // Si no existe, crear uno con valores por defecto
        if (!$gobierno) {
            $gobierno = Gobierno::create([
                'periodo' => '2024 - 2027',
                'presidente_nombre' => 'C. José Luis Antúnez Goicochea',
                'presidente_telefono' => '7328980098',
                'presidente_facebook' => 'José Luis Antúnez Goicochea',
                'presidente_direccion' => 'Palacio Municipal, Tlapehuala',
                'sindica_nombre' => 'Profa. Maricela Cruz Cedillo',
                'secretario_nombre' => 'C. Profr. Mario Alberto Lagunas Salgado',
                'regidores' => [
                    [
                        'nombre' => 'C. Zenón Huerta Arellano',
                        'cargo' => 'REGIDOR',
                        'comision' => 'Desarrollo Urbano, Medio Ambiente y Obras Públicas',
                        'icono' => 'ri-building-line'
                    ],
                    [
                        'nombre' => 'C. Ma. del Carmen Barrera Galarza',
                        'cargo' => 'REGIDORA',
                        'comision' => 'Educación, Cultura, Recreación y Juventud',
                        'icono' => 'ri-book-open-line'
                    ],
                    [
                        'nombre' => 'C. Arturo León Juan',
                        'cargo' => 'REGIDOR',
                        'comision' => 'Salud y Asistencia Social',
                        'icono' => 'ri-heart-pulse-line'
                    ],
                    [
                        'nombre' => 'C. Ma. Isabel Quintana Gómez',
                        'cargo' => 'REGIDORA',
                        'comision' => 'Equidad y Género, Derecho de las Niñas y Adolescentes',
                        'icono' => 'ri-women-line'
                    ],
                    [
                        'nombre' => 'C. Jesús Javier Cruz',
                        'cargo' => 'REGIDOR',
                        'comision' => 'Desarrollo Rural, Participación Social de Migrantes',
                        'icono' => 'ri-plant-line'
                    ],
                    [
                        'nombre' => 'C. Edith Aguirre Flores',
                        'cargo' => 'REGIDORA',
                        'comision' => 'Comercio, Abasto Popular y Fomento al Empleo',
                        'icono' => 'ri-store-line'
                    ]
                ]
            ]);
        }
        
        return view('gobierno', compact('gobierno'));
    }

    /**
     * Actualizar información del gobierno
     */
    public function update(Request $request)
    {
        try {
            $gobierno = Gobierno::first();
            
            if (!$gobierno) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró la información del gobierno'
                ], 404);
            }

            $field = $request->input('field');
            $data = [];

            switch ($field) {
                case 'presidente_imagen':
                    if ($request->hasFile('imagen')) {
                        $request->validate([
                            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
                        ]);

                        // Eliminar imagen anterior si existe
                        if ($gobierno->presidente_imagen && Storage::disk('public')->exists($gobierno->presidente_imagen)) {
                            Storage::disk('public')->delete($gobierno->presidente_imagen);
                        }

                        // Guardar nueva imagen
                        $path = $request->file('imagen')->store('gobierno/presidente', 'public');
                        $gobierno->presidente_imagen = $path;
                        $gobierno->save();

                        $data['imagen_url'] = Storage::url($path);
                    }
                    break;

                case 'cabildo_imagen':
                    if ($request->hasFile('imagen')) {
                        $request->validate([
                            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
                        ]);

                        // Eliminar imagen anterior si existe
                        if ($gobierno->cabildo_imagen && Storage::disk('public')->exists($gobierno->cabildo_imagen)) {
                            Storage::disk('public')->delete($gobierno->cabildo_imagen);
                        }

                        // Guardar nueva imagen
                        $path = $request->file('imagen')->store('gobierno/cabildo', 'public');
                        $gobierno->cabildo_imagen = $path;
                        $gobierno->save();

                        $data['imagen_url'] = Storage::url($path);
                    }
                    break;

                case 'presidente_nombre':
                    $request->validate([
                        'valor' => 'required|string|max:255'
                    ]);
                    $gobierno->presidente_nombre = $request->input('valor');
                    $gobierno->save();
                    $data['valor'] = $request->input('valor');
                    break;

                case 'presidente_telefono':
                    $request->validate([
                        'valor' => 'required|string|max:20'
                    ]);
                    $gobierno->presidente_telefono = $request->input('valor');
                    $gobierno->save();
                    $data['valor'] = $request->input('valor');
                    break;

                case 'presidente_facebook':
                    $request->validate([
                        'valor' => 'required|string|max:255'
                    ]);
                    $gobierno->presidente_facebook = $request->input('valor');
                    $gobierno->save();
                    $data['valor'] = $request->input('valor');
                    break;

                case 'presidente_direccion':
                    $request->validate([
                        'valor' => 'required|string|max:255'
                    ]);
                    $gobierno->presidente_direccion = $request->input('valor');
                    $gobierno->save();
                    $data['valor'] = $request->input('valor');
                    break;

                case 'sindica':
                    $request->validate([
                        'valor' => 'required|string|max:255'
                    ]);
                    $gobierno->sindica_nombre = $request->input('valor');
                    $gobierno->save();
                    $data['valor'] = $request->input('valor');
                    break;

                case 'secretario':
                    $request->validate([
                        'valor' => 'required|string|max:255'
                    ]);
                    $gobierno->secretario_nombre = $request->input('valor');
                    $gobierno->save();
                    $data['valor'] = $request->input('valor');
                    break;

                default:
                    // Manejar regidores u otros campos
                    if (strpos($field, 'regidor_') === 0) {
                        $request->validate([
                            'nombre' => 'required|string|max:255',
                            'comision' => 'required|string|max:255',
                            'cargo' => 'required|string|max:50'
                        ]);

                        $index = (int) str_replace('regidor_', '', $field);
                        $regidores = $gobierno->regidores ?? [];
                        
                        $regidores[$index] = [
                            'nombre' => $request->input('nombre'),
                            'cargo' => $request->input('cargo'),
                            'comision' => $request->input('comision'),
                            'icono' => $request->input('icono', 'ri-user-line')
                        ];

                        $gobierno->regidores = $regidores;
                        $gobierno->save();
                        $data['regidor'] = $regidores[$index];
                    }
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => 'Información actualizada correctamente',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
}