@extends('layouts.app')

@section('title', 'Akun Saya')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem;">
        <h1>Akun Saya</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; gap: 30px; flex-wrap: wrap;">
            
            <div style="width: 250px; flex-shrink: 0;">
                <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="{{ route('account.index') }}" style="color: var(--accent-color); font-weight: 500; text-decoration: none;">Profil Saya</a></li>
                        <li><a href="{{ route('account.orders') }}" style="color: var(--text-color); font-weight: 500; text-decoration: none;" data-translate-key="order-history">Riwayat Pesanan</a></li>
                        <li>
                            @if(auth()->user()->is_seller)
                                <a href="{{ route('seller.products.index') }}" style="color: var(--text-color); font-weight: 500; text-decoration: none;">Toko Saya</a>
                            @else
                                <a href="{{ route('store.create') }}" style="color: var(--text-color); font-weight: 500; text-decoration: none;">Buka Toko</a>
                            @endif
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #e63946; cursor: pointer; padding: 0; font-family: inherit; font-size: 1rem; text-decoration: underline;">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <form action="{{ route('account.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                        <h2 style="font-family: var(--font-heading); font-size: 1.1rem; color: var(--heading-color); margin: 0 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Profil Pengguna</h2>

                        <div style="margin-bottom: 12px;">
                            <label for="name" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                            @error('name') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label for="email" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                            @error('email') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                            <div style="flex: 1;">
                                <label for="dob" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;" data-translate-key="label-dob">Tanggal Lahir</label>
                                <input type="date" id="dob" name="dob" value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}" style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                                @error('dob') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                            <div style="flex: 1;">
                                <label style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;" data-translate-key="label-gender">Jenis Kelamin</label>
                                <div style="display: flex; gap: 15px; margin-top: 10px;">
                                    <label style="display: flex; align-items: center; gap: 5px; font-size: 0.9rem; cursor: pointer;">
                                        <input type="radio" name="gender" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }} style="accent-color: var(--accent-color);">
                                        <span data-translate-key="gender-male">Pria</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 5px; font-size: 0.9rem; cursor: pointer;">
                                        <input type="radio" name="gender" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }} style="accent-color: var(--accent-color);">
                                        <span data-translate-key="gender-female">Wanita</span>
                                    </label>
                                </div>
                                @error('gender') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label for="phone" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                            @error('phone') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label for="address" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Alamat Lengkap</label>
                            <textarea id="address" name="address" rows="3" style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; resize: vertical; box-sizing: border-box;">{{ old('address', $user->address) }}</textarea>
                            @error('address') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                            <div style="flex: 1;">
                                <label for="city" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Kota</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                                @error('city') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                            <div style="width: 120px;">
                                <label for="postal_code" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                                @error('postal_code') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <button type="submit" class="cta-button">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
