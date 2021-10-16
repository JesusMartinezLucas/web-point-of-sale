<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $users = User::paginate(20);

        return view('users.index', compact('users'));

    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|required|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin'),
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('users.index');

    }

    public function edit(User $user){
        //TODO: Validar que el usuario se la sesión sea administrador o que sea el mismo que se va a actualizar
        
        return $user;
        // return view('users.edit', compact('user'));
    }
}
