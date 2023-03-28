<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * This controller provides a token for mobile devices
     * It can also be used to access the API via a GUI
     * Insomnia or Postman are two examples of GUI's
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
}
