<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Departamento;
use App\Empleado;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmpleadosExport;
use DB;

class EmpleadoController extends Controller
{
    public function empleados(){
        $select_empresas = '';
        $select_departamentos = '';
        $empresas= Empresa::where('status', 'ALTA')->get();
        foreach($empresas as $e){
            if($e->id == 1){
                $select_empresas = $select_empresas."<option value='".$e->id."' selected>".$e->nombre."</option>";
            }else{
                $select_empresas = $select_empresas."<option value='".$e->id."'>".$e->nombre."</option>";
            }
        }
        $empresa = 1;
        $departamentos= Departamento::where('status', 'ALTA')->where('id_empresa', $empresa)->get();
        foreach($departamentos as $d){
            if($d->id == 1){
                $select_departamentos = $select_departamentos."<option value='".$d->id."' selected>".$d->nombre."</option>";
            }else{
                $select_departamentos = $select_departamentos."<option value='".$d->id."'>".$d->nombre."</option>";
            }
        }
        $urlgenerarformatoexcel = route('empleados_exportar_excel');
        return view('catalogos.empleados', compact('select_empresas', 'select_departamentos','urlgenerarformatoexcel'));
    }

    public function obtener_empleados(Request $request){
        if($request->ajax()){
            $filtroempresa = $request->filtroempresa;
            $filtrodepartamento = $request->filtrodepartamento;
            $data = DB::table('empresas as empr')
                        ->leftjoin('departamentos as depto', 'empr.id', '=', 'depto.id_empresa')
                        ->join('empleados as empl', 'depto.id', '=', 'empl.id_departamento')
                        ->select('empr.id AS numero_empresa', 'empr.nombre AS nombre_empresa', 'depto.id AS numero_departamento', 'depto.nombre AS nombre_departamento', 'empl.id AS numero_empleado', 'empl.nombre AS nombre_empleado', 'empl.fecha_nacimiento', 'empl.correo', 'empl.genero', 'empl.telefono', 'empl.celular', 'empl.fecha_ingreso', 'empl.status')
                        ->where('empr.id', $filtroempresa)->where('depto.id', $filtrodepartamento)
                        ->orderby('empl.id', 'ASC')
                        ->get();
            return DataTables::of($data)
                    ->addColumn('operaciones', function($data){
                        $operaciones = '<div class="nav-item dropdown">'.
                                            '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">'.
                                                'OPERACIONES <span class="caret"></span>'.
                                            '</a>'.
                                            '<div class="dropdown-menu">'.
                                                '<a class="dropdown-item" tabindex="-1" href="javascript:void(0);" onclick="obtenerdatos(\''.$data->numero_empleado .'\')">Cambios</a>'.
                                                '<a class="dropdown-item" tabindex="-1" href="javascript:void(0);" onclick="desactivar(\''.$data->numero_empleado .'\')">Bajas</a>'.
                                            '</div>'.
                                        '</div>';
                        return $operaciones;
                    })
                    ->rawColumns(['operaciones'])
                    ->make(true);
        } 
    }

    public function obtener_ultimo_id_empleado(){
        $ultimoNumeroTabla = Empleado::select("id")->orderBy("id", "DESC")->take(1)->get();
        if(sizeof($ultimoNumeroTabla) == 0 || sizeof($ultimoNumeroTabla) == "" || sizeof($ultimoNumeroTabla) == null){
            $id = 1;
        }else{
            $id = $ultimoNumeroTabla[0]->id+1;   
        }
        return response()->json($id);
    }

    public function obtener_fecha_actual_datetimelocal(){
        Carbon::setLocale(config('app.locale'));
        Carbon::setUTF8(true);
        setlocale(LC_TIME, 'es_Es');
        $fecha = Carbon::now()->format('Y-m-d')."T".Carbon::now()->format('H:i');
        return response()->json($fecha);
    }

        
    public function obtener_empresas(Request $request){
        $empresas= Empresa::where('status', 'ALTA')->get();
        $select_empresas = "<option selected disabled hidden>Selecciona...</option>";
        foreach($empresas as $e){
            $select_empresas = $select_empresas."<option value='".$e->id."'>".$e->nombre."</option>";
        }
        return response()->json($select_empresas);
    }

    public function obtener_departamentos(Request $request){
        $empresa = $request->empresa;
        $departamentos= Departamento::where('status', 'ALTA')->where('id_empresa', $empresa)->get();
        $select_departamentos = "<option selected disabled hidden>Selecciona...</option>";
        foreach($departamentos as $d){
            $select_departamentos = $select_departamentos."<option value='".$d->id."'>".$d->nombre."</option>";
        }
        return response()->json($select_departamentos);
    }

