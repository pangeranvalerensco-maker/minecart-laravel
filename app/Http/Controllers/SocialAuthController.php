<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // User exists, update google_id if missing
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                Auth::login($user);
            } else {
                // New user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => null, // No password for social login
                    // Some defaults for our e-commerce flow
                    'phone' => '-',
                    'address' => '-',
                    'city' => '-',
                    'postal_code' => '-',
                    'dob' => '2000-01-01',
                    'gender' => 'male',
                ]);

                Auth::login($user);
            }

            return redirect()->intended(route('home'))->with('success', 'Berhasil login dengan Google.');

        } catch (\Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['email' => 'Gagal login menggunakan Google. Silakan coba lagi.']);
        }
    }
}
