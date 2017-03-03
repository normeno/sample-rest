<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

function getJsonFile() {
    $file = Storage::get('public/db.json');
    return (array) json_decode($file);
}

function getArrayFile() {
    $json = getJsonFile();
    return $json;
    return $json->toArray();
}

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/movies', function () {
    return response()->json(getJsonFile());
});

Route::get('/movies/{id}', function (Request $request) {
    $movies = getArrayFile();

    if (!$request->id) {
        return [];
    }

    foreach ($movies as $movie) {
        if ($movie->id == $request->id) {
            $response = [
                'params' => ['id' => $request->id],
                'movie' => $movie
            ];

            return response()->json($response);
        }
    }

    return [];
});

Route::put('/movies/{id}', function (Request $request, $id) {
    $movies = getArrayFile();

    if (!$id) {
        return response()->json([]);
    }

    foreach ($movies as $movie) {
        if ($movie->id == $id) {
            $response = [
                'id' => $movie->id,
                'title' => isset($request->title) ? $request->title :$movie->title,
                'image' => $request->image ? $request->image : $movie->image,
                'rating' => $request->rating ? $request->rating : $movie->rating,
                'releaseYear' => $request->releaseYear ? $request->releaseYear : $movie->releaseYear,
                'genre' => $request->genre ? $request->genre : $movie->genre,
                'note' => 'This movie was not updated in the db'
            ];

            return response()->json($response);
        }
    }

    return response()->json([]);
});

Route::post('/movies/create', function (Request $request) {
    $response = [
        'id' => $request->id,
        'title' => $request->title,
        'image' => $request->image,
        'rating' => $request->rating,
        'releaseYear' => $request->releaseYear,
        'genre' => $request->genre,
        'note' => 'This movie was not created in the db'
    ];

    return response()->json($response);
});

Route::delete('/movies/{id}', function (Request $request, $id) {
    $movies = getArrayFile();

    if (!$id) {
        return response()->json([]);
    }

    foreach ($movies as $movie) {
        if ($movie->id == $id) {
            $response = [
                'note' => 'This movie was not deleted in the db',
                'movie' => [
                    'id' => $movie->id,
                    'title' => isset($request->title) ? $request->title :$movie->title,
                    'image' => $request->image ? $request->image : $movie->image,
                    'rating' => $request->rating ? $request->rating : $movie->rating,
                    'releaseYear' => $request->releaseYear ? $request->releaseYear : $movie->releaseYear,
                    'genre' => $request->genre ? $request->genre : $movie->genre,
                ]
            ];

            return response()->json($response);
        }
    }

    return response()->json([]);
});