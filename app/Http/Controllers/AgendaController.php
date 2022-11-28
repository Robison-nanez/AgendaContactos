<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\agenda;

class AgendaController extends Controller
{
    public function GuardarAgenda(Request $request){

        if ($request->id_agenda == null || $request->id_agenda == '') {
            $agenda = new agenda;
            $nuevo = true;
            $response = ['status' => true, 'icono' => 'success' ,'message' => 'Proceso de Guardado en la Agenda realizado correctamente'];
        } else {
            $agenda = agenda::findOrFail($request->id_agenda);
            $nuevo = false;
            $response = ['status' => true, 'icono' => 'success' ,'message' => 'Proceso de Actualizacion de la Agenda realizado correctamente'];
        }

        $agenda->nombre = $request->nombre;
        $agenda->telefono = $request->telefono;
        $agenda->fecha_nacimiento = $request->fecha;
        $agenda->direccion = $request->direccion;
        $agenda->correo = $request->correo;

        if ($nuevo == true) {
            $agenda->save();
        } else {
            $agenda->update();
        }

        return response()->json($response);
    }

    public function ListarAgenda($id){
        $concatenated = collect([]);
        if ($id == '@') {
            $listar = agenda::all();
            foreach ($listar as $value) {
                $collection = Collect([
                    [
                        'id_agendas' => $value->id_agendas,
                        'nombre' => $value->nombre,
                        'telefono' => $value->telefono,
                        'fecha_nacimiento' => $value->fecha_nacimiento,
                        'edad' => $this->Edad($value->fecha_nacimiento),
                        'direccion' => $value->direccion,
                        'correo' => $value->correo,
                    ]
                ]);
                $concatenated = $collection->concat($concatenated);
            }
            return response()->json($concatenated);
        } else {
            $lista = agenda::where('id_agendas', $id)->first();
            return response()->json($lista);
        }
    }

    public function Edad($edad) {
        $date1 = $edad;
		$date2 = date("Y") . "-" . date("m") . "-" . date("d");

		$diff = abs(strtotime($date2) - strtotime($date1));

		$years = floor($diff / (365 * 60 * 60 * 24));
		$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

		return $years;
    }

    public function EliminarAgenda($id){
        $Eliminar = agenda::where('id_agendas', $id)->first();
        $Eliminar->delete();
        $response = ['status' => true, 'icono' => 'success' ,'message' => 'Proceso de Eliminacion de la Agenda realizado correctamente'];
        return response()->json($response);
    }
}
