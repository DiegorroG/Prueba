<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departameto;
use Illuminate\Support\Facades\Validator;

class departamentosController extends Controller
{
    #listar departamentos
    public function index(){
        $departamentos=Departameto::all();
        if ($departamentos->isEmpty()){
            $data=[
                'departamentos'=> $departamentos,
                'message'=>'no hay departamentos',
                'status'=>200
            ];
            return response()->json($data,200);
        }
        $response = [
            'message' => 'Lista de departamentos',
            'status' => 200,
            'departamentos' => $departamentos // Lista de empleados dentro del campo "empleados"
        ];
        return response()->json($response,200);
    }
    #agregar departamento
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
           'nombreDepartamento'=>'required|max:255',
           'descripcion'=> 'required|max:255'
        ]);
        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos',
                'error'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data, 400);
        }
        $departamentos= Departameto::create([
            'nombreDepartamento'=>$request->nombreDepartamento,
            'descripcion'=>$request->descripcion,
        ]);
        if(!$departamentos){
            $data = [
                'message'=>'Error al crear el departamento',
                'status'=>500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'departamentos'=>$departamentos,
            'status'=>201
        ];
        return response()->json($data, 201);


    }
    #buscar departamento
    public function show($id)
    {
        $departamento = Departameto::find($id);
        #echo $student,'3333####';
        if(!$departamento){
            $data = [
                'message'=>'Departamento no encontrado',
                'status'=>404
            ];
            return response()->json($data, 404);
        }
        $data =[
            'departamento'=>$departamento,
            'status'=>200
        ];
        return response()->json($data, 200);
    }
    #editar departamento
    public function update(Request $request, $id)
    {
        $departamento =Departameto::find($id);
        if(!$departamento){
            $data =[
                'message'=>'Departamento no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }
        $validator = Validator::make($request->all(), [
            'nombreDepartamento'=>'required|max:255',
            'descripcion'=>'required|max:255',
        ]);
        if($validator->fails()) {
            $data =[
                'message'=>'Error en la validadcion de datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data,400);
        }
        $departamento->nombreDepartamento = $request->nombreDepartamento;
        $departamento->descripcion = $request->descripcion;
        $departamento->save();
        $data =[
            'message'=>'Departamento actualizado',
            'departamento'=>$departamento,
            'status'=>200
        ];
        return response()->json($data,200);

    }
    public function updatePartial(Request $request,$id)
    {
        $departamento =Departameto::find($id);
        if (!$departamento){
            $data=[
                'message'=>'Departamento no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }
        #return response()->json($request->all(),200);
        $validator = Validator::make($request->all(), [
            'nombreDepartamento'=>'max:255',
            'descripcion'=>'max:255',
        ]);
        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion88 de los datos',
                'errors'=>$validator->errors(),
                'status'=> 400
            ];
            return response()->json($data,400);
        }
        if($request->has('nombreDepartamento')){
            $departamento->nombreDepartamento=$request->nombreDepartamento;
        }
        if($request->has('descripcion')){
            $departamento->descripcion=$request->descripcion;
        }
        $departamento->save();
        $data=[
            'message'=>'Departamento actualizado',
            'departamento'=>$departamento,
            'status'=> 200
        ];
        return response()->json($data,200);
    }
}
