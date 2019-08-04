<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\TarjetaCredito;
use App\User;
use Carbon\Carbon;
use DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TarjetaTest extends TestCase
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
     * @test
     */
    public function un_usuario_autentica_puede_listar_tarjetas_de_una_persona()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);

        $token = $user->createToken('Laravel Personal Access Client')->accessToken;

        $persona = factory(Persona::class)->create();

        factory(TarjetaCredito::class,5)->create([
            'persona_id' => $persona
        ]);

        $response = $this->getJson('/api/tarjetas/'.$persona->id,[
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function un_usuario_autenticaco_puede_crear_tarjeta_a_una_persona(){
        $user = factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);

        $token = $user->createToken('Laravel Personal Access Client')->accessToken;

        $persona = factory(Persona::class)->create();

        $data = [
            'numero_tarjeta' => 378282246310005,
            'vencimiento' => '07/2020',
            'cvc' => 623
        ];

        $response = $this->postJson('/api/tarjetas/'.$persona->id,$data,[
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tarjeta_creditos',$data);
    }

    /**
     * @test
     */
    public function un_usuario_autenticado_puede_eliminar_tarjeta_a_una_persona(){
        $user = factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);

        $token = $user->createToken('Laravel Personal Access Client')->accessToken;

        $data = [
            'numero_tarjeta' => 378282246310005,
            'vencimiento' => '07/2020',
            'cvc' => 623
        ];
        $tajeta = factory(TarjetaCredito::class)->create($data);

        $this->assertDatabaseHas('tarjeta_creditos',$data);

        $response = $this->deleteJson('/api/tarjetas/'.$tajeta->id,[],[
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tarjeta_creditos', $data);

    }
}
