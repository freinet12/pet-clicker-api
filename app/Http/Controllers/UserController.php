<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $users = User::all();

        return response()->json([
            'success' =>true,
            'total_users' => $users->count(),
            'users' => $users
        ]);
    }
}
