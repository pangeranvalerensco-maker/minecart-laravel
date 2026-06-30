@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem; text-align: center;">
        <h1>Login</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; justify-content: center;">
            <div style="width: 100%; max-width: 420px;">
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.05)';">
                        
                        <div style="text-align: center; margin-bottom: 25px;">
                            <h2 style="font-size: 1.5rem; margin-bottom: 8px; font-weight: 700; color: var(--heading-color);" data-translate-key="login-welcome">Selamat Datang!</h2>
                            <p style="color: var(--text-color); font-size: 0.9rem;" data-translate-key="login-desc">Silakan masuk ke akun MineCart Anda.</p>
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label for="email" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';" onblur="this.style.borderColor='var(--subtle-border-color)';">
                            @error('email') <p style="color: #ef4444; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label for="password" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);" data-translate-key="login-password">Kata Sandi</label>
                            <input type="password" id="password" name="password" required style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';" onblur="this.style.borderColor='var(--subtle-border-color)';">
                            @error('password') <p style="color: #ef4444; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="accent-color: var(--accent-color);">
                                <span style="font-size: 0.85rem; color: var(--text-color);" data-translate-key="login-remember">Ingat Saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" style="font-size: 0.85rem; color: var(--accent-color); text-decoration: none; font-weight: 600;" data-translate-key="login-forgot">Lupa Kata Sandi?</a>
                        </div>

                        <button type="submit" class="cta-button" style="width: 100%; background: var(--accent-color); color: var(--accent-text-color); border: none; font-size: 1rem; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;" data-translate-key="login-submit">
                            Masuk
                        </button>

                        <div style="text-align: center; margin-bottom: 20px; position: relative;">
                            <hr style="border: 0; border-top: 1px solid var(--subtle-border-color); margin: 15px 0;">
                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: var(--card-bg); padding: 0 15px; font-size: 0.8rem; color: var(--text-color); font-weight: 500;" data-translate-key="login-or">ATAU</span>
                        </div>

                        <a href="{{ route('google.login') }}" style="display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 12px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); text-decoration: none; font-weight: 600; font-size: 0.95rem; margin-bottom: 25px; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02);" onmouseover="this.style.background='var(--subtle-border-color)';" onmouseout="this.style.background='var(--body-bg)';">
                            <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Lanjutkan dengan Google
                        </a>
                        
                        <div style="text-align: center; font-size: 0.9rem; color: var(--text-color);">
                            <span data-translate-key="login-no-account">Belum punya akun?</span> <a href="{{ route('register') }}" style="color: var(--accent-color); text-decoration: none; font-weight: 600;" data-translate-key="login-register">Daftar di sini</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
