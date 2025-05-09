<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
        // Check if the password contains '@adlab'
        // This is a simple check, you might want to use a more secure method
        // if (strpos($request->password, '@adlab') === false) {
        //     return redirect()->back()->withErrors([
        //         'password' => 'You cannot access. Contact Adlab Factory .',
        //     ])->withInput($request->except('password'));
        // }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the "Freelancer" role to the user
        $user->assignRole('Freelancer');

        // Log the user in
        Auth::login($user);

        // Fire the registered event
        event(new Registered($user));

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }
}
