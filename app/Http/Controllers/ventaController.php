<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\Validator;

class ventaController extends Controller
{
    public function index(){
        $data = [
            'status' => false,
            'msg' => 'Error desconocido'
        ];
        $venta = Venta::all();

        if ($venta->isEmpty()) {
            $data = [
                'status' => false,
                'msg' => 'No se encontraron ventas',
            ];
        }else{
            $data = [
                'status' => true,
                'msg' => 'Ventas encontradas',
                'data' => $venta
            ];
        }

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'total' => 'required|min:1',
            'recibido' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false
            ];
            return response()->json($data, 400);
        }

        $venta = Venta::create([
            'total' => $request->total,
            'recibido' => $request->recibido,
        ]);

        if (!$venta) {
            $data = [
                'msg' => 'Error al intentar registrar la venta',
                'status' => false
            ];
            return response()->json($data, 500);
        }

        $data = [
            'msg' => 'Venta registrada exitosamente',
            'status' => true,
            'data' => $venta
        ];

        return response()->json($data, 201);
    }

    public function show($id){
        $venta = Venta::find($id);

        if (!$venta) {
            $data = [
                'msg' => 'Venta no encontrada',
                'status' => false,
            ];
            return response()->json($data, 400);
        }
        $data = [
            'msg' => 'Venta encontrado',
            'status' => true,
            'data' => $venta
        ];
        return response()->json($data, 200);
    }

    public function destroy($id){
        $venta = Venta::find($id);

        if (!$venta) {
            $data = [
                'msg' => 'Venta no encontrada',
                'status' => false
            ];

            return response()->json($data, 400);
        }

        $venta->delete();

        $data = [
            'msg' => 'Venta eliminado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $venta = Venta::find($id);

        if (!$venta) {
            $data = [
                'msg' => 'No se pudo encontrar la venta',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'total' => 'required|min:1',
            'recibido' => 'required|min:1'
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $venta->total = $request->total;
        $venta->recibido = $request->recibido;

        $venta->save();

        $data = [
            'msg' => 'Venta Actualizada',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id){
        $venta = Venta::find($id);

        if (!$venta) {
            $data = [
                'msg' => 'No se pudo encontrar la venta',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'total' => 'required|min:1',
            'recibido' => 'required|min:1'
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $request->has('total') ? $venta->total = $request->total : '';
        $request->has('recibido') ? $venta->recibido = $request->recibido : '';

        $venta->save();

        $data = [
            'msg' => 'Venta Actualizada',
            'status' => true,
        ];

        return response()->json($data, 200);
    }
}
