<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Utils\Traits\MakesHTTPRequests;
use Illuminate\Http\Request;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MakesHTTPRequests;

    public function getPokemonsData()
    {
        $pokemons = $this->makeRequest('https://pokeapi.co/api/v2/pokemon/?limit=100&offset=100%22', 'GET');
        return view('index', compact('pokemons'));
    }

    public function pokemonDetails(Request $request)
    {
        $pokemons = $this->makeRequest('https://pokeapi.co/api/v2/pokemon/?limit=100&offset=100%22', 'GET');
        foreach($pokemons['results'] as $pokemon) {
            if($pokemon['name'] == $request->name) {
                $pokemonDetails = $this->makeRequest($pokemon['url'], 'GET');
            }
        }
        return view('details', compact('pokemonDetails'));
    }
}
