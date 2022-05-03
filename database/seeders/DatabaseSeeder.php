<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        DB::table('informacoes')->insert([
            'endereco' => 'Endereço comercial na rua Redentora, 1160, bairro Areias, CEP 64.027-666, cidade de Teresina, estado do Piauí',
            'telefone' => '(86)99937-2650',
            'whatsapp' => '5586999372650',
            'email' => 'luisdosgeradores@gmail.com',
            'urlImagem' => 'imagemHome/gerador.jpg',
            'localizacao' => 'www.google.com'
        ]);
       
        DB::table('users')->insert([
            'name' => 'Luis',
            'email' => 'luisdosgeradores@gmail.com',
            'password' => sha1('cavalo93') 
        ]);
    }
}
