<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Pieza extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria',
        'marca',
        'modelo',
        'motor',
        'año',
        'estado',
        'precio',
        'titulo',
        'descripcion',
        'foto',
        'miniatura',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guardarImagenes($imagen)
    {
        $this->eliminarImagenes();
        $rutaOriginal = $imagen->store('piezas/originales', 'public');
        $manager = new ImageManager(new Driver());
        $imagenOriginal = $manager->read($imagen->getRealPath());
        $anchoOriginal = $imagenOriginal->width();
        $altoOriginal = $imagenOriginal->height();
        // Calcular nuevas dimensiones manteniendo el ratio de aspecto
        $altoDeseado = 400;
        $ratioAspecto = $anchoOriginal / $altoOriginal;
        $anchoCalculado = round($altoDeseado * $ratioAspecto);
        // Crear miniatura
        $miniatura = $imagenOriginal
            ->resize($anchoCalculado, $altoDeseado)
            ->toJpeg(80); // 80% de calidad

        $nombreArchivo = pathinfo($rutaOriginal, PATHINFO_BASENAME);
        $rutaMiniatura = 'piezas/miniaturas/' . $nombreArchivo;
        Storage::disk('public')->put($rutaMiniatura, $miniatura);
        $this->update([
            'foto' => $rutaOriginal,
            'miniatura' => $rutaMiniatura
        ]);
    }

    public function eliminarImagenes()
    {
        if ($this->foto) {
            Storage::disk('public')->delete($this->foto);
        }
        if ($this->miniatura) {
            Storage::disk('public')->delete($this->miniatura);
        }
    }
    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function usuariosFavoritos()
    {
        return $this->belongsToMany(User::class, 'favoritos');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pieza) {
            $pieza->eliminarImagenes();
        });
    }
}
