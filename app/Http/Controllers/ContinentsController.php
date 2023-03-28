<?php

namespace App\Http\Controllers;

use App\Models\Continent;

class ContinentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $continents = Continent::all();

        return  response()->json(['continents' => $continents]);
    }
}
