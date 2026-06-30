@extends('layouts.app')

@section('title', 'Buat Password Baru')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem; text-align: center;">
        <h1>Buat Password Baru</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; justify-content: center;">
            <div style="width: 100%; max-width: 420px;">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 35px 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.05)';">
                        
                        <div style="text-align: center; margin-bottom: 25px;">
                            <div style="width: 65px; height: 65px; background: rgba(61, 206, 196, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                <svg width="30" height="30" fill="var(--primary-color)" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                            </div>
                            <h2 style="font-size: 1.4rem; margin-bottom: 8px; font-weight: 700;">Buat Password Baru</h2>
                            <p style="color: #64748b; font-size: 0.95rem; line-height: 1.5;">
                                Amankan akun Anda dengan password baru yang kuat.
                            </p>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label for="password" style="display: block; font-size: 0.85rem; margin-bottom: 8px; font-weight: 600; color: var(--text-color);">Password Baru</label>
                            <input type="password" id="password" name="password" required autofocus style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(61, 206, 196, 0.2)';" onblur="this.style.borderColor='var(--subtle-border-color)'; this.style.boxShadow='none';">
                            @error('password')
                                <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label for="password_confirmation" style="display: block; font-size: 0.85rem; margin-bottom: 8px; font-weight: 600; color: var(--text-color);">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(61, 206, 196, 0.2)';" onblur="this.style.borderColor='var(--subtle-border-color)'; this.style.boxShadow='none';">
                        </div>

                        <button type="submit" class="cta-button" style="width: 100%; font-size: 1rem; padding: 12px; border-radius: 8px; font-weight: 600;">
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
