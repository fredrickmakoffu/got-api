<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\SortBooksTrait;

class BookController extends Controller
{
    use SortBooksTrait;

    private $url = 'https://anapioficeandfire.com/api';

    public function index() {
        // get data
        $response = Http::get($this->url.'/books');
        $books = $response->json();

        // return 404 if data not found
        if($response->failed()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found.'
            ], 404);
        }

        // return success if data found
        return response()->json([
            'status' => true,
            'data' => $books
        ], 200);
    }

    public function show($id) {
        // get data
        $response = Http::get($this->url.'/books/'.$id);
        $books = $response->json();

        // return 404 if data not found
        if($response->failed()) {
            return response()->json([
                'status' => false,
                'message' => 'The Book ID provided is invalid. No data found.'
            ], 404);
        }
        
        // return success if data found
        return response()->json([
            'status' => true,
            'data' => $books
        ], 200);        
    }

    public function sort() {
        $response = Http::get($this->url.'/books');
        $data = $response->json();

        // sort gathered data
        $sorted = $this->sortBooks($data, 'released', 'desc');
        
        return response()->json([
            'status' =>true,
            'data' => $sorted
        ], 200);        
    }
}
