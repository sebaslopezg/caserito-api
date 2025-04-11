<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class productoController extends Controller
{
    public function index(){
        $producto = Producto::all();

        if ($producto->isEmpty()) {
            $data = [
                'status' => false,
                'msg' => 'No se encontraron registros',
            ];
            return response()->json($data, 200);
        }

        $data = [
            'status' => true,
            'msg' => 'Registros encontrados',
            'data' => $producto
        ];

        return response()->json($data, 200); 
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'stock' => 'required|min:1',
            'precio' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos: ' . $validator->errors(),
                'status' => false
            ];
            return response()->json($data, 400);
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'precio' => $request->precio,
        ]);

        if (!$producto) {
            $data = [
                'msg' => 'Error al intentar crear el producto',
                'status' => false
            ];
            return response()->json($data, 500);
        }

        $data = [
            'msg' => 'Producto creado exitosamente',
            'status' => true,
            'data' => $producto
        ];

        return response()->json($data, 201);
    }

    public function show($id){
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'msg' => 'Producto no encontrado',
                'status' => false,
            ];
            return response()->json($data, 400);
        }
        $data = [
            'msg' => 'Producto encontrado',
            'status' => true,
            'data' => $producto
        ];
        return response()->json($data, 200);
    }

    public function destroy($id){
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'msg' => 'Producto no encontrado',
                'status' => false
            ];

            return response()->json($data, 400);
        }

        $producto->delete();

        $data = [
            'msg' => 'Producto eliminado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'msg' => 'No se pudo encontrar el producto',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'stock' => 'required|min:1',
            'precio' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;
        $producto->precio = $request->precio;

        $producto->save();

        $data = [
            'msg' => 'producto Actualizado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id){
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'msg' => 'No se pudo encontrar el producto',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'stock' => 'required|min:1',
            'precio' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $request->has('nombre') ? $producto->nombre = $request->nombre : '';
        $request->has('descripcion') ? $producto->descripcion = $request->descripcion : '';
        $request->has('stock') ? $producto->stock = $request->stock : '';
        $request->has('precio') ? $producto->precio = $request->precio : '';

        $producto->save();

        $data = [
            'msg' => 'producto Actualizado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }
}
