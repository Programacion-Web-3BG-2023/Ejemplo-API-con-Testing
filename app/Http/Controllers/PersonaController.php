<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;

class PersonaController extends Controller
{
    public function Listar(Request $request){
        return Persona::all();
    }

    public function ListarUno(Request $request, $idPersona){
        return Persona::findOrFail($idPersona);

    }

    public function Eliminar(Request $request, $idPersona){
        $persona = Persona::findOrFail($idPersona);
        $persona -> delete();

        return [ "mensaje" => "Persona $idPersona eliminada."];

    }

    public function Modificar(Request $request, $idPersona){
        $persona = Persona::findOrFail($idPersona);
        $persona -> nombre = $request -> post("nombre");
        $persona -> apellido = $request -> post("apellido");
        $persona -> save();

        return $persona;

    }
    public function Insertar(Request $request){
        $persona = new Persona;
        if($request -> post("nombre")== null || $request -> post("apellido")== null )
            return abort(403);
        $persona -> nombre = $request -> post("nombre");
        $persona -> apellido = $request -> post("apellido");

        $persona -> save();

        return $persona;
    }

}
