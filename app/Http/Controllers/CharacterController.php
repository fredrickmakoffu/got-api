<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\SortCharactersTrait;

class CharacterController extends Controller
{
    use SortCharactersTrait;

    private $url = 'https://anapioficeandfire.com/api';

    public function sort(Request $request) {
        // grab characters
        $response = Http::get($this->url.'/'.$request->url);
        $data = $response->json();

        // sort through characters
        $sorted = $this->sortCharacters($data, $request->sort_type, $request->order_type);

        // filter through characters
        $filtered = $this->filterCharacters($sorted, $request->filter_key, $request->filter_value);

        // start sort
        return response()->json([
            'status' => true,
            'data' => $filtered['data'],
            'total' => count($filtered['data']),
            'age' => $filtered['total_age']
        ], 200);
    }
}
