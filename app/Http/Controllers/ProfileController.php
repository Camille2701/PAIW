<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $section = $request->input('section');

        switch ($section) {
            case 'personal':
                return $this->updatePersonal($request, $user);
            case 'address':
                return $this->updateAddress($request, $user);
            default:
                return redirect()->route('profile')->with('error', 'Section invalide.');
        }
    }

    private function updatePersonal(Request $request, $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Informations personnelles mises à jour avec succès !');
    }

    private function updateAddress(Request $request, $user)
    {
        $validated = $request->validate([
            'street' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'department' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Adresse mise à jour avec succès !');
    }
}
