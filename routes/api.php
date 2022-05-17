<?php

use App\Models\User;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    // Check if username exists
    if (User::where('username', $request->username)->first()) {
        abort(400, 'Username already taken.');
    }

    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users',
    ]);

    $user = User::create($validated);

    $token = $user->createToken('token');
 
    return ['token' => $token->plainTextToken];
});
