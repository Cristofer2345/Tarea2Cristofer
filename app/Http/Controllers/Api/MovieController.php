<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Policies\PeliculaPolicy;
class MovieController extends Controller
{
    protected $policy;

    public function __construct(PeliculaPolicy $policy)
    {
        $this->policy = $policy;
    }

    public function index(Request $request)
    {
        
        if (!$this->policy->ordenar($request)) {
            return response()->json(['error' => 'Parámetros de ordenación no válidos'], 400);
        }

        $campoOrden = $request->query('campo_orden', 'id'); 
        $orden = $request->query('orden', 'asc'); 

      
        $peliculas = Movie::orderBy($campoOrden, $orden)->get();

        return response()->json($peliculas,200);
    }
 
  public function indexMovie(){

    $Movie = Movie::all();
return response()->json($Movie);

  }

  public function getById($id){

     $Movie = Movie::find($id);
      if (!$Movie){

        return response()->json(['error' => 'Película no encontrada'], 404); 
      }
      return response()->json($Movie);
  }
  public function update(Request $request, $id)
    {
      
        $pelicula = Movie::find($id);

        if (!$pelicula) {
            return response()->json(['error' => 'Película no encontrada'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'studio' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $pelicula->update($request->all());

        return response()->json($pelicula,200);
    }
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'year' => 'required|string|max:4',
        'studio' => 'required|string|max:255',
        'category_id' => 'required|integer|exists:categories,id',
    ]);

    $pelicula = Movie::create([
        'title' => $request->input('title'),
        'year' => $request->input('year'),
        'studio' => $request->input('studio'),
        'category_id' => $request->input('category_id'),
    ]);

    return response()->json($pelicula, 201);
}

}
