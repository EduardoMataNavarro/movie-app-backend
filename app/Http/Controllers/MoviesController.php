<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class MoviesController extends Controller
{
    //

    function TopRatedMovies(){
        $api_response = Http::withHeaders(Config('app.tmdb_headers'))
        ->get(Config('app.tmdb_base_url').'movie/top_rated', [
            'page' => 1,
        ]);

        $results = $api_response['results'];

        $response_data = [];
        foreach ($results as $result) {
            $response_data[] = $this->MovieBriefData($result);
        }

        return response()->json($response_data);
    }

    function LatestMovies() {
        $api_response = Http::withHeaders(Config('app.tmdb_headers'))
        ->get(Config('app.tmdb_base_url').'movie/now_playing', [
            'page' => 1,
        ]);

        $results = $api_response['results'];

        $response_data = [];
        foreach ($results as $result) {
            $response_data[] = $this->MovieBriefData($result);
        }

        return response()->json($response_data);
    }

    function SearchMovie($query) {
        
        $api_response = Http::withHeaders(Config('app.tmdb_headers'))
        ->get(Config('app.tmdb_base_url').'search/movie', [
            'query' => $query,
            'page' => 1,
        ]);

        $results = $api_response['results'];

        $response_data = [];
        foreach ($results as $result) {
            $response_data[] = $this->MovieBriefData($result);
        }

        return response()->json($response_data);
    }

    /*
    * Parameters 
    * lang = original_language
    * genre = movie_genre
    * page = 1
    */
    function FindMovies(Request $request) {
        $page = $request->input('page');
        $lang = $request->input('lang');
        $genre = $request->input('genre');

        $query_params = [];

        if (isset($page)) {
            $query_params = Arr::add($query_params, 'page', $page);
        }

        if (isset($lang)) {
            $query_params = Arr::add($query_params, 'with_original_language', $lang);
        }
        
        if (isset($genre)) {
            $query_params = Arr::add($query_params, 'with_genres', $genre);
        }
        $response = Http::withHeaders(Config('app.tmdb_headers'))
        ->get(Config('app.tmdb_base_url').'discover/movie', $query_params); 

        $results = $response['results'];

        $response_data = [];
        foreach ($results as $result) {
            $response_data[] = $this->MovieBriefData($result);
        }
        
        return response()->json($response_data);
    }

    function GetMovie($id) {

        $response = Http::withHeaders(Config('app.tmdb_headers'))
        ->get(Config('app.tmdb_base_url').'movie/'.$id);

        if ($response) {
            $data = [
                'original_title' => $response['original_title'],
                'title' => $response['title'],
                'tagline' => $response['tagline'],
                'status' => $response['status'],
                'genres' => $response['genres'],
                'overview' => $response['overview'],
                'poster_path' => $response['poster_path'],
                'release_data' => $response['release_date'],
                'vote_average' => $response['vote_average'],
            ];

            return response()->json($data);
        }

        return response()->json(['error' => 'Movie not found']);
    }

    /* Models each object to extract important data */
    function MovieBriefData($movie) {
        $movie_id = $movie['id'];

        $credits_response = Http::withHeaders(Config('app.tmdb_headers'))
            ->get(Config('app.tmdb_base_url'.'').'movie/'.$movie_id.'/credits');

        $movie_cast = $credits_response['cast'];
        $cast = [$movie_cast[0]['name'] ?? '', $movie_cast[1]['name'] ?? ''];
        
        $release_year = 'NA';
        if (isset($movie['release_date'])) {
            $release_year = Str::before($movie['release_date'], '-');
        }

        return [
            'id' => $movie_id, 
            'original_title' => $movie['original_title'], 
            'title' => $movie['title'],
            'cast' => $cast,
            'year' => $release_year, 
            'backdrop_path' => $movie['backdrop_path'],
            'vote_average' => $movie['vote_average'],
            'poster_path' => $movie['poster_path'],
        ];
    }

}
