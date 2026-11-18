<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Receta;
use App\Http\Resources\RecetaResource;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreRecetasRequest;
use App\Http\Requests\UpdateRecetasRequest;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RecetaController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('Ver recetas', Receta::class);
        return RecetaResource::collection(Receta::with('categoria','etiquetas','user')->get());
    }

    public function show(Receta $receta)
    {
        $this->authorize('Ver recetas', $receta);
        return new RecetaResource($receta->load('categoria','etiquetas','user'));
    }

    public function store(StoreRecetasRequest $request){ 
        $this->authorize('Crear recetas', Receta::class);
        $receta = $request->user()->recetas()->create($request->all());
        //$receta = Receta::create($request->all()); 
        $receta->etiquetas()->attach(json_decode($request->etiquetas)); 

        $receta->imagen = $request->file('imagen')->store('recetas','public'); 
        $receta->save();
        
        return response()->json(new RecetaResource($receta), Response::HTTP_CREATED); // 201 Created 
    }

    public function update(UpdateRecetasRequest $request, Receta $receta){ 
        $this->authorize('update', $receta);    
        $this->authorize('Editar recetas', $receta);
    
        $receta->update($request->all()); 
        if($etiquetas = json_decode($request->etiquetas)){ 
            $receta->etiquetas()->sync($etiquetas); 
        } 
        
        if($request->file('imagen')){ 
            $receta->imagen = $request->file('imagen')->store('recetas','public'); 
            $receta->save(); 
        }

        return response()->json(new RecetaResource($receta), Response::HTTP_OK); // 200 
    }

    public function destroy(Receta $receta){ 
        $this->authorize('delete', $receta);
        $this->authorize('Eliminar recetas', $receta);
        
        $receta->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT); // 204 No Content 
    }

}
