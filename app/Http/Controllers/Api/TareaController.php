<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index(Request $request)
    {
        return TareaResource::collection(
            $request->user()->tareas()->latest()->paginate(10)
        );
    }

    public function store(TareaRequest $request)
    {
        $tarea = $request->user()->tareas()->create($request->validated());

        return (new TareaResource($tarea))
            ->response()->setStatusCode(201);
    }

    public function show(Request $request, Tarea $tarea)
    {
        $this->autorizarDueno($request, $tarea);

        return new TareaResource($tarea);
    }

    public function update(TareaRequest $request, Tarea $tarea)
    {
        $this->autorizarDueno($request, $tarea);

        $tarea->update($request->validated());

        return new TareaResource($tarea);
    }

    public function destroy(Request $request, Tarea $tarea)
    {
        $this->autorizarDueno($request, $tarea);

        $tarea->delete();

        return response()->json(null, 204);
    }

    private function autorizarDueno(Request $request, Tarea $tarea): void
    {
        abort_unless($tarea->user_id === $request->user()->id, 403);
    }
}