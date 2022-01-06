<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LanguageController extends Controller
{
    //
    function Index() {
        $response = Http::withHeaders(Config('app.tmdb_headers'))
        ->get(Config('app.tmdb_base_url').'configuration/languages');

        $content = json_decode($response->getBody()->getContents());
        
        return response()->json($content);
    }
}
