<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;

class EmpleadosExport implements FromCollection,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    private $filtroempresa;
    private $filtrodepartamento;

    public function __construct($filtroempresa,$filtrodepartamento){
        $this->filtroempresa = $filtroempresa;
        $this->filtrodepartamento = $filtrodepartamento;
    }

    //titulo de la hoja de excel
    public function title(): string{
        return 'Empleados';
    }
    

    public function collection(){
        $empleados = DB::table('empresas as empr')
        ->leftjoin('departamentos as depto', 'empr.id', '=', 'depto.id_empresa')
        ->join('empleados as empl', 'depto.id', '=', 'empl.id_departamento')
        ->select('empr.id AS numero_empresa', 'empr.nombre AS nombre_empresa', 'depto.id AS numero_departamento', 'depto.nombre AS nombre_departamento', 'empl.id AS numero_empleado', 'empl.nombre AS nombre_empleado', 'empl.fecha_nacimiento', 'empl.correo', 'empl.genero', 'empl.telefono', 'empl.celular', 'empl.fecha_ingreso', 'empl.status')
        ->where('empr.id', $this->filtroempresa)->where('depto.id', $this->filtrodepartamento)
        ->orderby('empl.id', 'ASC')
        ->get();

        return $empleados;
        
    }
}
