<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(){
        $data = [
            'status' => false,
            'msg' => 'Error desconocido'
        ];
        $users = User::all();

        if ($users->isEmpty()) {
            $data = [
                'status' => false,
                'msg' => 'No se encontraron usuarios',
            ];
        }else{
            $data = [
                'status' => true,
                'msg' => 'usuarios encontrados',
                'data' => $users
            ];
        }

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$user) {
            $data = [
                'msg' => 'Error al intentar crear el usuario',
                'status' => false
            ];
            return response()->json($data, 500);
        }

        $data = [
            'msg' => 'Usuario creado exitosamente',
            'status' => true,
            'data' => $user
        ];

        return response()->json($data, 201);
    }

    public function show($id){
        $user = User::find($id);

        if (!$user) {
            $data = [
                'msg' => 'usuario no encontrado',
                'status' => false,
            ];
            return response()->json($data, 400);
        }
        $data = [
            'msg' => 'Usuario encontrado',
            'status' => true,
            'data' => $user
        ];
        return response()->json($data, 200);
    }

    public function destroy($id){
        $user = User::find($id);

        if (!$user) {
            $data = [
                'msg' => 'usuario no encontrado',
                'status' => false
            ];

            return response()->json($data, 400);
        }

        $user->delete();

        $data = [
            'msg' => 'Usuario eliminado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        if (!$user) {
            $data = [
                'msg' => 'No se pudo encontrar el usuario',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();

        $data = [
            'msg' => 'Usuario Actualizado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id){
        $user = User::find($id);

        if (!$user) {
            $data = [
                'msg' => 'No se pudo encontrar el usuario',
                'status' => false,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:366',
            'email' => 'required|email',
            'password' => 'max:366',
        ]);

        if ($validator->fails()) {
            $data = [
                'msg' => 'Error en validacion de datos',
                'errors' => $validator->errors(),
                'status' => false,
            ];
            return response()->json($data, 400);
        }

        $request->has('name') ? $user->name = $request->name : '';
        $request->has('email') ? $user->email = $request->email : '';
        $request->has('password') ? $user->password = $request->password : '';

        $user->save();

        $data = [
            'msg' => 'Usuario Actualizado',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token-name')->plainTextToken,
        ], 201);
    }

    public function login(Request $request){
        $request -> validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $data = [
            'msg' => 'Sesión iniciada',
            'status' => true,
            'data' => $user->createToken('token-name')->plainTextToken
        ];
        return response()->json($data, 200);
        /* return response()->json([
            'user'->$user,
            'token'->$user->createToken('token-name')->plainTextToken,
        ], 201); */
    }

    public function logout(Request $request, $id){
    $user = User::find($id);
    $user->tokens()->delete();

    return response()->json('Logged out successfully');
    }

}
