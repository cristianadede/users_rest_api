<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showAll()
    {
        $users = User::where('is_deleted', false)->get();
        return response()->json($users);
    }

    public function showById($id)
    {
        $user = User::where('is_deleted', false)->find($id);
        if (!empty($user)) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nume'         => 'required|string|max:255',
                'prenume'      => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email',
                'parola'       => 'required|string',
                'data_nastere' => 'required|date',
                'cnp'          => 'required|numeric|digits:13|unique:users,cnp'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        $user               = new User();
        $user->nume         = $validatedData['nume'];
        $user->prenume      = $validatedData['prenume'];
        $user->email        = $validatedData['email'];
        $user->parola       = bcrypt($validatedData['parola']);
        $user->cnp          = $validatedData['cnp'];
        $user->data_nastere = $validatedData['data_nastere'];
        $user->save();

        return response()->json($user, 201);
    }

    public function updateById(Request $request, $id)
    {
        if ($user = User::where('id', $id)->where('is_deleted', false)->exists()) {
            try {
                $request->validate([
                    'nume'         => 'sometimes|required|string|max:255',
                    'prenume'      => 'sometimes|required|string|max:255',
                    'email'        => 'sometimes|required|email|unique:users,email,' . $id,
                    'parola'       => 'sometimes|required|string',
                    'data_nastere' => 'sometimes|required|date',
                    'cnp'          => 'sometimes|required|numeric|digits:13|unique:users,cnp,' . $id
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
            }
            $user               = User::find($id);
            $user->prenume      = $request->input('prenume', $user->prenume);
            $user->nume         = $request->input('nume', $user->nume);
            $user->email        = $request->input('email', $user->email);
            $user->data_nastere = $request->input('data_nastere', $user->data_nastere);
            $user->cnp          = $request->input('cnp', $user->cnp);

            if ($request->has('parola')) {
                $user->parola = bcrypt($request->input('parola'));
            }

            $user->save();

            return response()->json($user, 200);
        }

        return response()->json(['message' => 'User not found'], 404);

    }

    public function deleteById($id)
    {
        if (User::where('id', $id)->where('is_deleted', false)->exists()) {
            $user             = User::find($id);
            $user->is_deleted = true;

            $user->save();

            return response()->json(['message' => 'User deleted'], 202);
        }

        return response()->json(['message' => 'User not found'], 404);

    }
}
