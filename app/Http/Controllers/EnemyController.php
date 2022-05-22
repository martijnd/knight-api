<?php

namespace App\Http\Controllers;

use App\Models\Enemy;

class EnemyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'success',
            'data' => Enemy::all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Enemy $enemy
     * @return \Illuminate\Http\Response
     */
    public function show(Enemy $enemy)
    {
        //
    }
}
