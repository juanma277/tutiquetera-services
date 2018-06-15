<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Categoria;

class CategoriaController extends Controller
{
    // =========================================
    // Obtener todas las Categorias
    // =========================================
    public function all()
    {
        $categorias = DB::select('SELECT * from categorias');

        if(empty($categorias)){
            return response()->json([
                'error' => true,
                'cuenta' => count($categorias),
                'mensaje' => 'No existen Categorias'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($categorias),
            'categorias' => $categorias
        ]);
    }

    // =========================================
    // Obtener las Categorias Paginadas
    // =========================================
    public function paginate($desde=0)
    {   
        $categorias = DB::select('SELECT * from categorias LIMIT 10 OFFSET '.$desde);

        if(empty($categorias)){
            return response()->json([
                'error' => true,
                'cuenta' => count($categorias),
                'mensaje' => 'No existen Categorias'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($categorias),
            'categorias' => $categorias
        ]);
    }

    // =========================================
    // Crear Categoria
    // =========================================
    public function create(Request $request)
    {   
        try {
            $categoria = DB::table('categorias')->insert(
                [  
                    'nombre' => $request->nombre
                ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Categoria creada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Categoria
    // =========================================
    public function getCategoria($id)
    {   
        $categoria = Categoria::find($id);

        if(empty($categoria)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Categoria'
            ]);
        }

        return response()->json([
            'error' => false,
            'categoria' => $categoria
        ]);
    }

    // =========================================
    // Actualizar Categoria
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE LA CATEGORIA
        $categoria = Categoria::find($id);
        if(empty($categoria)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Categoria'
            ]);
        }

        try {
            $categoria = DB::table('categorias')
            ->where('id', $id)
            ->update([
                        'nombre' => $request->nombre,
                        'estado' => $request->estado,                    
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Categoria Actualizada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Categoria
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE LA CATEGORIA
        $categoria = Categoria::find($id);
        if(empty($categoria)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Categoria'
            ]);
        }

        try {
            DB::table('categorias')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Categoria Eliminada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
