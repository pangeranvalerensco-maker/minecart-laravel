<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OtpPasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Delete existing OTPs for this email
        PasswordResetOtp::where('email', $request->email)->delete();

        // Generate 6 digit OTP
        $otp = rand(100000, 999999);

        // Save OTP
        PasswordResetOtp::create([
            'email' => $request->email,
            'otp_code' => $otp,
            'expires_at' => Carbon::now()->addMinutes(15), // Valid for 15 minutes
        ]);

        // Send OTP via Email
        try {
            Mail::to($request->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('OTP Mail Error: ' . $e->getMessage());
            // Log it in case of local testing without mail server
            \Log::info("OTP for {$request->email} is {$otp}");
        }

        return redirect()->route('password.verify.form', ['email' => $request->email])
                         ->with('success', 'OTP telah dikirimkan ke email Anda.');
    }

    public function showVerifyForm(Request $request)
    {
        if (!$request->has('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.passwords.verify', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|numeric|digits:6',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid.']);
        }

        if (Carbon::now()->isAfter($otpRecord->expires_at)) {
            $otpRecord->delete();
            return back()->withErrors(['otp_code' => 'Kode OTP telah kedaluwarsa. Silakan minta ulang.']);
        }

        // OTP is valid, proceed to reset password
        // Store email in session to verify next step
        session(['reset_email' => $request->email]);
        
        // Delete the used OTP
        $otpRecord->delete();

        return redirect()->route('password.reset.form');
    }

    public function showResetForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.passwords.reset', ['email' => session('reset_email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (session('reset_email') !== $request->email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Akses tidak sah.']);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Password Anda telah berhasil direset. Silakan login.');
    }
}
