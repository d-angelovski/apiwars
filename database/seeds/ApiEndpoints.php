<?php

use Illuminate\Database\Seeder;

class ApiEndpoints extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_endpoints')->insert([
            'name' => 'StarWars people',
            'path' => 'https://swapi.co/api/people/',
            'service' => 'SwapiApi',
        ]);

        DB::table('api_endpoints')->insert([
            'name' => 'StarWars starships',
            'path' => 'https://swapi.co/api/starships/',
            'service' => 'SwapiApi',
        ]);

        DB::table('api_endpoints')->insert([
            'name' => 'Pokemons',
            'path' => 'http://pokeapi.co/api/v2/pokemon/',
            'service' => 'PokemonApi',
        ]);

        DB::table('api_endpoints')->insert([
            'name' => 'StarWars planets',
            'path' => 'https://swapi.co/api/planets/',
            'service' => 'SwapiApi',
        ]);
    }
}
