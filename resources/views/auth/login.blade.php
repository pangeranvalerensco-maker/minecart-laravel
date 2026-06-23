@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem;">
        <h1>Masuk</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; justify-content: center;">
            <div style="width: 100%; max-width: 400px;">
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                        
                        <div style="margin-bottom: 12px;">
                            <label for="email" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                            @error('email') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label for="password" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Password</label>
                            <input type="password" id="password" name="password" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                            @error('password') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span style="font-size: 0.85rem;">Ingat Saya</span>
                            </label>
                        </div>

                        <button type="submit" class="cta-button" style="width: 100%; font-size: 1rem; margin-bottom: 15px;">
                            Masuk
                        </button>
                        
                        <div style="text-align: center; font-size: 0.85rem;">
                            Belum punya akun? <a href="{{ route('register') }}" style="color: var(--accent-color); text-decoration: none; font-weight: 500;">Daftar di sini</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
