<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Persona;
use Tests\TestCase;

class PersonaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ListarUnoQueExiste()
    {
        $estructura = [
            "id","nombre","apellido","created_at","updated_at","deleted_at"
        ];
        $response = $this->get('/api/personas/999');

        $response->assertStatus(200); // Valida el status HTTP de la peticion
        $response->assertJsonCount(6); // Valida que el JSON de respuesta tenga 6 campos
        $response->assertJsonStructure($estructura); // Valida que la estructura de JSON tenga los campos especificados en el array
        $response->assertJsonFragment([
            "nombre" => "Juan",
            "apellido" => "Perez"
        ]); // Valida que los campos del JSON tengan esos valores puntuales
    }
    public function test_ListarUnoQueNoExiste()
    {
        $response = $this->get('/api/personas/1000000');
        $response->assertStatus(404); // Valida el status HTTP de la peticion
    }

    
    public function test_EliminarUnoQueNoExiste()
    {
        $response = $this->delete('/api/personas/1000000');
        $response->assertStatus(404); // Valida el status HTTP de la peticion
    }
    public function test_EliminarUnoQueExiste()
    {
        $response = $this->delete('/api/personas/998');
        $response->assertStatus(200);
        $response->assertJsonFragment([ "mensaje" => "Persona 998 eliminada."]); // Valida que la estructura de JSON tenga los campos especificados en el array
        $this->assertDatabaseMissing("personas",[
            "id" => 998,
            "deleted_at" => null
        ]);

        Persona::withTrashed()->where("id",998)->restore();


    }

    public function test_ModificarUnoQueExiste(){
        $estructura = [
            "id",
            "nombre",
            "apellido",
            "created_at",
            "updated_at",
            "deleted_at"
        ];

        $response = $this->put('/api/personas/997',[
            "nombre" => "Jose",
            "apellido" => "Artigas"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure($estructura); // Valida que la estructura de JSON tenga los campos especificados en el array
        $response->assertJsonFragment([
            "nombre" => "Jose",
            "apellido" => "Artigas"
        ]);


    }

    public function test_InsertarSinNombre(){
        $response = $this->post('/api/personas',["apellido" => "Perez"]);
        $response->assertStatus(403); // Valida el status HTTP de la peticion
    }

    public function test_InsertarSinApellido(){
        $response = $this->post('/api/personas',["nombre" => "Jose"]);
        $response->assertStatus(403); // Valida el status HTTP de la peticion
    }

    public function test_InsertarSinNada(){
        $response = $this->post('/api/personas');
        $response->assertStatus(403); // Valida el status HTTP de la peticion
    }
    public function test_Insertar(){
        $estructura = [
            "id",
            "nombre",
            "apellido",
            "created_at",
            "updated_at",
        ];
        $datosParaInsertar = [
            "nombre" => "Nicolas",
            "apellido" => "Suarez"
        ];

        $response = $this->post('/api/personas',$datosParaInsertar);

        $response->assertStatus(201); // Valida el status HTTP de la peticion
        $response->assertJsonStructure($estructura); // Valida que la estructura de JSON tenga los campos especificados en el array
        $response->assertJsonFragment($datosParaInsertar); // Valida que la estructura de JSON tenga los campos especificados en el array
        $this->assertDatabaseHas('personas', $datosParaInsertar); // Valida que en la tabla Personas esten los datos insertados.

    }
   

    

}
