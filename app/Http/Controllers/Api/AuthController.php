<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        // dd('ss');
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid password',
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->update([
            'api_token' => $token,
        ]);
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
}
