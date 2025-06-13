<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

class reviewController extends Controller
{
    public function index(){
        $data = [
            'status' => false,
            'msg' => 'Error desconocido'
        ];
        $registros = Review::all()->where('status','>',0);

        if ($registros->isEmpty()) {
            $data = [
                'status' => false,
                'msg' => 'No se encontraron reseñas',
            ];
        }else{
            $data = [
                'status' => true,
                'msg' => 'Registros encontrados',
                'data' => $registros
            ];
        }

        return response()->json($data, 200);
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required',
            'nombre' => 'required',
            'comentario' => 'nullable',
            'puntuacion' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos: ' . $validator->errors(),
                'status' => false
            ];
            return response()->json($data, 400);
        }

        $registro = Review::create([
            'producto_id' => $request->producto_id,
            'nombre' => $request->nombre,
            'comentario' => $request->comentario,
            'puntuacion' => $request->puntuacion,
            'status' => 1,
        ]);

        if (!$registro) {
            $data = [
                'msg' => 'Error al intentar crear el registro',
                'status' => false
            ];
            return response()->json($data, 500);
        }

        $data = [
            'msg' => 'Registro creado exitosamente',
            'status' => true,
            'data' => $registro
        ];

        return response()->json($data, 201);
    }


    public function show($id){
        $registro = Review::find($id)->where('status','>',0);

        if (!$registro) {
            $data = [
                'msg' => 'Registro no encontrado',
                'status' => false,
            ];
            return response()->json($data, 400);
        }
        $data = [
            'msg' => 'Registro encontrado',
            'status' => true,
            'data' => $registro
        ];
        return response()->json($data, 200);
    }


    public function destroy($id){
        $registro = Review::find($id);

        if (!$registro) {
            $data = [
                'msg' => 'Registro no encontrado',
                'status' => false
            ];

            return response()->json($data, 400);
        }

        $registro->status = 0;
        $registro->save();

        $data = [
            'msg' => 'Registro eliminado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

}
