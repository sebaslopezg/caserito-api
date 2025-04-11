<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Items;

class itemsController extends Controller
{
    public function index(){
        $data = [
            'status' => false,
            'msg' => 'Error desconocido'
        ];
        $items = Items::all();

        if ($items->isEmpty()) {
            $data = [
                'status' => false,
                'msg' => 'No se encontraron items',
            ];
        }else{
            $data = [
                'status' => true,
                'msg' => 'Items encontrados',
                'data' => $items
            ];
        }

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'venta_id' => 'required',
            'producto_id' => 'required',
            'precio' => 'required|min:1',
            'cantidad' => 'required|min:1',
            'total' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos: ',
                'errors' => $validator->errors(),
                'status' => false
            ];
            return response()->json($data, 400);
        }

        $items = Items::create([
            'venta_id' => $request->venta_id,
            'producto_id' => $request->producto_id,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'total' => $request->total,
        ]);

        if (!$items) {
            $data = [
                'msg' => 'Error al intentar crear los items',
                'status' => false
            ];
            return response()->json($data, 500);
        }

        $data = [
            'msg' => 'Items creados exitosamente',
            'status' => true,
            'data' => $items
        ];

        return response()->json($data, 201);
    }

    public function show($id){
        $items = Items::find($id);

        if (!$items) {
            $data = [
                'msg' => 'Items no encontrados',
                'status' => false,
            ];
            return response()->json($data, 400);
        }
        $data = [
            'msg' => 'Items encontrados',
            'status' => true,
            'data' => $items
        ];
        return response()->json($data, 200);
    }

    public function destroy($id){
        $items = Items::find($id);

        if (!$items) {
            $data = [
                'msg' => 'Items no encontrado',
                'status' => false
            ];

            return response()->json($data, 400);
        }

        $items->delete();

        $data = [
            'msg' => 'Items eliminado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $items = Items::find($id);

        if (!$items) {
            $data = [
                'msg' => 'No se pudo encontrar los items',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'venta_id' => 'required',
            'producto_id' => 'required',
            'precio' => 'required|min:1',
            'cantidad' => 'required|min:1',
            'total' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $items->venta_id = $request->venta_id;
        $items->producto_id = $request->producto_id;
        $items->precio = $request->precio;
        $items->cantidad = $request->cantidad;
        $items->total = $request->total;

        $items->save();

        $data = [
            'msg' => 'Items Actualizados',
            'status' => true,
        ];

        return response()->json($data, 200);
    }
    
    public function updatePartial(Request $request, $id){
        $items = Items::find($id);

        if (!$items) {
            $data = [
                'msg' => 'No se pudo encontrar el item',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'precio' => 'min:1',
            'cantidad' => 'min:1',
            'total' => 'min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $request->has('venta_id') ? $items->venta_id = $request->venta_id : '';
        $request->has('producto_id') ? $items->producto_id = $request->producto_id : '';
        $request->has('precio') ? $items->precio = $request->precio : '';
        $request->has('cantidad') ? $items->cantidad = $request->cantidad : '';
        $request->has('total') ? $items->total = $request->total : '';

        $items->save();

        $data = [
            'msg' => 'Item Actualizado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }
}
