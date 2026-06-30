<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('account.index', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
        ]);

        $user->update($validated);

        return redirect()->route('account.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
