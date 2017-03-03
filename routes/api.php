<?php

use Illuminate\Http\Request;

/**
 * Get a file and return json
 * @return array
 */
function getJsonFile() {
    $file = Storage::get('public/db.json');
    return (array) json_decode($file);
}

/**
 * Get a json and return array
 * @return array
 */
function getArrayFile() {
    $json = getJsonFile();
    return $json;
    return $json->toArray();
}

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Return all records
 */
Route::get('/movies', function () {
    return response()->json(getJsonFile());
});

/**
 * Return one record
 */
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

/**
 * Edit a record (simulation)
 */
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

/**
 * Create a record (simulation)
 */
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


/**
 * Delete a record (simulation)
 */
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

/**
 * Simulate a login
 */
Route::post('/users/login', function (Request $request) {

    $faker = Faker\Factory::create();

    if (!$request->password) {
        return response()->json(['error' => 'Password is required']);
    }

    if ($request->username || $request->email) {
        $response = [
            'status' => 1,
            'user' => [
                'username' => $request->username ? $request->username : 'randomUsername',
                'email' => $request->email ? $request->email : 'randomEmail',
                'firstName' => $faker->firstName(),
                'lastName' => $faker->lastName,
                'avatar' => 'http://lorempixel.com/100/100/people/9/'
            ]
        ];
    } else {
        $response = ['error' => 'Username or Email is required'];
    }



    return response()->json($response);
});
