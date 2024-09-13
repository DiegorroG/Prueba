<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Departameto;
use Illuminate\Support\Facades\Validator;
class empleadoController extends Controller
{
    #listar empleados
    public function index(){
        #$empleado=Empleado::all();
        $empleado=Empleado::select('nombre','apellidos','celular','email','departamento_id')
        ->with('Departameto:id,nombreDepartamento')
        ->get();
        if ($empleado->isEmpty()){
            $data=[
                'message'=>'no hay empleados',
                'status'=>200
            ];
            return response()->json($data,200);
        }
        $empleado = $empleado->map(function($emp) {
            return [
                'nombre' => $emp->nombre,
                'apellidos' => $emp->apellidos,
                'celular'=>$emp->celular,
                'email' => $emp->email,
                'Departameto' => $emp->Departameto->nombreDepartamento // Mostrar solo el nombre del departamento
            ];
        });

        $response = [
            'message' => 'Lista de empleados',
            'status' => 200,
            'empleados' => $empleado // Lista de empleados dentro del campo "empleados"
        ];
        return response()->json($response,200);
    }
        #agregar Empleados
        public function store(Request $request)
        {
            $validator=Validator::make($request->all(), [
               'nombre'=>'required|max:255',
               'apellidos'=> 'required|max:255',
               'celular'=>'digits:8',
               'email'=>'required|max:255|email|unique:empleados',
               'departamento_id'=>'required',
            ], [
                'departamento_id.exists' => 'El departamento seleccionado no es válido.', // Mensaje personalizado
            ]
        );
            if($validator->fails()){
                $data=[
                    'message'=>'Error en la validacion de los datos de empleado',
                    'error'=>$validator->errors(),
                    'status'=>400
                ];
                return response()->json($data, 400);
            }
            $empleados= Empleado::create([
                'nombre'=>$request->nombre,
                'apellidos'=>$request->apellidos,
                'celular'=>$request->celular,
                'email'=>$request->email,
                'departamento_id'=>$request->departamento_id,
            ]);
            if(!$empleados){
                $data = [
                    'message'=>'Error al crear el empleado',
                    'status'=>500
                ];
                return response()->json($data, 500);
            }
            $data = [
                'empleados'=>$empleados,
                'status'=>201
            ];
            return response()->json($data, 201);
    
    
        }
     #buscar empleado
     public function show($id)
     {
         $empleado = Empleado::find($id);
         #echo $student,'3333####';
         if(!$empleado){
             $data = [
                 'message'=>'empleado no encontrado',
                 'status'=>404
             ];
             return response()->json($data, 404);
         }
         $data =[
             'empleado'=>$empleado,
             'status'=>200
         ];
         return response()->json($data, 200);
     }
     public function destroy($id)
     {
         $empleado = Empleado::find($id);
         if(!$empleado){
             $data = [
                 'message'=>'Empleado no encontrado',
                 'status'=>404
             ];
             return response()->json($data, 404);
         }
         $empleado->delete();
         $data = [
             'message'=>'Empleado eliminado',
             'status'=>200
         ];
         return response()->json($data,200);
     }
     public function updatePartial(Request $request,$id)
     {
        $empleado = Empleado::find($id);
         if (!$empleado){
             $data=[
                 'message'=>'Empleado no encontrado',
                 'status'=>404
             ];
             return response()->json($data,404);
         }
         #return response()->json($request->all(),200);
         $validator = Validator::make($request->all(), [
             'nombre'=>'max:255',
             'apellidos'=>'max:255',
             'celular'=>'max:255',
             'email'=>'max:255',
             'departamento_id'=>'max:255',
         ]);
         if($validator->fails()){
             $data=[
                 'message'=>'Error en la validacion de los datos',
                 'errors'=>$validator->errors(),
                 'status'=> 400
             ];
             return response()->json($data,400);
         }
         if($request->has('nombre')){
             $empleado->nombre=$request->nombre;
         }
         if($request->has('apellidos')){
             $empleado->apellidos=$request->apellidos;
         }
         if($request->has('celular')){
            $empleado->celular=$request->celular;
        }
        if($request->has('email')){
            $empleado->email=$request->email;
        }
        if($request->has('departamento_id')){
            $empleado->departamento_id=$request->departamento_id;
        }
         $empleado->save();
         $data=[
             'message'=>'Empleado actualizado',
             'empleado'=>$empleado,
             'status'=> 200
         ];
         return response()->json($data,200);
     }
}
