<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Receta;
use App\Http\Resources\RecetaResource;

class RecetaController extends Controller
{
    public function index()
    {
        return RecetaResource::collection(Receta::with('categoria','etiquetas','user')->get());
    }

    public function show(Receta $receta)
    {
        return new RecetaResource($receta->load('categoria','etiquetas','user'));
    }
}
