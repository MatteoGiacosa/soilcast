<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use App\Http\Controllers\JsonResponse;

class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function create(Request $request): JsonResponse
    {
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->fullName = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        
        return response()->json([
            'message' => 'Utente creato con successo',
            'data' => $user,
        ], 201);
    }

    public function edit(User $id, Request $request)
    {
        if (!$id) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $data = $request->all();
        $id->update($data);

        return response()->json($id, 200);
    }


    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }


    public function destroy(string $id): View
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
