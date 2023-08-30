<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Support\Str;

class UserTokenController extends Controller
{

    public function generateToken($userId)
    {
        $user = User::find($userId);
        if (empty($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $token = new ApiToken();
        $token->user_id = $user->id;
        $token->token = Str::random(60);
        $token->save();

        return response()->json(['token' => $token->token]);
    }

}
