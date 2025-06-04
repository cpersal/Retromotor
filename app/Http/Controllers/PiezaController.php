<?php

namespace App\Http\Controllers;

use App\Models\Pieza;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PiezaController extends Controller
{
    //mostrar todas las piezas con busqueda
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'categoria' => ['nullable', 'string', 'max:255'],
            'marca' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'max:255'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $query = Pieza::query();

        if (!empty($validated['search'])) {
            $searchTerm = $validated['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('titulo', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('marca', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('modelo', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('motor', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if (!empty($validated['categoria'])) {
            $query->where('categoria', $validated['categoria']);
        }

        if (!empty($validated['marca'])) {
            $query->where('marca', $validated['marca']);
        }

        if (!empty($validated['estado'])) {
            $query->where('estado', $validated['estado']);
        }

        if (!empty($validated['min_price'])) {
            $query->where('precio', '>=', $validated['min_price']);
        }

        if (!empty($validated['max_price'])) {
            $query->where('precio', '<=', $validated['max_price']);
        }

        $categorias = Pieza::select('categoria')->distinct()->orderBy('categoria')->pluck('categoria');
        $estados = Pieza::select('estado')->distinct()->orderBy('estado')->pluck('estado');
        $marcas = Pieza::select('marca')->distinct()->orderBy('marca')->pluck('marca');

        $piezas = $query->latest()->paginate(12)->withQueryString();

        return view('piezas.index', compact('piezas', 'categorias', 'estados', 'marcas'));
    }

    //enseñar pieza concreta
    public function show(Pieza $pieza)
    {
        return view('piezas.show', compact('pieza'));
    }

    public function create()
    {
        return view('piezas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año' => 'required|integer|min:1900|max:' . date('Y'),
            'estado' => 'required|string|in:Nuevo,Usado,Reconstruido',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'required|string',
            'foto' => 'required|image|max:8192',
            'motor' => 'nullable|string|max:255'
        ]);

        $datospieza = $validated;
        unset($datospieza['foto']); // Remover foto de los datos

        $pieza = Pieza::create(array_merge(
            $datospieza,
            ['user_id' => auth()->id()]
        ));
        //se crea la miniatura
        if ($request->hasFile('foto')) {
            $pieza->guardarImagenes($request->file('foto'));
        }

        return redirect()->route('piezas.show', $pieza)->with('success', 'Pieza creada exitosamente');
    }

    public function edit(Pieza $pieza)
    {
        // Verificar que el usuario es el propietario
        if (auth()->id() !== $pieza->user_id) {
            abort(403);
        }
        $categorias = Pieza::select('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('piezas.edit', compact('pieza', 'categorias'));
    }

    public function update(Request $request, Pieza $pieza)
    {
        if (auth()->id() !== $pieza->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año' => 'required|integer|min:1900|max:' . date('Y'),
            'estado' => 'required|string|in:Nuevo,Usado,Reconstruido',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'required|string',
            'foto' => 'nullable|image|max:8192',
            'motor' => 'nullable|string|max:255',
            'categoria' => ['required', 'string', Rule::in(Pieza::select('categoria')->distinct()->pluck('categoria')->toArray())],
        ]);
        $datosActualizar = $validated;
        unset($datosActualizar['foto']);

        $pieza->update($datosActualizar);
        if ($request->hasFile('foto')) {
            $pieza->guardarImagenes($request->file('foto'));
        }

        return redirect()->route('piezas.show', $pieza)->with('success', 'Pieza actualizada exitosamente');
    }

    public function destroy(Pieza $pieza)
    {
        if (auth()->id() !== $pieza->user_id) {
            abort(403);
        }
        $pieza->delete();

        return redirect()->route('piezas.index')->with('success', 'Pieza eliminada exitosamente');
    }

    public function showVendedor(User $user)
    {
        $piezas = Pieza::where('user_id', $user->id)->latest()->paginate(12);

        return view('vendedor.show', [
            'vendedor' => $user,
            'piezas' => $piezas
        ]);
    }

    public function miPerfil()
    {
        if (auth()->check()) {
            return redirect()->route('vendedor.show', auth()->user());
        }

        return redirect()->route('login');
    }
}
