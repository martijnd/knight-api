<?php

use App\Exceptions\UsernameAlreadyTakenException;
use App\Models\Enemy;
use App\Models\User;
use App\Models\Weapon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/tokens/create', function (Request $request) {
    // Check if username exists
    if (User::where('username', $request->username)->first()) {
        throw new UsernameAlreadyTakenException;
    }

    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users',
    ]);

    $user = User::create($validated);

    $user->update(['active_weapon_id' => Weapon::first()->id]);

    $token = $user->createToken('token');

    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/enemies/{enemy}/fight', function (Enemy $enemy, Request $request) {
        $request->user()->fight($enemy);

        return response()->json(['message' => 'success']);
    });

    Route::post('/enemies/{enemy}/attack', function (Enemy $enemy, Request $request) {
        $result = $request->user()->attack($enemy);

        return response()->json(['data' => $result]);
    });
});
