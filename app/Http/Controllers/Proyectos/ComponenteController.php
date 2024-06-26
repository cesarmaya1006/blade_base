<?php

namespace App\Http\Controllers\Proyectos;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Empleado;
use App\Models\Proyectos\Proyecto;
use Illuminate\Http\Request;

class ComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($proyecto_id)
    {
        $proyecto = Proyecto::FindOrFail($proyecto_id);
        $lider = $proyecto->lider;
        $ids_empresas = [];

        if ($lider->empresas_tranv->count() > 0) {
            foreach ($lider->empresas_tranv as $empresa) {
                $ids_empresas[] = $empresa->id;
            }
            $empleados1 = Empleado::where('estado', 1)
                ->whereHas('cargo', function ($p) use ($ids_empresas) {
                    $p->whereHas('area', function ($q) use ($ids_empresas) {
                        $q->whereIn('empresa_id', $ids_empresas);
                    });
                })->get();
            $empleados2 = Empleado::where('estado', 1)
                ->whereHas('cargo', function ($p) use ($ids_empresas) {
                    $p->whereHas('area', function ($q) use ($ids_empresas) {
                        $q->whereNotIn('empresa_id', $ids_empresas);
                    });
                })->whereHas('empresas_tranv', function ($p) use ($proyecto) {
                    $p->where('empresa_id', $proyecto->empresa_id);
                })->get();
            $empleados = $empleados1->concat($empleados2);
        } else {
            $empleados = Empleado::where('estado', 1)
                ->whereHas('cargo', function ($p) use ($proyecto) {
                    $p->whereHas('area', function ($q) use ($proyecto) {
                        $q->where('empresa_id', $proyecto->empresa_id);
                    });
                })->get();
        }
        return view('intranet.proyectos.componente.crear', compact('proyecto', 'empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $proyecto_id)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
