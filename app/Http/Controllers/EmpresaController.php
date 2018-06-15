<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Empresa;

class EmpresaController extends Controller
{
    // =========================================
    // Obtener todas las Empresas
    // =========================================
    public function all()
    {
        $empresas = DB::select('SELECT * from empresas');

        if(empty($empresas)){
            return response()->json([
                'error' => true,
                'cuenta' => count($empresas),
                'mensaje' => 'No existen Empresas'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($empresas),
            'empresas' => $empresas
        ]);
    }

    // =========================================
    // Obtener las Empresas Paginadas
    // =========================================
    public function paginate($desde=0)
    {   
        $empresas = DB::select('SELECT * from empresas LIMIT 10 OFFSET '.$desde);

        if(empty($empresas)){
            return response()->json([
                'error' => true,
                'cuenta' => count($empresas),
                'mensaje' => 'No existen Empresas'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($empresas),
            'empresas' => $empresas
        ]);
    }

    // =========================================
    // Crear Empresa
    // =========================================
    public function create(Request $request)
    {   
        try {
            $empresa = DB::table('empresas')->insert(
                [  
                    'nombre' => $request->nombre,
                    'nit' => $request->nit, 
                    'telefono' => $request->telefono, 
                    'direccion' => $request->direccion, 
                    'lat' => $request->lat, 
                    'lng' => $request->lng,
                    'user_id' => $request->user_id                    
                ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Empresa creada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Empresa
    // =========================================
    public function getEmpresa($id)
    {   
        $empresa = Empresa::find($id);

        if(empty($empresa)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Empresa'
            ]);
        }

        return response()->json([
            'error' => false,
            'empresa' => $empresa
        ]);
    }

    // =========================================
    // Actualizar Empresa
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE EMPRESA
        $empresa = Empresa::find($id);
        if(empty($empresa)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Empresa'
            ]);
        }

        try {
            $empresa = DB::table('empresas')
            ->where('id', $id)
            ->update([
                        'nombre' => $request->nombre,
                        'nit' => $request->nit, 
                        'telefono' => $request->telefono, 
                        'direccion' => $request->direccion, 
                        'lat' => $request->lat, 
                        'lng' => $request->lng,
                        'estado' => $request->estado,                    
                        'user_id' => $request->user_id  
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Empresa Actualizada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Empresa
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE EL EMPRESA
        $empresa = Empresa::find($id);
        if(empty($empresa)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Empresa'
            ]);
        }

        try {
            DB::table('empresas')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Empresa Eliminada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
