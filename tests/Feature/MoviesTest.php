<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MoviesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_latest()
    {
        $response = $this->get('api/movie/latest');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'original_title',
                'cast',
                'year',
                'backdrop_path',
                'vote_average',
                'poster_path',
            ]
        ]);
    }

    public function test_top_rated() {
        $response = $this->get('api/movie/top-rated');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'original_title',
                'cast',
                'year',
                'backdrop_path',
                'vote_average',
                'poster_path',
            ]
        ]);
    }

    public function test_movie() {
        $response = $this->get('api/movie/12');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'original_title',
            'title',
            'tagline',
            'status',
            'genres',
            'overview',
            'poster_path',
            'release_data',
            'vote_average',
        ]);
    }
}
