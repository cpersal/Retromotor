<?php

namespace Database\Seeders;

use App\Models\Pieza;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PiezasTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate([
            'email' => 'vendedor@example.com'
        ], [
            'name' => 'Vendedor Ejemplo',
            'password' => bcrypt('password')
        ]);

        $piezasData = [
            [
                'categoria' => 'Amortiguador',
                'marca' => 'KYB',
                'modelo' => 'Excel-G',
                'motor' => '1.8L 4 cilindros',
                'año' => 2018,
                'estado' => 'Nuevo',
                'precio' => 85.99,
                'user_id' => $user->id,
                'titulo' => 'Amortiguador Delantero KYB Excel-G',
                'descripcion' => 'Amortiguador nuevo para suspensión delantera, compatible con varios modelos.',
                'imagen_original' => '3.png'
            ],
            [
                'categoria' => 'Amortiguador',
                'marca' => 'Monroe',
                'modelo' => 'OESpectrum',
                'motor' => '2.0L Turbo',
                'año' => 2020,
                'estado' => 'Reconstruido',
                'precio' => 65.50,
                'user_id' => $user->id,
                'titulo' => 'Amortiguador Trasero Monroe Reconstruido',
                'descripcion' => 'Amortiguador trasero reconstruido con garantía de 1 año.',
                'imagen_original' => '5.png'
            ],
            [
                'categoria' => 'Frenos',
                'marca' => 'Brembo',
                'modelo' => 'P06047',
                'motor' => null,
                'año' => 2019,
                'estado' => 'Nuevo',
                'precio' => 120.00,
                'user_id' => $user->id,
                'titulo' => 'Juego de Pastillas de Freno Brembo',
                'descripcion' => 'Pastillas de freno delanteras de alta calidad, menor ruido y polvo.',
                'imagen_original' => '1.png'
            ],
            [
                'categoria' => 'Frenos',
                'marca' => 'ACDelco',
                'modelo' => '17D1367CH',
                'motor' => '3.5L V6',
                'año' => 2017,
                'estado' => 'Nuevo',
                'precio' => 89.99,
                'user_id' => $user->id,
                'titulo' => 'Disco de Freno Delantero ACDelco',
                'descripcion' => 'Disco de freno ventilado, diámetro 312mm, grosor 28mm.',
                'imagen_original' => '4.png'
            ],
            [
                'categoria' => 'Transmisión',
                'marca' => 'Aisin',
                'modelo' => 'TB-50SN',
                'motor' => '2.4L',
                'año' => 2015,
                'estado' => 'Usado',
                'precio' => 250.00,
                'user_id' => $user->id,
                'titulo' => 'Kit de Reparación de Transmisión Aisin',
                'descripcion' => 'Kit completo con sellos, juntas y filtro para reconstrucción.',
                'imagen_original' => '2.png'
            ],
            [
                'categoria' => 'Motor',
                'marca' => 'Bosch',
                'modelo' => '0280158007',
                'motor' => '1.6L MPI',
                'año' => 2016,
                'estado' => 'Nuevo',
                'precio' => 135.75,
                'user_id' => $user->id,
                'titulo' => 'Inyector de Combustible Bosch',
                'descripcion' => 'Inyector nuevo original de fábrica, flujo de 210cc/min.',
                'imagen_original' => '5.png'
            ],
            [
                'categoria' => 'Motor',
                'marca' => 'Gates',
                'modelo' => 'TCK328',
                'motor' => '2.0L TDI',
                'año' => 2018,
                'estado' => 'Nuevo',
                'precio' => 175.30,
                'user_id' => $user->id,
                'titulo' => 'Kit de Correa de Distribución Gates',
                'descripcion' => 'Kit completo con bomba de agua, tensor y correa.',
                'imagen_original' => '1.png'
            ],
            [
                'categoria' => 'Electricidad',
                'marca' => 'Denso',
                'modelo' => '2349035',
                'motor' => null,
                'año' => 2020,
                'estado' => 'Nuevo',
                'precio' => 95.40,
                'user_id' => $user->id,
                'titulo' => 'Alternador Denso 120A',
                'descripcion' => 'Alternador nuevo, 12V, 120 amperes, con garantía de 2 años.',
                'imagen_original' => '2.png'
            ],
            [
                'categoria' => 'Suspensión',
                'marca' => 'Moog',
                'modelo' => 'RK620855',
                'motor' => null,
                'año' => 2019,
                'estado' => 'Nuevo',
                'precio' => 42.80,
                'user_id' => $user->id,
                'titulo' => 'Terminal de Dirección Moog',
                'descripcion' => 'Terminal de dirección interno, lado izquierdo.',
                'imagen_original' => '3.png'
            ],
            [
                'categoria' => 'Escape',
                'marca' => 'Walker',
                'modelo' => '55256',
                'motor' => '1.8L',
                'año' => 2017,
                'estado' => 'Nuevo',
                'precio' => 210.00,
                'user_id' => $user->id,
                'titulo' => 'Catalizador Walker',
                'descripcion' => 'Convertidor catalítico universal, cumplimiento EPA.',
                'imagen_original' => '4.png'
            ],
            [
                'categoria' => 'Carrocería',
                'marca' => 'Depo',
                'modelo' => '3121111L',
                'motor' => null,
                'año' => 2018,
                'estado' => 'Nuevo',
                'precio' => 75.25,
                'user_id' => $user->id,
                'titulo' => 'Farola Delantera Izquierda Depo',
                'descripcion' => 'Farola completa con lente de policarbonato, incluye bombillas.',
                'imagen_original' => '5.png'
            ],
            [
                'categoria' => 'Interior',
                'marca' => 'Dorman',
                'modelo' => '741121',
                'motor' => null,
                'año' => 2019,
                'estado' => 'Nuevo',
                'precio' => 32.99,
                'user_id' => $user->id,
                'titulo' => 'Manilla de Puerta Dorman',
                'descripcion' => 'Manilla interior derecha, color negro, plástico reforzado.',
                'imagen_original' => '1.png'
            ],
            [
                'categoria' => 'Refrigeración',
                'marca' => 'Spectra',
                'modelo' => 'CU1910',
                'motor' => '2.5L',
                'año' => 2016,
                'estado' => 'Nuevo',
                'precio' => 145.60,
                'user_id' => $user->id,
                'titulo' => 'Radiador Spectra',
                'descripcion' => 'Radiador de aluminio y plástico, 32mm de espesor.',
                'imagen_original' => '2.png'
            ],
            [
                'categoria' => 'Transmisión',
                'marca' => 'LuK',
                'modelo' => '17-050',
                'motor' => '1.4L Turbo',
                'año' => 2020,
                'estado' => 'Reconstruido',
                'precio' => 320.00,
                'user_id' => $user->id,
                'titulo' => 'Embrague LuK Kit Completo',
                'descripcion' => 'Kit de embrague completo con disco, plato y collarín.',
                'imagen_original' => '3.png'
            ],
            [
                'categoria' => 'Motor',
                'marca' => 'NGK',
                'modelo' => 'LFR5A-11',
                'motor' => '1.6L DOHC',
                'año' => 2019,
                'estado' => 'Nuevo',
                'precio' => 8.50,
                'user_id' => $user->id,
                'titulo' => 'Bujía NGK Iridio',
                'descripcion' => 'Bujía de iridio, gap pre-ajustado, mayor vida útil.',
                'imagen_original' => '4.png'
            ],
        ];

        foreach ($piezasData as $data) {
            $imagenOriginal = $data['imagen_original'];
            unset($data['imagen_original']);
            $pieza = Pieza::create($data);
            $rutaImagenOriginal = 'piezas/originales/' . $imagenOriginal;
            if (Storage::disk('public')->exists($rutaImagenOriginal)) {
                $this->procesarImagen($pieza, $rutaImagenOriginal);
                echo "✓ Procesada imagen para: {$pieza->titulo}\n";
            } else {
                echo "⚠ Imagen no encontrada: {$rutaImagenOriginal}\n";
            }
        }
    }

    private function procesarImagen(Pieza $pieza, $rutaImagenOriginal)
    {
        try {
            $manager = new ImageManager(new Driver());
            // Obtener la ruta completa del archivo
            $rutaCompleta = Storage::disk('public')->path($rutaImagenOriginal);
            // Leer la imagen original
            $imagenOriginal = $manager->read($rutaCompleta);
            $anchoOriginal = $imagenOriginal->width();
            $altoOriginal = $imagenOriginal->height();
            $altoDeseado = 400;
            $ratioAspecto = $anchoOriginal / $altoOriginal;
            $anchoCalculado = round($altoDeseado * $ratioAspecto);

            // Crear miniatura
            $miniatura = $imagenOriginal
                ->resize($anchoCalculado, $altoDeseado)
                ->toJpeg(80);
            $nombreArchivo = pathinfo($rutaImagenOriginal, PATHINFO_BASENAME);
            $rutaMiniatura = 'piezas/miniaturas/' . $nombreArchivo;
            $directorioMiniaturas = dirname(Storage::disk('public')->path($rutaMiniatura));
            if (!is_dir($directorioMiniaturas)) {
                mkdir($directorioMiniaturas, 0755, true);
            }
            // Guardar miniatura
            Storage::disk('public')->put($rutaMiniatura, $miniatura);
            $pieza->update([
                'foto' => $rutaImagenOriginal,
                'miniatura' => $rutaMiniatura
            ]);
        } catch (\Exception $e) {
            echo "Error procesando imagen para pieza {$pieza->id}: " . $e->getMessage() . "\n";
        }
    }
}
