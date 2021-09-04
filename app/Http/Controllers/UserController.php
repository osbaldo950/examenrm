<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use DataTables;
use Carbon\Carbon;
use DB;

class UserController extends Controller
{
    public function usuarios(){
        return view('catalogos.usuarios');
    }

    public function obtener_usuarios(Request $request){
        if($request->ajax()){
            $data = DB::table('users as u')
                        ->leftjoin('roles as r', 'r.id', '=', 'u.role_id')
                        ->select('r.name AS rol_usuario', 'u.id AS numero_usuario', 'u.name AS nombre_usuario', 'u.email AS correo_usuario', 'u.status')
                        ->orderby('u.id', 'ASC')
                        ->get();
            return DataTables::of($data)
                    ->addColumn('operaciones', function($data){
                        $operaciones = '<div class="nav-item dropdown">'.
                                            '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">'.
                                                'OPERACIONES <span class="caret"></span>'.
                                            '</a>'.
                                            '<div class="dropdown-menu">'.
                                                '<a class="dropdown-item" tabindex="-1" href="javascript:void(0);" onclick="obtenerdatos(\''.$data->numero_usuario .'\')">Cambios</a>'.
                                                '<a class="dropdown-item" tabindex="-1" href="javascript:void(0);" onclick="desactivar(\''.$data->numero_usuario .'\')">Bajas</a>'.
                                            '</div>'.
                                        '</div>';
                        return $operaciones;
                    })
                    ->rawColumns(['operaciones'])
                    ->make(true);
        } 
    }

    public function obtener_ultimo_id_usuario(){
        $ultimoNumeroTabla = User::select("id")->orderBy("id", "DESC")->take(1)->get();
        if(sizeof($ultimoNumeroTabla) == 0 || sizeof($ultimoNumeroTabla) == "" || sizeof($ultimoNumeroTabla) == null){
            $id = 1;
        }else{
            $id = $ultimoNumeroTabla[0]->id+1;   
        }
        return response()->json($id);
    }

    public function obtener_roles(){
        $getroles = Role::orderBy("id", "DESC")->get();
        $roles = "";
        $contador = 1;
        foreach($getroles as $getrol){
            $roles = $roles.
            '<input type="radio" name="rol" id="rol'.$contador.'" value="'.$getrol->id.'" required>'.
                                '<label for="rol'.$contador.'">'.$getrol->name.'</label>';
            $contador++;
        }
        return response()->json($roles);
    }

    public function guardar_usuario(Request $request){
        $email=$request->email;
	    $ExisteUsuario = User::where('email', $email)->first();
	    if($ExisteUsuario == true){
            $Usuario = 1;
	    }else{
            $ultimoNumeroTabla = User::select("id")->orderBy("id", "DESC")->take(1)->get();
            if(sizeof($ultimoNumeroTabla) == 0 || sizeof($ultimoNumeroTabla) == "" || sizeof($ultimoNumeroTabla) == null){
                $id = 1;
            }else{
                $id = $ultimoNumeroTabla[0]->id+1;   
            }
            $Usuario = new User;
		    $Usuario->id=$id;
		    $Usuario->name=$request->nombre;
            $Usuario->email=$request->email;
            $Usuario->password=Hash::make($request->pass);
            $Usuario->role_id=$request->rol;
		    $Usuario->status="ALTA";
            $Usuario->save();
      	}
    	return response()->json($Usuario); 
    }

    public function verificar_baja_usuario(Request $request){
        $numerousuario = $request->numerousuario;
        $usuario = User::where('id', $numerousuario)->first();
        return response()->json($usuario);
    }

    public function baja_usuario(Request $request){
        $numerousuario=$request->numerousuario;
	    $Usuario = User::where('id', $numerousuario )->first();
        $Usuario->status = 'BAJA';
	    $Usuario->save();
	    return response()->json($Usuario);
    }

    public function obtener_usuario(Request $request){
        $permitirmodificacion = 1;
        $usuario = User::where('id', $request->numerousuario)->first();
        $getroles = Role::orderBy("id", "DESC")->get();
        $roles = "";
        $contador = 1;
        foreach($getroles as $getrol){
            if($getrol->id == $usuario->role_id){
                $roles = $roles.
                '<input type="radio" name="rol" id="rol'.$contador.'" value="'.$getrol->id.'" required checked>'.
                                    '<label for="rol'.$contador.'">'.$getrol->name.'</label>';
            }else{
                $roles = $roles.
                '<input type="radio" name="rol" id="rol'.$contador.'" value="'.$getrol->id.'" required>'.
                                '<label for="rol'.$contador.'">'.$getrol->name.'</label>';
            }
            $contador++;
        }  
        if($usuario->status == 'BAJA'){
            $permitirmodificacion = 0;
        }      
        $data = array(
            "usuario" => $usuario,
            "roles" => $roles,
            "permitirmodificacion" => $permitirmodificacion
        );
        return response()->json($data);
    }

    public function guardar_modificacion_usuario(Request $request){
        $email=$request->email;
	    $ExisteUsuario = User::where('id','<>', $request->numero)->where('email', $email)->first();
	    if($ExisteUsuario == true){
            $Usuario = 1;
	    }else{
            //modificar registro
            $Usuario = User::where('id', $request->numero )->first();
            $Usuario->name=$request->nombre;
            $Usuario->email=$request->email;
            $Usuario->role_id=$request->rol;
            $Usuario->save();
      	}
    	return response()->json($Usuario); 
    }
}
