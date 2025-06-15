<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show the signup form
    public function showSignupForm()
    {
        return view('user.signup1');
    }
    public function landing()
    {
        return view('user.landing');
    }
    public function showSearch()
    {
        return view('produk.search');
    }

    // Handle the signup process
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        Auth::login($user);

        return redirect()->route('index.index')->with('success', 'Account created successfully.');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('user.login1');
    }

    public function toko()
    {
        return view('user.toko');
    }

    // Handle the login process
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('index.index')->with('success', 'Logged in successfully.');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Log the user out
    public function logout()
    {
        Auth::logout();
        return redirect()->route('landing')->with('success', 'Logged out successfully.');
    }

    public function showProfile()
    {
        $produk = Produk::all();
        return view('user.profile', compact('produk'));
        
    
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the user's information
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePictureName = time() . '.' . $profilePicture->extension();
            $profilePicture->move(public_path('images'), $profilePictureName);
            $user->profile_picture = $profilePictureName;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }

}

?>