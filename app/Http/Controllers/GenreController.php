<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    //
    function Index() {
        $response = Http::withHeaders(Config('app.tmdb_headers'))
        ->get(Config('app.tmdb_base_url').'genre/movie/list');

        $languages = $response['genres'];

        return response()->json($languages);
    }
}
