<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TipoDocumentoSeeder::class,
            PersonaSeeder::class,
        ]);
        factory(\App\User::class)->create([
            'email' => 'admin@gmail.com'
        ]);
    }
}
