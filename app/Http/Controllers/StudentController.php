<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function verify(Request $request)
    {
        $id = $request->query('id');
        $password = $request->query('password');
        
        $user = User::where('id', $id)->first();
        if ($user && Hash::check($password, $user->password)) {
            $verified = true;
        } else {
            $verified = false;
        }
        
        return response()->json([
            'id' => $id,
            'verified' => $verified
        ]);
    }
}
