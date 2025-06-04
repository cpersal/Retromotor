<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Favorito;
use App\Models\Pieza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    //cambiar el estado de un favorito
    public function toggle(Pieza $pieza)
    {
        $user = Auth::user();

        try {
            $favorito = Favorito::firstOrNew([
                'user_id' => $user->id,
                'pieza_id' => $pieza->id
            ]);

            if ($favorito->exists) {
                $favorito->delete();
                return response()->json([
                    'status' => 'removed',
                    'message' => 'Eliminado de favoritos'
                ]);
            } else {
                $favorito->save();
                return response()->json([
                    'status' => 'added',
                    'message' => 'Añadido a favoritos'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    //mostrar las piezas favortias del usuario
    public function index()
    {
        $piezas = Auth::user()->piezasFavoritas()
            ->with('user')
            ->paginate(12);

        return view('favoritos.index', compact('piezas'));
    }
}
