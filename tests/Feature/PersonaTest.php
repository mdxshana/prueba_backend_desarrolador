<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\User;
use Carbon\Carbon;
use DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('oauth_clients')->insert([
            'name' => 'Laravel Personal Access Client',
            'secret' => 'gnrX7jntNXSkQiTdIRuTM3TLqIcTMmlqnPTWF19w',
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        \App\Models\TipoDocumento::query()->insert([
            [
                'sigla' => 'CC',
                'descripcion' => 'Cédula de ciudadania'
            ],
            [
                'sigla' => 'NIT',
                'descripcion' => 'NIT'
            ],
            [
                'sigla' => 'CE',
                'descripcion' => 'Cédula de extrajería'
            ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    public function un_usuario_autenticado_puede_crear_una_persona()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);
        $token = $user->createToken('Laravel Personal Access Client')->accessToken;

        $data = [
            'nombres'=> 'minombre',
            'apellidos' => 'miapellido',
            'n_documento' => 123123,
            'telefono' => 234234,
            'direccion' => 'asdasd',
            'tipo_documento_id' => 1,
            'email' => 'micorreo@gmail.com'
        ];

        $response = $this->postJson('/api/personas',$data,[
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('personas',$data);
    }

    /**
     * @test
     */
    public function un_usuario_no_autenticado_no_puede_crear_personas(){
        $data = [
            'nombres'=> 'minombre',
            'apellidos' => 'miapellido',
            'n_documento' => 123123,
            'telefono' => 234234,
            'direccion' => 'asdasd',
            'tipo_documento_id' => 1,
            'email' => 'micorreo@gmail.com'
        ];
        $response = $this->postJson('/api/personas',$data);
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function un_usuario_autenticado_puede_listar_personas(){
        $user = factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);

        factory(Persona::class,20)->create();

        $token = $user->createToken('Laravel Personal Access Client')->accessToken;

        $response = $this->getJson('/api/personas',[
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data',
            'paginacion'
        ]);

        $response->assertJson([
           'paginacion'=>[
               'total' => 20
           ]
        ]);
    }

    /**
     * @test
     */
    public function un_usuario_no_autenticado_no_puede_listar_personas(){
        $response = $this->getJson('/api/personas');
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function un_usuario_autenticado_puede_eliminar_perosonas(){
        $user = factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);

        $token = $user->createToken('Laravel Personal Access Client')->accessToken;

        $persona = factory(Persona::class)->create([
            'tipo_documento_id' => 1,
            'n_documento' => 1121816622
        ]);

        $this->assertDatabaseHas('personas',[
            'tipo_documento_id' => 1,
            'n_documento' => 1121816622
        ]);

        $response = $this->deleteJson('/api/personas/'.$persona->id,[],[
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('personas',[
            'tipo_documento_id' => 1,
            'n_documento' => 1121816622
        ]);
    }

    /**
     * @test
     */
    public function un_usuario_no_autenticado_no_puede_eliminar_personas(){
        $persona = factory(Persona::class)->create([
            'tipo_documento_id' => 1,
            'n_documento' => 1121816622
        ]);

        $this->assertDatabaseHas('personas',[
            'tipo_documento_id' => 1,
            'n_documento' => 1121816622
        ]);

        $response = $this->deleteJson('/api/personas/'.$persona->id,[]);

        $response->assertStatus(401);

        $this->assertDatabaseHas('personas',[
            'tipo_documento_id' => 1,
            'n_documento' => 1121816622
        ]);

    }

    /**
     * @test
     */
    public function un_usuario_autenticado_puede_actualizar_persona(){
        $user = factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);

        $token = $user->createToken('Laravel Personal Access Client')->accessToken;

        $data = [
            'nombres'=> 'minombre',
            'apellidos' => 'miapellido',
            'n_documento' => 123123,
            'telefono' => 234234,
            'direccion' => 'asdasd',
            'tipo_documento_id' => 1,
            'email' => 'micorreo@gmail.com'
        ];

        $persona = factory(Persona::class)->create($data);

        $this->assertDatabaseHas('personas',$data);

        $data['n_documento'] = 44444444;
        $data['tipo_documento_id'] = 2;


        $response = $this->putJson('/api/personas/'.$persona->id,$data,[
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('personas',[
            'tipo_documento_id' => 2,
            'n_documento' => 44444444
        ]);
    }
}
