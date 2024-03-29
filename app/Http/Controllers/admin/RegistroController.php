<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistroRequest;
use App\Models\Puerta;
use App\Models\Registro;
use App\Models\Funcionario;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function index()
    {
        return view('admin.registro.index');
    }

    public function store(RegistroRequest $request)
    {
        Self::cambiarEstadoVisitante($request);
        $guardaCorrectamente = Self::registroNuevo($request);
        if ($guardaCorrectamente) {
            return response()->json(['success' => true]);
        }
    }
    private function cambiarEstadoVisitante($request)
    {
        DB::table('visitante')
            ->where('id', $request->visitante)
            ->update(['estadoVisitante' => 3, 'localidadVisita' => $request->idLocalidad]);
    }
    private function registroNuevo($request)
    {
        $registro = new Registro();
        $registro->ingresoSalida = $request->ingresoSalida;
        $registro->puerta = $request->puerta;
        $registro->visitante = $request->visitante;
        $registro->localidad = $request->idLocalidad;
        $registro->autorizaSeguridad = $request->autorizaSeguridad;
        $registro->autorizaFuncionario = $request->autorizaFuncionario;
        $registro->comentario = $request->comentario;
        $registro->save();
        if ($registro->save()) {
            return true;
        }
    }

    public function puertas(Puerta $puertas)
    {
        $puertas = Puerta::select()->orderBy('nombrePuerta', 'desc')->get();
        return response()->json($puertas);
    }

    public function autoriza(Request $request)
    {
        $datos = Funcionario::where([['localidad', '=', $request->localidadBusqueda], ['estadoFuncionario', '<>', 2], ['poderAutorizar', '<>', 2]])
            ->orWhere([['estadoFuncionario', '<>', 2], ['poderAutorizar', '=', 3]])
            ->orderBy('poderAutorizar', 'asc')
            ->orderBy('fechaNacimientoFuncionario', 'asc')
            ->get();
        return response()->json($datos);
    }

    public function ingresa(Request $request)
    {
        $existeVisitante = Visitante::firstWhere('documentoVisitante', $request->documento);
        if ($existeVisitante) {
            switch ($existeVisitante->estadoVisitante) {
                case 3:
                    return response()->json(['success' => false, 'messages' => 'Ya se encuentra dentro.']);
                case 2:
                    return response()->json(['success' => false, 'messages' => $existeVisitante->comentarioVisitante]);
                default:
                    $existeVisitante->fotoVisitante = asset($existeVisitante->fotoVisitante);
                    return response()->json(['success' => true, 'data' => $existeVisitante]);
            }
        } else {
            return response()->json(['success' => false, 'messages' => 'Visitante no registrado.']);
        }
    }

    public function funcionarios(Request $request)
    {
        $datos = Self::getFuncionarios($request);
        return view('admin.registro.includes.tablaFuncionario')->with('datos', $datos);
    }
    private function getFuncionarios($request)
    {
        $datos = Funcionario::select('funcionario.*', 'estados.nombreEstado')
            ->orderBy('created_at', 'desc')
            ->from('funcionario')
            ->join('estados', 'estados.id', '=', 'funcionario.estadoFuncionario')
            ->where([
                ["funcionario.localidad", '=', "$request->localidadBusqueda"],
                ['estadoFuncionario', '<>', 2]
            ])
            ->paginate(6);
        return $datos;
    }

    public function registros(Request $request)
    {
        $datos = Self::getRegistros($request);
        return view('admin.registro.includes.tablaRegistro')->with('datos', $datos);
    }
    private function getRegistros($request)
    {
        $datos = Registro::select(
            'registro.*',
            'visitante.nombreVisitante',
            'visitante.telefonoVisitante',
            'funcionario.nombreFuncionario',
            'estados.nombreEstado'
        )
            ->orderBy('created_at', 'desc')
            ->from('registro')
            ->join('visitante', 'visitante.id', '=', 'registro.visitante')
            ->join('estados', 'estados.id', '=', 'visitante.estadoVisitante')
            ->leftJoin('funcionario', 'funcionario.id', '=', 'registro.autorizaFuncionario')
            ->where([
                ["registro.localidad", '=', "$request->localidadBusqueda"],
            ])
            ->whereBetween('registro.created_at', [date('Y-m-d') . " 00:00:00 ", date('Y-m-d') . " 23:59:59"])
            ->paginate(6);
        return $datos;
    }

    public function visitantes(Request $request)
    {
        $datos = Self::getVisitantes($request);
        return view('admin.registro.includes.tablaVisitante')->with('datos', $datos);
    }
    private function getVisitantes($request)
    {
        $datos = Visitante::select('visitante.nombreVisitante', 'visitante.telefonoVisitante', 'estados.nombreEstado')
            ->from('visitante')
            ->join('estados', 'estados.id', '=', 'visitante.estadoVisitante')
            ->where([
                ["visitante.localidadVisita", '=', "$request->localidadBusqueda"],
                ['visitante.estadoVisitante', "=", "3"]
            ])
            ->get();
        return $datos;
    }
}
