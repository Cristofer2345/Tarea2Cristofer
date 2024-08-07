<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('movies.index', compact('categories'));
    }

    public function verGenero($genero)
    {
        $category = Category::where('name', $genero)->first();

        $movies = $category->movies;
        return view('movies.genero', compact('genero', 'movies'));
    }
}
