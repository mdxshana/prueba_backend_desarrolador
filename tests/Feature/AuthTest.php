<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
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
    }


    /**
     * Un registrado puede hacer login de usuario.
     *
     * @test
     */
    public function un_usuario_registrado_puede_hacer_login()
    {
        factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);

        $response = $this->postJson('/api/login', ['email' => 'admin@gmail.com', 'password' => 'password']);

        $response->assertJsonStructure([
                'user',
                'token',
        ]);

        $response->assertJson([
            'user' => [
                'email' => 'admin@gmail.com'
            ]
        ]);

        $response->assertStatus(200);

    }

    /**
     * @test
     */
    public function un_usuario_no_registrado_no_puede_hacer_login(){
        $response = $this->postJson('/api/login', ['email' => 'admin@gmail.com', 'password' => 'password']);
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'error',
        ]);
    }

    /**
     * @test
     */
    public function un_usuario_puede_hacer_logout(){
       $user= factory(User::class)->create([
            'email' => 'admin@gmail.com'
        ]);

        $token = $user->createToken('Laravel Personal Access Client')->accessToken;

        $response = $this->postJson('/api/logout', [], [
                'Authorization' => 'Bearer ' . $token
            ]
        );

        $response->assertStatus(200);
    }


}
