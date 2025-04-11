<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Validator;

class registroController extends Controller
{
    public function index(){
        $data = [
            'status' => false,
            'msg' => 'Error desconocido'
        ];
        $registros = Registro::all();

        if ($registros->isEmpty()) {
            $data = [
                'status' => false,
                'msg' => 'No se encontraron registros',
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
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:registro',
            //'telefono' => 'required|digits:10' //valida cantidad de digitos, 
            //'image' => 'required|image|dimensions:min_width=200,min_height=200, //valida cantidad de digitos 
            //'genero' => 'required|in:macho,hembra,nosesabe' ,
            //El in en el validador permite que se valide solo los strings que se pongan allí
            /*
            Para guardar imagenes:
            $registro = new Registro($request->all());
            $path = $request->image->store('public/img');
            $registro->save();
            */
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos: ' . $validator->errors(),
                'status' => false
            ];
            return response()->json($data, 400);
        }

        $registro = Registro::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
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
        $registro = Registro::find($id);

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
        $registro = Registro::find($id);

        if (!$registro) {
            $data = [
                'msg' => 'Registro no encontrado',
                'status' => false
            ];

            return response()->json($data, 400);
        }

        $registro->delete();

        $data = [
            'msg' => 'Registro eliminado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $registro = Registro::find($id);

        if (!$registro) {
            $data = [
                'msg' => 'No se pudo encontrar el registro',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $registro->nombre = $request->nombre;
        $registro->apellido = $request->apellido;
        $registro->email = $request->email;

        $registro->save();

        $data = [
            'msg' => 'Registro Actualizado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id){
        $registro = Registro::find($id);

        if (!$registro) {
            $data = [
                'msg' => 'No se pudo encontrar el registro',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'max:366',
            'apellido' => 'max:366',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $request->has('nombre') ? $registro->nombre = $request->nombre : '';
        $request->has('apellido') ? $registro->apellido = $request->apellido : '';
        $request->has('email') ? $registro->email = $request->email : '';

        $registro->save();

        $data = [
            'msg' => 'Registro Actualizado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }
}