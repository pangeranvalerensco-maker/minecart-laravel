@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem; text-align: center;">
        <h1>Lupa Password</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; justify-content: center;">
            <div style="width: 100%; max-width: 420px;">
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.05)';">
                        
                        <div style="text-align: center; margin-bottom: 25px;">
                            <div style="width: 60px; height: 60px; background: rgba(61, 206, 196, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                <svg width="30" height="30" fill="var(--primary-color)" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                            </div>
                            <h2 style="font-size: 1.4rem; margin-bottom: 8px; font-weight: 700;">Lupa Password?</h2>
                            <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5;">Masukkan email terdaftar Anda. Kami akan mengirimkan kode OTP untuk mengatur ulang password Anda.</p>
                        </div>

                        @if(session('success'))
                            <div style="background-color: #f0fdf4; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; border: 1px solid #bbf7d0;">
                                {{ session('success') }}
                            </div>
                        @endif

                        @error('email')
                            <div style="background-color: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; border: 1px solid #fecaca;">
                                {{ $message }}
                            </div>
                        @enderror

                        <div style="margin-bottom: 25px;">
                            <label for="email" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);">Email Anda</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(61, 206, 196, 0.2)';" onblur="this.style.borderColor='var(--subtle-border-color)'; this.style.boxShadow='none';">
                        </div>

                        <button type="submit" class="cta-button" style="width: 100%; font-size: 1rem; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
                            Kirim Kode OTP
                        </button>

                        <div style="text-align: center; font-size: 0.9rem;">
                            Kembali ke <a href="{{ route('login') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Halaman Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
