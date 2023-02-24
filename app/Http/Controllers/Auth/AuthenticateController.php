<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = (object) $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'in:writer,adimin',
                'password' => 'required|min:8'
            ], [
                'name' => 'Nama wajib diisi.',
                'role' => 'Rule tidak valid.',
                'email.email' => 'Email tidak valid.',
                'password.min' => 'Password minimal 8 karakter.'
            ]);
            
            $validate->password = Hash::make($validate->password);

            if ($this->model->create((array) $validate) == null) {
                throw new Exception('failed to store');
            }   
            DB::commit();

            return redirect('/auth/login')
                ->with('success', 'Register Successfully');
        } catch(Exception $e) {
            DB::rollBack();
        }   
    }

    public function showRegister()
    {
        return view('auth.auth', [
            'page' => 'register'
        ]);
    }

    public function login(Request $request)
    {
        try {
            $validate = (object) $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8'
            ], [
                'email.email' => 'Email tidak valid.',
                'password.min' => 'Password minimal 8 karakter.'
            ]);
            
            if (Auth::attempt((array) $validate)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            return back()->with('loginError', 'Login Failed');
        } catch(Exception $e) {
            return back()->with('loginError', 'Login Failed');
        }
    }

    public function showLogin()
    {
        return view('auth.auth', [
            'page' => 'login'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
