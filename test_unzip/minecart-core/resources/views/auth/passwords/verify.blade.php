@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem; text-align: center;">
        <h1>Verifikasi OTP</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; justify-content: center;">
            <div style="width: 100%; max-width: 420px;">
                <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 35px 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.05)';">
                    
                    <div style="text-align: center; margin-bottom: 25px;">
                        <div style="width: 65px; height: 65px; background: rgba(61, 206, 196, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <span style="font-size: 2rem;">✉️</span>
                        </div>
                        <h2 style="font-size: 1.4rem; margin-bottom: 8px; font-weight: 700;">Cek Email Anda</h2>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.5;">
                            Kami telah mengirimkan 6 digit kode OTP ke email:<br>
                            <strong style="color: var(--text-color);">{{ $email }}</strong>
                        </p>
                    </div>

                    @if(session('success'))
                        <div style="background-color: #f0fdf4; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; border: 1px solid #bbf7d0;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @error('otp_code')
                        <div style="background-color: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; border: 1px solid #fecaca;">
                            {{ $message }}
                        </div>
                    @enderror

                    <form action="{{ route('password.verify') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <div style="margin-bottom: 25px;">
                            <input type="text" id="otp_code" name="otp_code" maxlength="6" required autofocus placeholder="------" style="width: 100%; padding: 15px; border: 2px solid var(--primary-color); border-radius: 8px; background: rgba(var(--primary-color-rgb), 0.02); color: var(--text-color); font-family: monospace; font-size: 2rem; letter-spacing: 12px; text-align: center; box-sizing: border-box; font-weight: bold; transition: all 0.2s; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);" onfocus="this.style.boxShadow='0 0 0 4px rgba(61, 206, 196, 0.2)';">
                        </div>

                        <button type="submit" class="cta-button" style="width: 100%; font-size: 1rem; padding: 12px; border-radius: 8px; margin-bottom: 25px; font-weight: 600;">
                            Verifikasi
                        </button>
                    </form>

                    <div style="text-align: center; font-size: 0.9rem; border-top: 1px solid var(--subtle-border-color); padding-top: 20px;">
                        <span style="color: #64748b;">Tidak menerima email?</span>
                        <form action="{{ route('password.email') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button type="submit" style="background: none; border: none; color: var(--primary-color); font-weight: 600; cursor: pointer; padding: 0 0 0 5px; font-family: inherit;">Kirim ulang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
