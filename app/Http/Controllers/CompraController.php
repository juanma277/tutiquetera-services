<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Compra;


class CompraController extends Controller
{
    // =========================================
    // Obtener todas las Compras
    // =========================================
    public function all()
    {
        $compras = DB::select('SELECT * from compras');

        if(empty($compras)){
            return response()->json([
                'error' => true,
                'cuenta' => count($compras),
                'mensaje' => 'No existen Compras'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($compras),
            'compras' => $compras
        ]);
    }

    // =========================================
    // Obtener las Compras Paginadas
    // =========================================
    public function paginate($desde=0)
    {   
        $compras = DB::select('SELECT * from compras LIMIT 10 OFFSET '.$desde);

        if(empty($compras)){
            return response()->json([
                'error' => true,
                'cuenta' => count($compras),
                'mensaje' => 'No existen Compras'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($compras),
            'compras' => $compras
        ]);
    }

    // =========================================
    // Crear Compra
    // =========================================
    public function create(Request $request)
    {   
        try {
            $compra = DB::table('compras')->insert(
                [  
                    'metodo' => $request->metodo,
                    'user_id' => $request->user_id, 
                    'producto_id' => $request->producto_id
                ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Compra creada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Compra
    // =========================================
    public function getCategoria($id)
    {   
        $compra = Compra::find($id);

        if(empty($compra)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Compra'
            ]);
        }

        return response()->json([
            'error' => false,
            'compra' => $compra
        ]);
    }

    // =========================================
    // Actualizar Compra
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE LA COMPRA
        $compra = Compra::find($id);
        if(empty($compra)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Compra'
            ]);
        }

        try {
            $compra = DB::table('compras')
            ->where('id', $id)
            ->update([
                        'metodo' => $request->metodo,
                        'user_id' => $request->user_id, 
                        'producto_id' => $request->producto_id                    
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Compra Actualizada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Compra
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE LA COMPRA
        $compra = Compra::find($id);
        if(empty($compra)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Compra'
            ]);
        }

        try {
            DB::table('compras')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Compra Eliminada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