    public function obtener_departamentos_filtro(Request $request){
        $contador = 0;
        $select_departamentos = '';
        $filtroempresa = $request->filtroempresa;
        $departamentos= Departamento::where('status', 'ALTA')->where('id_empresa', $filtroempresa)->orderby('id', 'ASC')->get();
        foreach($departamentos as $d){
            if($contador = 0){
                $select_departamentos = $select_departamentos."<option value='".$d->id."' selected>".$d->nombre."</option>";
            }else{
                $select_departamentos = $select_departamentos."<option value='".$d->id."'>".$d->nombre."</option>";
            }
        }
        return response()->json($select_departamentos);

    }

    public function guardar_empleado(Request $request){
        //obtener el ultimo id de la tabla
        $ultimoNumeroTabla = Empleado::select("id")->orderBy("id", "DESC")->take(1)->get();
        if(sizeof($ultimoNumeroTabla) == 0 || sizeof($ultimoNumeroTabla) == "" || sizeof($ultimoNumeroTabla) == null){
            $id = 1;
        }else{
            $id = $ultimoNumeroTabla[0]->id+1;   
        }
		$Empleado = new Empleado;
		$Empleado->id=$id;
		$Empleado->id_departamento=$request->departamento;
		$Empleado->nombre=$request->nombre;
		$Empleado->fecha_nacimiento=$request->fecha_nacimiento;
        $Empleado->correo=$request->correo;
		$Empleado->genero=$request->genero;
		$Empleado->telefono=$request->telefono;
		$Empleado->celular=$request->celular;
		$Empleado->fecha_ingreso=$request->fecha_ingreso;
        $Empleado->status='ALTA';
		$Empleado->save();
        return response()->json($Empleado); 
    }

    public function verificar_baja_empleado(Request $request){
        $numeroempleado = $request->numeroempleado;
        $empleado = Empleado::where('id', $numeroempleado)->first();
        return response()->json($empleado);
    }

    public function baja_empleado(Request $request){
        $numeroempleado=$request->numeroempleado;
	    $Empleado = Empleado::where('id', $numeroempleado )->first();
        $Empleado->status = 'BAJA';
	    $Empleado->save();
	    return response()->json($Empleado);
    }

    public function obtener_empleado(Request $request){
        $select_departamentos = '';
        $select_empresas = '';
        $permitirmodificacion = 1;
        $empleado = Empleado::where('id', $request->numeroempleado)->first();
        $departamento = Departamento::where('id', $empleado->id_departamento)->first();
        $empresa = Empresa::where('id', $departamento->id_empresa)->first();
        $departamentos = Departamento::where('id_empresa', $empresa->id)->where('status', 'ALTA')->get();
        foreach($departamentos as $d){
            if($d->id == $departamento->id){
                $select_departamentos = $select_departamentos."<option value='".$d->id."' selected>".$d->nombre."</option>";
            }else{
                $select_departamentos = $select_departamentos."<option value='".$d->id."'>".$d->nombre."</option>";
            }
        }
        $empresas = Empresa::where('status', 'ALTA')->get();
        foreach($empresas as $e){
            if($e->id == $empresa->id){
                $select_empresas = $select_empresas."<option value='".$e->id."' selected>".$e->nombre."</option>";
            }else{
                $select_empresas = $select_empresas."<option value='".$e->id."'>".$e->nombre."</option>";
            }
        }
        if($empleado->status == 'BAJA'){
            $permitirmodificacion = 0;
        }
        $data = array(
            "empleado" => $empleado,
            "fecha_nacimiento" => Carbon::parse($empleado->fecha_nacimiento)->format('Y-m-d')."T".Carbon::parse($empleado->fecha_nacimiento)->format('H:i'),
            "fecha_ingreso" => Carbon::parse($empleado->fecha_ingreso)->format('Y-m-d')."T".Carbon::parse($empleado->fecha_nacimiento)->format('H:i'),
            "departamento" => $departamento,
            "empresa" => $empresa,
            "select_departamentos" => $select_departamentos,
            "select_empresas" => $select_empresas,
            "permitirmodificacion" => $permitirmodificacion
        );
        return response()->json($data);
    }

    public function guardar_modificacion_empleado(Request $request){
        //modificar registro
        $numeroempleado = $request->numero;
        $Empleado = Empleado::where('id', $numeroempleado )->first();
        $Empleado->id_departamento=$request->departamento;
        $Empleado->nombre=$request->nombre;
        $Empleado->fecha_nacimiento=$request->fecha_nacimiento;
        $Empleado->correo=$request->correo;
        $Empleado->genero=$request->genero;
        $Empleado->telefono=$request->telefono;
        $Empleado->celular=$request->celular;
        $Empleado->save();
        return response()->json($Empleado); 
    }

    public function empleados_exportar_excel(Request $request){
        ini_set('max_execution_time', 300); // 5 minutos
        ini_set('memory_limit', '-1');
        return Excel::download(new EmpleadosExport($request->filtroempresa,$request->filtrodepartamento), "empleados.xlsx");   
    }
}
