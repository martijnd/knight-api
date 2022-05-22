<?php

use App\Exceptions\UsernameAlreadyTakenException;
use App\Http\Controllers\EnemyController;
use App\Models\Enemy;
use App\Models\Location;
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

    $location = Location::firstOrFail();

    $user = User::create([...$validated, 'location_id' => $location->id]);

    $user->update(['weapon_id' => Weapon::first()->id]);

    $token = $user->createToken('token');

    return ['token' => $token->plainTextToken, 'user' => $user];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/enemies/{enemy}/fight', function (Enemy $enemy, Request $request) {
        $request->user()->initiateFight($enemy);

        return response()->json(['message' => 'success']);
    })->name('fight');

    Route::post('/attack', function (Request $request) {
        $result = $request->user()->attack();

        return response()->json(['data' => $result]);
    })->name('attack');

    Route::apiResource('enemies', EnemyController::class)->only('index', 'show');
});
