<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;
use App\Models\Tarea;

class TareaController extends Controller
{
    public function index()
    {
        return TareaResource::collection(
            Tarea::latest()->paginate(10)
        );
    }

    public function store(TareaRequest $request)
    {
        $tarea = Tarea::create($request->validated());
        return (new TareaResource($tarea))
            ->response()->setStatusCode(201);
    }

    public function show(Tarea $tarea)
    {
        return new TareaResource($tarea);
    }

    public function update(TareaRequest $request, Tarea $tarea)
    {
        $tarea->update($request->validated());
        return new TareaResource($tarea);
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return response()->json(null, 204);
    }
}