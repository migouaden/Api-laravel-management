<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'required|string', // Ensure you have validation for the role

        ]);
        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['password']),
        ]);
        // $role = Role::findByName('writer');
        $role = Role::where('name', $request->input('role'))->first();

        $user->assignRole($role);

        $token = $user->createToken('mytoken')->plainTextToken;
        $response = [
            'user' => $user,
            'role' => $role,
            'token' => $token,
        ];
        return response($response);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return [
            'message' => 'Success Logout',
        ];
    }
    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($validate['password'], $user->password)) {
            return response()->json([
                'Failed' => 'Failed to login check User and Password',
            ], 401);
        }


        $token = $user->createToken('mytoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response);
    }
    public function index()
    {
        $users = User::with('roles')->get();
        return $users;
    }
    public function getRoles()
    {
        $roles = Role::all();
        return $roles;
    }
}
