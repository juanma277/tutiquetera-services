<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Producto;

class ProductoController extends Controller
{
    // =========================================
    // Obtener todas los Productos
    // =========================================
    public function all()
    {
        $productos = DB::select('SELECT * from productos');

        if(empty($productos)){
            return response()->json([
                'error' => true,
                'cuenta' => count($productos),
                'mensaje' => 'No existen productos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($productos),
            'productos' => $productos
        ]);
    }

    // =========================================
    // Obtener los Productos Paginados
    // =========================================
    public function paginate($desde=0)
    {   
        $productos = DB::select('SELECT * from productos LIMIT 10 OFFSET '.$desde);

        if(empty($productos)){
            return response()->json([
                'error' => true,
                'cuenta' => count($productos),
                'mensaje' => 'No existen Productos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($productos),
            'productos' => $productos
        ]);
    }

    // =========================================
    // Crear Producto
    // =========================================
    public function create(Request $request)
    {   
        try {
            $producto = DB::table('productos')->insert(
                [  
                    'nombre' => $request->nombre,
                    'precio' => $request->precio, 
                    'descripcion' => $request->descripcion, 
                    'cantidad' => $request->cantidad, 
                    'categoria_id' => $request->categoria,
                    'categoria_id' => $request->categoria,

                ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Producto creado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Producto
    // =========================================
    public function getProducto($id)
    {   
        $producto = Producto::find($id);

        if(empty($producto)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Producto'
            ]);
        }

        return response()->json([
            'error' => false,
            'producto' => $producto
        ]);
    }

    // =========================================
    // Actualizar Producto
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE PRODUCTO
        $producto = Producto::find($id);
        if(empty($producto)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Producto'
            ]);
        }

        try {
            $producto = DB::table('productos')
            ->where('id', $id)
            ->update([
                        'nombre' => $request->nombre,
                        'estado' => $request->estado, 
                        'precio' => $request->precio, 
                        'descripcion' => $request->descripcion, 
                        'cantidad' => $request->cantidad, 
                        'categoria_id' => $request->categoria 
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Producto Actualizado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Producto
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE EL PRODUCTO
        $producto = Producto::find($id);
        if(empty($producto)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Producto'
            ]);
        }

        try {
            DB::table('productos')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Producto Eliminado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
